<?php

namespace Mails\Manager\Requests;

use Mails\Manager\Logs\LogsManager;
use JetBrains\PhpStorm\NoReturn;
use JsonException;

class RequestsManager
{
    #[NoReturn] public static function returnData(array $toReturn): void
    {
        try {
            $status = empty($toReturn) ? 204 : 200;

            // Return header
            $toReturn === [] || empty($toReturn) ? http_response_code(204) : http_response_code(200);
            // Return data
            print(json_encode($toReturn, JSON_THROW_ON_ERROR));

            // Store logs
            LogsManager::getInstance()->emit($status, 'Mails', $_GET['url'] ?? '/', null);

        } catch (JsonException $e) {
            print($e);
        }
        die();
    }
}