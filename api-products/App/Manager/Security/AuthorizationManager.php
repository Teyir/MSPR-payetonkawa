<?php

namespace Products\Manager\Security;

use Products\Manager\Version\VersionManager;
use Products\Manager\Env\EnvManager;
use Products\Manager\Error\RequestsError;
use Products\Manager\Error\RequestsErrorsTypes;

class AuthorizationManager
{
    public static function handleAuthorization(): void
    {
        if (isset($_GET['url']) && $_GET['url'] === "v" . VersionManager::VERSION) {
            return;
        }

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
        $authorizationKey = $_SERVER['HTTP_AUTHORIZATION'] ?? null;

        if (is_null($authorizationKey)) {
            return null;
        }

        return FilterManager::filterData($authorizationKey);
    }

}
