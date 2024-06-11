<?php

namespace Customers\Manager\Cache;

use Redis;
use RedisException;
use Customers\Manager\Class\AbstractManager;
use Customers\Manager\Env\EnvManager;
use Customers\Manager\Error\RequestsError;
use Customers\Manager\Error\RequestsErrorsTypes;

class RedisManager extends AbstractManager
{
    private Redis $_instance;

    public function __construct()
    {
        $this->init();
    }

    public function getRedisInstance(): Redis
    {
        return $this->_instance;
    }

    private function init(): void
    {
        $env = EnvManager::getInstance();
        $this->_instance = new Redis();
        try {
            $this->_instance->pconnect($env->getValue('REDIS_EVENT_HOST'), $env->getValue('REDIS_EVENT_PORT'));
            $this->_instance->auth($env->getValue('REDIS_EVENT_PASSWORD'));
        } catch (RedisException $e) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, [$e]);
        }

    }

}