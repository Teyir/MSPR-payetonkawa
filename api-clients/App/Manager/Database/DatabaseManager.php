<?php

namespace Clients\Manager\Database;

use Exception;
use PDO;
use Clients\Manager\Env\EnvManager;

class DatabaseManager
{
    protected static ?PDO $_instance = null;

    /**
     * @return \PDO
     */
    public static function getInstance(): PDO
    {
        if (!is_null(self::$_instance)) {
            return self::$_instance;
        }

        try {
            $env = EnvManager::getInstance();
            $host = $env->getValue("DB_HOST");
            $user = $env->getValue("DB_USERNAME");
            $pass = $env->getValue("DB_PASSWORD");

            self::$_instance = new PDO("mysql:host=" . $host . ";charset=utf8mb4", $user, $pass, [
                PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
            ]);

            self::$_instance->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            self::$_instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$_instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            self::$_instance->exec("SET CHARACTER SET utf8mb4");
            self::$_instance->exec("USE " . $env->getValue("DB_NAME") . ";");
            return self::$_instance;
        } catch (Exception $e) {
            die("DATABASE ERROR" . $e->getMessage());
        }
    }

    /**
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $name
     * @param int $port
     * @param array $options => <b>Options are PDO options, like: <e>[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]</e></b>
     * @return \PDO
     * @desc Use a custom mysql PDO instance
     */
    public static function getCustomMysqlInstance(string $host, string $username, string $password, string $name, int $port, array $options = []): PDO
    {
        $db = new PDO("mysql:host=$host;port=$port", $username, $password, $options);
        $db->exec("SET CHARACTER SET utf8");
        $db->exec("CREATE DATABASE IF NOT EXISTS " . $name . ";");
        $db->exec("USE " . $name . ";");

        return $db;
    }

    /**
     * @param string $file
     * @param array $options
     * @param bool $createMemoryDb
     * @return \PDO
     */
    public static function getCustomSqLiteInstance(string $file = "db.sqlite3", array $options = [], bool $createMemoryDb = false): PDO
    {
        if ($createMemoryDb) {
            $db = new PDO("sqlite::memory:", $options);
        } else {
            $db = new PDO("sqlite:$file", $options);
        }

        return $db;
    }
}