<?php

namespace Customers\Model\Core;

use Customers\Manager\Class\AbstractModel;
use Customers\Manager\Database\DatabaseManager;

class CoreModels extends AbstractModel
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return int|null
     * @desc Create new user. All data need to be securely processed
     */
    public function create(string $firstName, string $lastName, string $email, string $password): ?int
    {
        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
        ];

        $sql = "INSERT INTO customers.customers (first_name, last_name, email, password) 
                    VALUES (:first_name, :last_name, :email, :password)";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute($data)) {
            return null;
        }

        return $db->lastInsertId() ?? null;
    }

    /**
     * @return array
     * @desc Get all users
     */
    public function getAll(): array
    {
        $sql = "SELECT id, first_name, last_name, email, date_created, date_updated, last_login 
                    FROM customers.customers";
        $db = DatabaseManager::getInstance();
        $req = $db->query($sql);

        if (!$req) {
            return [];
        }

        return $req->fetchAll() ?? [];
    }

    /**
     * @param int $id
     * @return array
     * @desc Get user by id
     */
    public function getById(int $id): array
    {
        $sql = "SELECT id, first_name, last_name, email, date_created, date_updated, last_login 
                    FROM customers.customers WHERE id = :id";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute(['id' => $id])) {
            return [];
        }

        return $req->fetch() ?? [];
    }

    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @return bool
     * @desc Update user information (don't update password)
     */
    public function update(int $id, string $firstName, string $lastName, string $email): bool
    {
        $data = [
            'id' => $id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
        ];

        $sql = "UPDATE customers.customers SET first_name = :first_name,  last_name = :last_name, email = :email 
                                WHERE id = :id";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        return $req->execute($data);
    }

    /**
     * @param int $id
     * @return bool
     * @desc Delete specific user
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM customers.customers WHERE id = :id";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        return $req->execute(['id' => $id]);
    }
}