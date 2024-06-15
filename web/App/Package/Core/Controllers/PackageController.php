<?php

namespace WEB\Controller\Core;

use WEB\Manager\Package\AbstractController;
use WEB\Manager\Package\IPackageConfig;

class PackageController extends AbstractController
{

    public static array $corePackages = ['Core', 'Pages', 'Users'];

    /**
     * @return IPackageConfig[]
     * @desc Return packages they are not natives, like Core, Pages and Users
     */
    public static function getInstalledPackages(): array
    {
        $toReturn = [];
        $packagesFolder = 'App/Package/';
        $contentDirectory = array_diff(scandir("$packagesFolder/"), ['..', '.']);
        foreach ($contentDirectory as $package) {

            if (in_array($package, self::$corePackages, true)) {
                continue;
            }

            if (file_exists("$packagesFolder/$package/Package.php") && !in_array($package, self::$corePackages, true)) {
                $toReturn[] = self::getPackage($package);
            }
        }

        return $toReturn;
    }

    /**
     * @return IPackageConfig[]
     * @desc Return natives packages (core, users, pages) => self::$corePackages
     */
    public static function getCorePackages(): array
    {
        $toReturn = [];
        $packagesFolder = 'App/Package/';
        foreach (self::$corePackages as $package) {
            if (file_exists("$packagesFolder/$package/Package.php")) {
                $toReturn[] = self::getPackage($package);
            }
        }

        return $toReturn;
    }

    /**
     * @return IPackageConfig[]
     * @desc Return getCorePackages() and getInstalledPackages()
     */
    public static function getAllPackages(): array
    {
        return array_merge(self::getCorePackages(), self::getInstalledPackages());
    }

    public static function getPackage(string $packageName): ?IPackageConfig
    {
        $namespace = 'WEB\\Package\\' . $packageName . "\\Package";

        if (!class_exists($namespace)) {
            return null;
        }

        $classInstance = new $namespace();

        if (!is_subclass_of($classInstance, IPackageConfig::class)) {
            return null;
        }

        return $classInstance;
    }

    public static function isInstalled(string $package): bool
    {
        return self::getPackage($package) !== null;
    }
}
