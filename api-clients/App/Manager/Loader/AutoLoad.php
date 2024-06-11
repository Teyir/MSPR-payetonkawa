<?php

namespace Clients\Manager\Loader;


use Clients\Manager\Env\EnvManager;
use Clients\Utils\Tools;

class AutoLoad
{
    public static array $findNameSpace = [];

    private static function isEnvValid(): bool
    {
        require_once("App/Manager/Env/EnvManager.php");
        return is_file(EnvManager::getInstance()->getValue("DIR") . "index.php");
    }

    private static function updateEnv(): void
    {
        EnvManager::getInstance()->setOrEditValue("DIR", dirname(__DIR__, 2) . "/");
        EnvManager::getInstance()->setOrEditValue("PATH_URL", Tools::getUrl());
    }

    private static function register(bool $isTestLoading): void
    {
        spl_autoload_register(static function (string $class) use ($isTestLoading) {

            $classPart = explode("\\", $class);

            if (in_array($class, get_declared_classes())) {
                return false;
            }

            if ($classPart[0] !== "Clients") {
                return false;
            }

            if ($isTestLoading) {
                return self::getTestElements($classPart, $classPart[1]);
            }

            return self::getElements($classPart, $classPart[1]);
        });
    }

    private static function getElements(array $namespace, string $elementName): ?string
    {
        $startDir = static function ($elementName) {
            return match ($elementName) {
                "Controller", "Model", "Entity" => "App/Service/",
                "Manager" => "App/Manager/",
                "Utils" => "App/Utils/",
                default => "",
            };
        };

        $folderService = static function ($elementName) {
            return match ($elementName) {
                "Controller" => "Controllers/",
                "Model" => "Models/",
                "Entity" => "Entities/",
                "Manager" => "",
            };
        };

        return match ($elementName) {
            "Utils" => self::callCoreClass($namespace, $startDir($elementName)),
            default => self::callService($namespace, $startDir($elementName), "/{$folderService($elementName)}")
        };
    }

    private static function getTestElements(array $namespace, string $elementName): ?string
    {
        $startDir = static function ($elementName) {
            return match ($elementName) {
                "Controller", "Model", "Entity" => dirname(__DIR__, 3) . "/App/Service/",
                "Manager" => dirname(__DIR__, 3) . "/App/Manager/",
                "Utils" => dirname(__DIR__, 3) . "/App/Utils/",
                default => "",
            };
        };

        $folderService = static function ($elementName) {
            return match ($elementName) {
                "Controller" => "Controllers/",
                "Model" => "Models/",
                "Entity" => "Entities/",
                "Manager" => "",
            };
        };

        return match ($elementName) {
            "Utils" => self::callCoreClass($namespace, $startDir($elementName)),
            default => self::callService($namespace, $startDir($elementName), "/{$folderService($elementName)}")
        };
    }


    private static function callService(array $classPart, string $startDir, string $folderService = ""): bool
    {
        if (empty($startDir) || count($classPart) < 4) {
            return false;
        }

        $namespace = implode('\\', $classPart);
        $serviceName = $classPart[2];
        $fileName = $classPart[count($classPart) - 1] . ".php";

        $subFolderFile = '';
        if (count($classPart) > 4) {
            $subFolderFile = implode('\\', array_slice($classPart, 3, -1)) . '\\';
        }


        $filePath = $startDir . $serviceName . $folderService . $subFolderFile . $fileName;

        if (!is_file($filePath)) {
            return false;
        }

        self::$findNameSpace[str_replace('/', '\\', $filePath)] = $namespace;

        require_once $filePath;
        return true;
    }

    private static function callCoreClass(array $classPart, string $startDir): bool
    {

        if (count($classPart) < 3) {
            return false;
        }

        $namespace = implode('\\', $classPart);

        $classPart = array_slice($classPart, 2);

        $fileName = array_pop($classPart) . ".php";

        $subFolderFile = count($classPart) ? implode("/", $classPart) . "/" : "";

        $filePath = $startDir . $subFolderFile . $fileName;

        if (!is_file($filePath)) {
            return false;
        }

        self::$findNameSpace[str_replace('/', '\\', $filePath)] = $namespace;

        require_once($filePath);
        return true;
    }

    public static function load(): void
    {
        if (!self::isEnvValid()) {
            self::updateEnv();
        }

        self::register(isTestLoading: false);
    }

    /**
     * @return void
     * @desc This method is only for testing
     */
    public static function testLoad(): void
    {
        require_once(dirname(__DIR__, 3) . "/App/Manager/Env/EnvManager.php");
        self::register(isTestLoading: true);
    }
}