<?php

namespace Customers\Manager\Class;

class ServiceManager
{

    private static function getElementNameByPathPart(string $elementNameFromPath): ?string
    {

        return match ($elementNameFromPath) {
            "Controllers" => "Controller",
            "Models" => "Model",
            "Entities" => "Entity",
            default => null
        };
    }

    private static function getStartDirFromElementName(string $elementName): ?string
    {
        return match ($elementName) {
            "Controller", "Model", "Entity" => "App/Package/",
            "Manager" => "App/Manager/",
            "Utils" => "App/Utils/",
            default => null,
        };
    }

    public static function getClassNamespaceFromPath(string $path): ?string
    {
        $prefix = "Customers";

        $PACKAGE_POSITION = 3;
        $PART_POSITION = 2;
        $CLASSNAME_POSITION = 1;

        $fileParts = explode(DIRECTORY_SEPARATOR, $path);
        $package = $fileParts[count($fileParts) - $PACKAGE_POSITION];
        $element = self::getElementNameByPathPart($fileParts[count($fileParts) - $PART_POSITION]);
        $className = explode(".php", $fileParts[count($fileParts) - $CLASSNAME_POSITION])[0];

        if ($element === null) {
            return null;
        }

        return "$prefix\\$element\\$package\\$className";
    }

}