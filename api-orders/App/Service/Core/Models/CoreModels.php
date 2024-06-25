<?php

namespace Orders\Model\Core;

use Orders\Manager\Api\APIManager;
use Orders\Manager\Api\APITypes;
use Orders\Manager\Class\AbstractModel;
use Orders\Manager\Database\DatabaseManager;
use Orders\Manager\Requests\HttpMethodsType;

class CoreModels extends AbstractModel
{
    /**
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM orders.orders";

        $db = DatabaseManager::getInstance();
        $req = $db->query($sql);

        if (!$req) {
            return [];
        }

        return $req->fetchAll() ?? [];
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getUserOrders(int $userId): array
    {
        $sql = "SELECT * FROM orders.orders WHERE user_id = :id";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute(['id' => $userId])) {
            return [];
        }

        return $req->fetchAll() ?? [];
    }


    /**
     * @param float $amount
     * @param float $price
     * @param int $productId
     * @param int $userId
     * @param string $address
     * @return int|null
     */
    public function create(float $amount, float $price, int $productId, int $userId, string $address): ?int
    {
        $data = [
            'amount' => $amount,
            'price' => $price,
            'product_id' => $productId,
            'user_id' => $userId,
            'address' => $address,
        ];

        $sql = "INSERT INTO orders.orders (amount, price, product_id, user_id, address) 
                        VALUES (:amount, :price, :product_id, :user_id, :address)";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute($data)) {
            return null;
        }

        return $db->lastInsertId();
    }

    /**
     * @param int $productId
     * @param float $amount
     * @return bool
     */
    public function decrementStock(int $productId, float $amount): bool
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::PUT,
            APITypes::PRODUCTS,
            "products/$productId/take",
            [
                'amount' => $amount,
            ],
        );

        return isset($req['status']);
    }
}