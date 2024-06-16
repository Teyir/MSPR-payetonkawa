<?php

namespace WEB\Model\Product;

use CURLFile;
use WEB\Entity\Products\ProductEntity;
use WEB\Manager\Api\APIManager;
use WEB\Manager\Api\APITypes;
use WEB\Manager\Package\AbstractModel;
use WEB\Manager\Requests\HttpMethodsType;

class ProductModel extends AbstractModel
{
    /**
     * @param bool $onlyAvailable
     * @return \WEB\Entity\Products\ProductEntity[]
     */
    public function getAll(bool $onlyAvailable): array
    {
        $slug = $onlyAvailable ? 'products/availables' : 'products';

        $req = APIManager::getInstance()->send(
            HttpMethodsType::GET,
            APITypes::PRODUCTS,
            $slug,
        );

        $toReturn = [];

        foreach ($req as $item) {
            $toReturn[] = ProductEntity::map($item);
        }

        return $toReturn;
    }

    /**
     * @param int $id
     * @return \WEB\Entity\Products\ProductEntity|null
     */
    public function getById(int $id): ?ProductEntity
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::GET,
            APITypes::PRODUCTS,
            "products/$id",
        );

        if (empty($req)) {
            return null;
        }

        return ProductEntity::map($req);
    }

    /**
     * @param string $title
     * @param string $description
     * @param float $priceKg
     * @param float $stock
     * @param \CURLFile $image
     * @return bool
     */
    public function create(string $title, string $description, float $priceKg, float $stock, CURLFile $image): bool
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::POST,
            APITypes::PRODUCTS,
            'products',
            [
                'title' => $title,
                'description' => $description,
                'price_kg' => $priceKg,
                'kg_remaining' => $stock,
                'image' => $image,
            ],
        );

        return isset($req['id']);
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param float $priceKg
     * @return bool
     */
    public function update(int $id, string $title, string $description, float $priceKg): bool
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::PUT,
            APITypes::PRODUCTS,
            "products/$id",
            [
                'title' => $title,
                'description' => $description,
                'price_kg' => $priceKg,
            ],
        );

        return isset($req['id']);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        APIManager::getInstance()->send(
            HttpMethodsType::DELETE,
            APITypes::PRODUCTS,
            "products/$id",
        );

        return true;
    }
}