<?php

namespace WEB\Model\Orders;

use CURLFile;
use WEB\Entity\Orders\OrderEntity;
use WEB\Manager\Api\APIManager;
use WEB\Manager\Api\APITypes;
use WEB\Manager\Package\AbstractModel;
use WEB\Manager\Requests\HttpMethodsType;

class OrderModel extends AbstractModel
{
    /**
     * @return \WEB\Entity\Orders\OrderEntity[]
     */
    public function getAll(): array
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::GET,
            APITypes::ORDERS,
            'orders',
        );

        $toReturn = [];

        foreach ($req as $item) {
            $toReturn[] = OrderEntity::map($item);
        }

        return $toReturn;
    }

    /**
     * @param int $id
     * @return \WEB\Entity\Orders\OrderEntity|null
     */
    public function getById(int $id): ?OrderEntity
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::GET,
            APITypes::ORDERS,
            "orders/$id",
        );

        if (empty($req)) {
            return null;
        }

        return OrderEntity::map($req);
    }

    /**
     * @param int $amount
     * @param int $price
     * @param int $productId
     * @param int $userId
     * @param string $address
     * @return bool
     */
    public function create(int $amount, int $price, int $productId, int $userId, string $address): bool
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::POST,
            APITypes::ORDERS,
            'orders',
            [
                'amount' => $amount,
                'price' => $price,
                'product_id' => $productId,
                'user_id' => $userId,
                'address' => $address
            ],
        );

        return isset($req['id']);
    }
}