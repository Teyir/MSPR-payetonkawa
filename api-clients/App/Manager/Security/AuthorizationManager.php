<?php

namespace Clients\Manager\Security;

use Clients\Manager\Env\EnvManager;
use Clients\Manager\Error\RequestsError;
use Clients\Manager\Error\RequestsErrorsTypes;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LogicException;
use UnexpectedValueException;

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
        $key = EnvManager::getInstance()->getValue('JWT_KEY');
        $payload = [
            'iss' => 'API Clients',
            'iat' => time(), //Date de génération du token
            'exp' => time() + 60,
        ];

        $tokenJwt = JWT::encode($payload, $key, 'HS256');
        var_dump($tokenJwt);

        try {
            $decoded = JWT::decode($tokenJwt, new Key($key, 'HS256'));

            print_r($decoded);
        } catch (LogicException $e) {
            // errors having to do with environmental setup or malformed JWT Keys
        } catch (UnexpectedValueException $e) {
            // errors having to do with JWT signature and claims
        }

        return true;
    }

}
