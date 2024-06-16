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
            false,
        );

        $toReturn = [];

        foreach ($req as $item) {
            $toReturn[] = ProductEntity::map($item);
        }

        return $toReturn;
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
            false,
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
}