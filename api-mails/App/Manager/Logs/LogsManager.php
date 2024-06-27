<?php

namespace Mails\Manager\Logs;

use Mails\Manager\Class\AbstractManager;
use Mails\Manager\Database\DatabaseManager;
use Mails\Manager\Env\EnvManager;

class LogsManager extends AbstractManager
{
    public function emit(int $status, string $service, string $request, ?string $error): void
    {
        $executionTime = microtime(true) - $_SERVER['request_execution_time_start'];

        $env = EnvManager::getInstance();
        $host = $env->getValue("DB_HOST");
        $user = $env->getValue("DB_USERNAME");
        $pass = $env->getValue("DB_PASSWORD");

        $db = DatabaseManager::getCustomMysqlInstance($host, $user, $pass, 'logs', 3306);

        $data = [
            'status' => $status,
            'service' => $service,
            'request' => $request,
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'execution_time' => $executionTime,
            'error' => $error,
        ];

        $sql = "INSERT INTO logs.logs (status_code, service, request, method, execution_time, error) 
                    VALUES (:status, :service, :request, :method, :execution_time, :error)";


        $db->prepare($sql)->execute($data);
    }
}