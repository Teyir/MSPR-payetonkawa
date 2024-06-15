<?php

namespace WEB\Manager\Class;

class PackageManager
{

    /**
     * @param array{string} $fileParts
     * @return array{?string, int} returns the element name and the position of the element name in the array, [null, -1] if not found
     */
    private static function retrieveElementName(array $fileParts): array
    {
        $elementPosition = 0;
        foreach ($fileParts as $filePart) {
            if (self::getElementNameByPathPart($filePart) !== null) {
                break;
            }
            $elementPosition++;
        }

        if ($elementPosition >= count($fileParts)) {
            return [null, -1];
        }

        return [self::getElementNameByPathPart($fileParts[$elementPosition]), $elementPosition];
    }

    private static function getElementNameByPathPart(string $elementNameFromPath): ?string
    {
        return match ($elementNameFromPath) {
            "Controllers" => "Controller",
            "Models" => "Model",
            "Entities" => "Entity",
            "Implementations" => "Implementation",
            "Interfaces" => "Interface",
            default => null
        };
    }

    public static function getClassNamespaceFromPath(string $path): ?string
    {
        $fileParts = explode(DIRECTORY_SEPARATOR, $path);

        [$element, $basePosition] = self::retrieveElementName($fileParts);

        if ($element === null) {
            return null;
        }

        $PACKAGE_PREFIX = "WEB";
        $PACKAGE_POSITION = $basePosition - 1;
        $CLASSNAME_POSITION = $basePosition + 1;

        $package = $fileParts[$PACKAGE_POSITION];

        $classPath = array_slice($fileParts, $CLASSNAME_POSITION);
        $className = explode(".php", implode("\\", $classPath))[0];

        return "$PACKAGE_PREFIX\\$element\\$package\\$className";
    }
}