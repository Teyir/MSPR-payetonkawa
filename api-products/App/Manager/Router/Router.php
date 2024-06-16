<?php

namespace Products\Manager\Router;

use Products\Manager\Cache\CacheManager;
use Products\Manager\Error\RequestsError;
use Products\Manager\Error\RequestsErrorsTypes;
use Products\Manager\Requests\RequestsManager;
use Products\Manager\Security\FilterManager;
use Products\Manager\Version\VersionManager;
use Closure;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\NoReturn;
use ReflectionMethod;

class Router
{

    private string $url;

    /** @var Route[] $routes */
    private array $routes = [];

    /** @var Route[] $namedRoutes */
    private array $namedRoutes = [];

    private static ?Route $actualRoute = null;

    private string $groupPattern;

    private static Router $_instance;

    public function __construct($url)
    {
        $this->url = $url;
    }

    private function registerNewRoute(Link $link, ReflectionMethod $method, #[ExpectedValues(flagsFromClass: LinkTypes::class)] $type): Route
    {
        return $this->add($link->getPath(), function (...$values) use ($link, $method) {

            $this->callRegisteredRoute($method, $link, ...$values);
        }, name: $link->getName(), method: $type, isUsingCache: $link->isUsingCache(), weight: $link->getWeight(), version: $link->getVersion());
    }

    /**
     * @throws \ReflectionException
     */
    #[NoReturn] private function callRegisteredRoute(ReflectionMethod $method, Link $link, string ...$values): void
    {
        $classInstance = $method->getDeclaringClass()->getMethod("getInstance")->invoke(null);

        if (!isset($_GET['url']) || !$link->isUsingCache() || $link->getMethod() !== LinkTypes::GET) {
            RequestsManager::returnData($method->invoke($classInstance, ...$values));
        }

        $cache = new CacheManager($link->getScope(), FilterManager::filterUrl($_GET['url'], true));

        if ($cache->checkCache()) {
            RequestsManager::returnData($cache->getCache());
        }
        $data = $method->invoke($classInstance, ...$values);

        if ($data !== []) {
            $cache->storeCache($data);
        }

        RequestsManager::returnData($data);
    }

    private function generateRouteName(ReflectionMethod $method): string
    {
        $class = strtolower(str_replace("Controller", "", $method->getDeclaringClass()->getShortName()));
        return "$class.{$method->getName()}";
    }

    public static function getInstance(): Router
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Router($_GET['url'] ?? "");
        }

        return self::$_instance;
    }

    public static function getActualRoute(): ?Route
    {
        return self::$actualRoute;
    }

    public static function setActualRoute(?Route $actualRoute): void
    {
        self::$actualRoute = $actualRoute;
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @return Route[]
     */
    public function getRoutesByName(): array
    {
        return $this->namedRoutes;
    }

    public function addRoute(Route $route, string $method): void
    {
        $this->routes[$method][] = $route;
        $this->namedRoutes[$route->getName()] = &$route;
    }

    private function add(string $path, Closure $callable, string $name, string $method, bool $isUsingCache, int $weight = 1, ?int $version = null): Route
    {
        if (!empty($this->groupPattern)) {
            $path = $this->groupPattern . $path;
        }

        $name = $name ?: uniqid('route-', true);

        $path = VersionManager::getInstance()->getVersionSlug($version) . $path;

        $route = new Route($path, $callable, $isUsingCache, $weight, $name);

        $this->addRoute($route, $method);

        return $route;
    }

    public function scope($groupPattern, Closure $routes): void
    {
        $this->groupPattern = $groupPattern;
        $routes($this);
        unset($this->groupPattern);
    }

    public function listen(): mixed
    {
        if (!isset($this->getRoutes()[$_SERVER['REQUEST_METHOD']])) {
            RequestsError::returnError(RequestsErrorsTypes::NOT_FOUND, ['url' => $this->url]);
        }

        $matchedRoute = $this->getRouteByUrl($this->url);

        if (is_null($matchedRoute)) {
            RequestsError::returnError(RequestsErrorsTypes::NOT_FOUND, ['url' => $this->url]);
        }

        self::setActualRoute($matchedRoute);
        return $matchedRoute->call();
    }

    public function getRouteByUrl(string $url): ?Route
    {
        $matchedRoute = null;
        foreach ($this->getRoutes()[$_SERVER['REQUEST_METHOD']] as $route) {
            /** @var Route $route */
            if ($route->match($url)) {
                if (is_null($matchedRoute) || $route->getWeight() > $matchedRoute->getWeight()) {
                    $matchedRoute = $route;
                }
            }
        }

        return $matchedRoute;
    }

    public function getRouteByName($name): ?Route
    {
        return $this->namedRoutes[$name] ?? null;
    }

    public function registerRoute(Link $link, ReflectionMethod $method): void
    {
        if (!is_null($link->getScope())) {
            $this->scope($link->getScope(), function () use ($link, $method) {
                $newLink = new Link($link->getPath(), $link->getMethod(), $link->getVariables(), null, $link->getWeight(), $link->getName(), $link->isAdminRestricted(), $link->isUsingCache(), $link->getVersion());
                $this->registerRoute($newLink, $method);
            });

            return;
        }

        $link->setName($this->generateRouteName($method));

        $router = $this->registerNewRoute($link, $method, $link->getMethod());

        $regexValues = $link->getVariables();
        foreach ($regexValues as $value => $regex) {
            $router->with($value, $regex);
        }

    }

}