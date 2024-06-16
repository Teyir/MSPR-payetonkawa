<?php

namespace Products\Manager\Database;

use DateTime;
use DateTimeZone;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use stdClass;
use Products\Manager\Env\EnvManager;

class MongoManager
{
    private Manager $mongoClient;
    private string $dbName = 'metrics';
    private string $collectionName;
    private $result;

    public function __construct(string $collectionName, ?string $dbName = null)
    {
        $this->collectionName = $collectionName;
        $env = EnvManager::getInstance();
        $host = $env->getValue("MONGODB_HOST");
        $user = $env->getValue("MONGODB_USERNAME");
        $pass = $env->getValue("MONGODB_PASSWORD");
        $port = $env->getValue("MONGODB_PORT");

        $this->collectionName = $collectionName;
        $url = sprintf(
            "mongodb://%s:%s@%s:%s",
            $user,
            $pass,
            $host,
            $port
        );
        $this->mongoClient = new Manager($url);

        if (!is_null($dbName)) {
            $this->dbName = $dbName;
        }
    }

    private function getInstance(): Manager
    {
        return $this->mongoClient;
    }

    public function find(array $filter = [], array $options = []): array
    {
        $toReturn = [];

        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $query = new Query($filter, $options);
            $cursor = $client->executeQuery($this->dbName . '.' . $this->collectionName, $query);

            foreach ($cursor as $document) {
                $toReturn[] = $document;
            }
        }

        return $toReturn;
    }

    public function count(array $filter = null, array $options = []): int
    {
        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $command = new Command(['count' => $this->collectionName, 'query' => $filter]);
            try {
                $cursor = $client->executeCommand($this->dbName, $command, $options);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            return current($cursor->toArray())->n;
        }
    }

    public function findOne(object $filter = null, array $options = []): MongoManager
    {
        $client = null;
        $this->result = null;

        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $query = new Query($filter, $options);
            $cursor = $client->executeQuery($this->dbName . '.' . $this->collectionName, $query);
            $this->result = current($cursor->toArray());
        }

        return $this;
    }

    public function aggregate(array $pipeline = []): array
    {
        $toReturn = [];

        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $command = new Command([
                'aggregate' => $this->collectionName,
                'pipeline' => $pipeline,
                'cursor' => new stdClass(),
            ]);

            $cursor = $client->executeCommand($this->dbName, $command);
            $documents = $cursor->toArray();

            foreach ($documents as $document) {
                $toReturn[] = $document;
            }
        }

        return $toReturn;
    }

    public function insertOne(array|object $query, array $options = []): bool
    {
        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        } finally {
            $bulkWrite = new BulkWrite();
            $bulkWrite->insert($query);

            $client->executeBulkWrite($this->dbName . '.' . $this->collectionName, $bulkWrite);
            return true;
        }
    }

    public function insertMany(array|object $query, array $options = []): bool
    {

        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        } finally {
            $bulkWrite = new BulkWrite();
            foreach ($query as $document) {
                $bulkWrite->insert($document);
            }

            $client->executeBulkWrite($this->dbName . '.' . $this->collectionName, $bulkWrite);
            return true;
        }
    }

    public function updateOne(array $filter, array $update, array $options = []): bool
    {
        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        } finally {
            $bulkWrite = new BulkWrite();
            $bulkWrite->update($filter, $update, $options);

            $client->executeBulkWrite($this->dbName . '.' . $this->collectionName, $bulkWrite);
            return true;
        }
    }

    public static function getCurrentDate(): UTCDateTime
    {
        $timezone = new DateTimeZone('Europe/Paris');
        $dateTime = new DateTime('now', $timezone);
        return new UTCDateTime(milliseconds: $dateTime);
    }

    public function distinct(string $fieldName): array
    {
        $toReturn = [];

        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $command = new Command([
                'distinct' => $this->collectionName,
                'key' => $fieldName,
            ]);

            $cursor = $client->executeCommand($this->dbName, $command);
            $documents = current($cursor->toArray());

            if (isset($documents->values)) {
                $toReturn = $documents->values;
            }
        }

        return $toReturn;
    }

    public function deleteOne(array $filter, array $options = []): bool
    {
        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        } finally {
            $bulkWrite = new BulkWrite();
            $bulkWrite->delete($filter, ['limit' => 1] + $options);

            try {
                $client->executeBulkWrite($this->dbName . '.' . $this->collectionName, $bulkWrite);
                return true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
    }

    public function deleteMany(array $filter, array $options = []): bool
    {
        try {
            $client = $this->getInstance();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        } finally {
            $bulkWrite = new BulkWrite();
            $bulkWrite->delete($filter, $options);

            try {
                $client->executeBulkWrite($this->dbName . '.' . $this->collectionName, $bulkWrite);
                return true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
    }


}

