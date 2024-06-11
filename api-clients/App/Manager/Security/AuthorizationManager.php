<?php

namespace Clients\Manager\Security;

use Clients\Manager\Error\RequestsError;
use Clients\Manager\Error\RequestsErrorsTypes;

class AuthorizationManager
{

    public static function handleAuthorization(): void
    {

        if (self::isAuthorized()) {
            return;
        }

        RequestsError::returnError(RequestsErrorsTypes::NON_AUTHORIZED_REQUEST);
    }

    private static function isAuthorized(): bool
    {
        return true; //TODO JWT CHECK¬
    }

}
