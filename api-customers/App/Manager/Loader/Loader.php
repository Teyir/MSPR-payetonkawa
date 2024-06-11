<?php

namespace Customers\Manager\Loader;

use ReflectionClass;
use Customers\Manager\Class\ServiceManager;
use Customers\Manager\Error\ErrorManager;
use Customers\Manager\Router\Link;
use Customers\Manager\Router\Router;
use Customers\Utils\Directory;

class Loader
{
    private static array $fileLoadedAttr = [];
    private static array $attributeList = [];

    public static function loadProject(bool $isTestLoading): void
    {
        require_once("AutoLoad.php");

        if ($isTestLoading){
            AutoLoad::testLoad();
        } else {
            AutoLoad::load();
        }
    }

    private static function &getAttributeListPointer(): array
    {
        return self::$attributeList;
    }

    public static function getAttributeList(): array
    {
        return self::$attributeList;
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
        Router::getInstance()->listen();
    }

    public static function loadRoutes($linkClass = Link::class): void
    {
        $attrList = self::getAttributeList()[$linkClass] ?? [];

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
        $files = Directory::getFilesRecursively("App/Service", "php");

        foreach ($files as $file) {
            self::listAttributes($file);
        }
    }

    /**
     * @throws \ReflectionException
     */
    public static function listAttributes(string $file): void
    {
        if (in_array($file, self::$fileLoadedAttr, true)) {
            return;
        }

        $className = ServiceManager::getClassNamespaceFromPath($file);

        if (is_null($className)) {
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