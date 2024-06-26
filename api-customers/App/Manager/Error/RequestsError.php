<?php

namespace Customers\Manager\Error;

use Customers\Manager\Logs\LogsManager;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\NoReturn;
use JsonException;

class RequestsError
{

    #[NoReturn] public static function returnError(#[ExpectedValues(flagsFromClass: RequestsErrorsTypes::class)] $code, array $moreInformations = []): void
    {
        header('Content-type: application/json;charset=utf-8');

        $error = "";
        switch ($code) {
            case RequestsErrorsTypes::OVERLOAD_REQUEST:
                $error = "overload request";
                $statusCode = 431;
                break;
            case RequestsErrorsTypes::NON_AUTHORIZED_REQUEST:
                $error = "non authorized request";
                $statusCode = 401;
                break;
            case RequestsErrorsTypes::FORBIDDEN:
                $error = "forbidden";
                $statusCode = 403;
                break;
            case RequestsErrorsTypes::INVALID_REQUEST:
                $error = "invalid request";
                $statusCode = 400;
                break;
            case RequestsErrorsTypes::WRONG_PARAMS:
                $error = "wrong params";
                $statusCode = 400;
                break;
            case RequestsErrorsTypes::INTERNAL_SERVER_ERROR:
                $error = "internal server error";
                $statusCode = 500;
                break;
            case RequestsErrorsTypes::NOT_FOUND:
                $error = "not found";
                $statusCode = 404;
                break;
            case RequestsErrorsTypes::CONTENT_ALREADY_EXIST:
                $error = "content already exist";
                $statusCode = 409;
                break;
            case RequestsErrorsTypes::PAGE_EXPIRED:
                $error = "page expired";
                $statusCode = 419;
                break;
            case RequestsErrorsTypes::TOO_MANY_REQUESTS:
                $error = "too many requests";
                $statusCode = 429;
                break;
        }
        http_response_code($statusCode ?? 500);

        $return['error']['code'] = $code;
        $return['error']['info'] = $error;

        if ($moreInformations !== []) {
            $return['error']['description'] = $moreInformations;
        }

        LogsManager::getInstance()->emit(
            $statusCode ?? 500,
            'Customers',
            $_GET['url'] ?? '/',
            json_encode($return, JSON_THROW_ON_ERROR),
        );

        try {
            print(json_encode($return, JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            print($e);
        }

        die();
    }
}