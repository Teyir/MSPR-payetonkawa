<?php

namespace Products\Manager\Requests;

use JetBrains\PhpStorm\NoReturn;
use JsonException;

class RequestsManager
{
    #[NoReturn] public static function returnData(array $toReturn): void
    {
        try {
            // Return header
            $toReturn === [] || empty($toReturn) ? http_response_code(204) : http_response_code(200);
            // Return data
            print(json_encode($toReturn, JSON_THROW_ON_ERROR));

            // Store logs
            //(new LogsManager())->storeLogs(); //TODO

        } catch (JsonException $e) {
            print($e);
        }
        die();
    }
}