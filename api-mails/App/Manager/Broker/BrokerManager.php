<?php

namespace Mails\Manager\Broker;

use Exception;
use Mails\Manager\Class\AbstractManager;
use Mails\Manager\Env\EnvManager;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

class BrokerManager
{
    protected static ?BrokerManager $_instance = null;
    protected ?AMQPStreamConnection $connection = null;
    protected ?AMQPChannel $channel = null;

    public static function getInstance(): self
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getConnection(): AMQPStreamConnection
    {
        if (is_null($this->connection)) {
            $env = EnvManager::getInstance();
            $host = $env->getValue("BROKER_HOST");
            $port = $env->getValue("BROKER_PORT");
            $user = $env->getValue("BROKER_USER");
            $pass = $env->getValue("BROKER_PASSWORD");

            $this->connection = @new AMQPStreamConnection($host, $port, $user, $pass);
        }

        return $this->connection;
    }

    public function getChannel(): AMQPChannel
    {
        if (is_null($this->channel)) {
            $this->channel = $this->getConnection()->channel();
        }

        return $this->channel;
    }

    public function publish(AMQPMessage $message, string $key): void
    {
        $this->getChannel()->basic_publish($message, '', $key);
    }

    public function listen(string $key, callable $callback): void
    {
        $channel = $this->getChannel();
        $channel->queue_declare($key, false, false, false, false);

        $channel->basic_consume($key, '', false, true, false, false, $callback);

        // Wait for messages
        while (true) {
            $channel->wait();
        }
    }

    public function close(): void
    {
        if ($this->channel) {
            $this->channel->close();
        }

        if ($this->connection) {
            $this->connection->close();
        }
    }
}
