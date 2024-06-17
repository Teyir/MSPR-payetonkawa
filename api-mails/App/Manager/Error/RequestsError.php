<?php

namespace Mails\Manager\Error;

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
                http_response_code(431);
                break;
            case RequestsErrorsTypes::NON_AUTHORIZED_REQUEST:
                $error = "non authorized request";
                http_response_code(401);
                break;
            case RequestsErrorsTypes::FORBIDDEN:
                $error = "forbidden";
                http_response_code(403);
                break;
            case RequestsErrorsTypes::INVALID_REQUEST:
                $error = "invalid request";
                http_response_code(400);
                break;
            case RequestsErrorsTypes::WRONG_PARAMS:
                $error = "wrong params";
                http_response_code(400);
                break;
            case RequestsErrorsTypes::INTERNAL_SERVER_ERROR:
                $error = "internal server error";
                http_response_code(500);
                break;
            case RequestsErrorsTypes::NOT_FOUND:
                $error = "not found";
                http_response_code(404);
                break;
            case RequestsErrorsTypes::CONTENT_ALREADY_EXIST:
                $error = "content already exist";
                http_response_code(409);
                break;
            case RequestsErrorsTypes::PAGE_EXPIRED:
                $error = "page expired";
                http_response_code(419);
                break;
            case RequestsErrorsTypes::TOO_MANY_REQUESTS:
                $error = "too many requests";
                http_response_code(429);
                break;
        }

        $return['error']['code'] = $code;
        $return['error']['info'] = $error;

        if ($moreInformations !== []) {
            $return['error']['description'] = $moreInformations;
        }

        try {
            print(json_encode($return, JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            print($e);
        }

        // Store logs
        //(new LogsManager())->storeLogs(); //TODO

        die();
    }
}