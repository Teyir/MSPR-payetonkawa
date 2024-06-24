<?php

namespace Products\Manager\Documentation;

use Products\Manager\Class\AbstractManager;
use Products\Manager\Env\EnvManager;
use Products\Manager\Router\Link;
use Products\Manager\Router\Router;
use Products\Utils\Tools;
use ReflectionClass;
use ReflectionMethod;

class DocumentationManager extends AbstractManager
{
    public function __construct()
    {
        header('Content-type: text/html;charset=utf-8');

        $entities = [];

        foreach ($this->getServices() as $service) {
            foreach ($service as $item) {
                $entities[] = $this->getEntities($item::class);
            }
        }

        $this->includeViewFile($entities);
    }


    private function getServices(): array
    {
        $toReturn = [];
        $servicesFolder = 'App/Service/';
        $contentDirectory = array_diff(scandir($servicesFolder), ['..', '.']);

        foreach ($contentDirectory as $service) {
            Tools::addIfNotNull($toReturn, $this->getServiceControllers($service));
        }

        return $toReturn;
    }

    private function getServiceControllers(string $serviceName): array
    {
        $toReturn = [];

        $path = "App/Service/$serviceName/Controllers/";

        if (!is_dir($path)){
            return [];
        }

        $controllers = array_diff(scandir($path), ['..', '.']);

        foreach ($controllers as $controller) {
            $controller = str_replace(".php", "", $controller);

            $namespace = 'Products\\Controller\\' . $serviceName . "\\$controller";
            $instance = new $namespace();

            $toReturn[] = $instance;
        }

        return $toReturn;
    }


    /**
     * @param String $class
     * @return \Products\Manager\Documentation\DocumentationEntity[]
     * @throws \ReflectionException
     */
    private function getEntities(string $class): array
    {
        $c = new ReflectionClass($class);

        $toReturn = [];

        foreach ($c->getMethods() as $method) {
            $types = [];

            //Ignore singleton
            if ($method->getName() === "getInstance") {
                continue;
            }

            $parameters = $method->getParameters();

            foreach ($parameters as $parameter) {
                $types[] = new DocumentationTypesEntity(
                    $parameter->getType(),
                    $parameter->getName(),
                );
            }

            $route = Router::getInstance()->getRouteByName($this->getRouteName($method));

            //Skip methods without Link
            $attributes = $method->getAttributes(Link::class);
            if ($attributes === []){
                continue;
            }

            $link = $attributes[0]->newInstance();


            $toReturn[] = new DocumentationEntity(
                $method->getName(),
                "/" . $route?->getPath() ?? "ERROR",
                $types,
                $link->getMethod(),
                $route?->isUsingCache() ?? false,
                $route?->getWeight() ?? 0,
                $method->getDocComment() ?? ""
            );

        }

        return $toReturn;
    }

    private function getRouteName(ReflectionMethod $method): string
    {
        $class = strtolower(str_replace("Controller", "", $method->getDeclaringClass()->getShortName()));
        return "$class.{$method->getName()}";
    }

    /**
     * @param \Products\Manager\Documentation\DocumentationEntity[] $data
     * @return void
     */
    private function includeViewFile(array $data): void
    {
        $data;
        require_once EnvManager::getInstance()->getValue('DIR') . 'App/Manager/Documentation/documentation.inc.view.php';
    }
}