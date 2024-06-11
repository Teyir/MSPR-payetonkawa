<?php

namespace Clients\Manager\Security;

use Clients\Manager\Env\EnvManager;
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

    /**
     * @return bool
     * @desc Check if the current user has the security token
     */
    private static function isAuthorized(): bool
    {
        $authorizationKey = self::getAuthorizationKey();

        return EnvManager::getInstance()->getValue('TOKEN') === $authorizationKey;
    }

    /**
     * @return string|null
     * @desc Get Authorization token from client headers.
     */
    private static function getAuthorizationKey(): ?string
    {
        $headers = apache_request_headers();
        $authorizationKey = $headers['Authorization'] ?? null;

        if (is_null($authorizationKey)) {
            return null;
        }

        return FilterManager::filterData($authorizationKey);
    }

}
