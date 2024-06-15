<?php

namespace WEB\Manager\Loader;

use ReflectionClass;
use WEB\Controller\Core\PackageController;
use WEB\Manager\Class\PackageManager;
use WEB\Manager\Env\EnvManager;
use WEB\Manager\Error\ErrorManager;
use WEB\Manager\Router\Link;
use WEB\Manager\Router\Router;
use WEB\Manager\Router\RouterException;
use WEB\Manager\Views\View;
use WEB\Utils\Directory;

class Loader
{
    private static array $fileLoadedAttr = [];
    private static array $attributeList = [];

    public static function loadProject(): void
    {
        require_once("AutoLoad.php");
        AutoLoad::load();
    }

    private static function &getAttributeListPointer(): array
    {
        return self::$attributeList;
    }

    public static function getAttributeList(): array
    {
        return self::$attributeList;
    }

    public static function loadImplementations(string $interface): array
    {
        $toReturn = [];

        $packages = PackageController::getAllPackages();

        foreach ($packages as $package) {
            $implementationsFolder = EnvManager::getInstance()->getValue("dir") . "App/Package/{$package->name()}/Implementations";

            if (!is_dir($implementationsFolder)) {
                continue;
            }

            $implementationsFolders = array_diff(scandir($implementationsFolder), ['..', '.']);

            foreach ($implementationsFolders as $folder) {
                $implementationPackageFolder = $implementationsFolder . '/' . $folder;
                $implementationsFiles = array_diff(scandir($implementationPackageFolder), ['..', '.']);

                foreach ($implementationsFiles as $implementationsFile) {

                    $implementationsFilePath = EnvManager::getInstance()->getValue("dir") . "App/Package/" .
                        $package->name() . "/Implementations/" . $implementationsFile;

                    $className = pathinfo($implementationsFilePath, PATHINFO_FILENAME);

                    $namespace = 'WEB\\Implementation\\' . $package->name() . '\\' . $folder . '\\' . $className;

                    if (!class_exists($namespace)) {
                        continue;
                    }

                    $classInstance = new $namespace();

                    if (!is_subclass_of($classInstance, $interface)) {
                        continue;
                    }

                    $toReturn[] = $classInstance;
                }
            }
        }

        return $toReturn;
    }

    /**
     * @throws \ReflectionException
     */
    public static function manageErrors(): void
    {
        $errorClass = new ReflectionClass(ErrorManager::class);

        $errorClass->newInstance();
    }

    public static function listenRouter(): void
    {
        try {
            Router::getInstance()->listen();
        } catch (RouterException $e) {
            ErrorManager::showError($e->getCode());
            return;
        }
    }

    public static function loadRoutes($linkClass = Link::class): void
    {
        $attrList = self::getAttributeList()[$linkClass];

        if (!isset($attrList)) {
            return;
        }

        foreach ($attrList as [$attr, $method]) {
            $linkInstance = $attr->newInstance();
            Router::getInstance()->registerRoute($linkInstance, $method);
        }
    }

    /**
     * @throws \ReflectionException
     */
    public static function loadAttributes(): void
    {
        $files = Directory::getFilesRecursively("App/Package", "php");

        foreach ($files as $file) {
            self::listAttributes($file);
        }
    }

    public static function createSimpleRoute(string $path, string $fileName, string $package, ?string $name = null, int $weight = 2): void
    {
        Router::getInstance()->get($path, function () use ($package, $fileName) {
            View::basicPublicView($package, $fileName);
        }, $name, $weight);
    }

    /**
     */
    public static function listAttributes(string $file): void
    {
        if (in_array($file, self::$fileLoadedAttr, true)) {
            return;
        }

        $className = PackageManager::getClassNamespaceFromPath($file);

        if (is_null($className)) {
            return;
        }

        if (!class_exists($className)) {
            return;
        }

        $classRef = new ReflectionClass($className);
        foreach ($classRef->getMethods() as $method) {
            $isMethodClass = $method->getDeclaringClass()->getName() === $className;
            if (!$isMethodClass) {
                continue;
            }

            $attrList = $method->getAttributes();
            foreach ($attrList as $attribute) {

                if (!isset(self::getAttributeListPointer()[$attribute->getName()])) {
                    self::getAttributeListPointer()[$attribute->getName()] = [];
                }

                self::getAttributeListPointer()[$attribute->getName()][] = [$attribute, $method];
            }
        }

        self::$fileLoadedAttr[] = $file;
    }
}
