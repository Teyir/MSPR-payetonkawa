<?php

namespace Clients\Manager\Security;

use RedisException;
use Clients\Manager\Cache\RedisManager;
use Clients\Manager\Env\EnvManager;
use Clients\Manager\Error\RequestsError;
use Clients\Manager\Error\RequestsErrorsTypes;
use Clients\Utils\Client;

class RateLimiter
{
    public function __construct()
    {
        if (EnvManager::getInstance()->getValue('IS_FALLBACK') === 'false') {
            $this->logic();
        }
    }

    private function logic(): void
    {
        $redis = RedisManager::getInstance()->getRedisInstance();

        $clientIp = Client::getIp();

        $maxCalls = 30; // Nombre max de calls
        $timePeriod = 10; // Durée de vie d'une requête (secondes)
        $totalUserCalls = 0; // Calls du client

        try {
            $redis->pipeline();

            if (!$redis->exists($clientIp)) {
                $redis->set($clientIp, 1);
                $redis->expire($clientIp, $timePeriod);
                $totalUserCalls = 1;
            } else {
                $redis->INCR($clientIp);
                $totalUserCalls = $redis->get($clientIp);

                if ($totalUserCalls > $maxCalls) {
                    RequestsError::returnError(RequestsErrorsTypes::TOO_MANY_REQUESTS);
                }
            }
        } catch (RedisException $e) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, [$e]);
        }
    }


}