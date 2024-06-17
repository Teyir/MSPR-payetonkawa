<?php

namespace Products\Model\Core;

use Products\Manager\Class\AbstractModel;
use Products\Manager\Database\DatabaseManager;
use Products\Manager\Env\EnvManager;

class CoreModels extends AbstractModel
{
    /**
     * @param bool $onlyAvailable
     * @return array
     * @desc Get all products. If $onlyAvailable is true, we select only products with available products.
     */
    public function getAll(bool $onlyAvailable): array
    {
        $sql = "SELECT * FROM products.products";

        if ($onlyAvailable) {
            $sql .= "  WHERE kg_remaining > 0";
        }

        $db = DatabaseManager::getInstance();
        $req = $db->query($sql);

        if (!$req) {
            return [];
        }

        $data = $req->fetchAll() ?? [];

        foreach ($data as $i => $item) {
            $data[$i]['image'] = EnvManager::getInstance()->getValue('URL') . '/Public/Images/' . $item['image'];
        }

        return $data;
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $image
     * @param float $priceKg
     * @param float $kgRemaining
     * @return int|null
     */
    public function create(string $title, string $description, string $image, float $priceKg, float $kgRemaining): ?int
    {
        $data = [
            'title' => $title,
            'description' => $description,
            'image' => $image,
            'price_kg' => $priceKg,
            'kg_remaining' => $kgRemaining,
        ];

        $sql = "INSERT INTO products.products (title, description, image, price_kg, kg_remaining) 
                    VALUES (:title, :description, :image, :price_kg, :kg_remaining)";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute($data)) {
            return null;
        }

        return $db->lastInsertId();
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
        $data = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'price_kg' => $priceKg,
        ];

        $sql = "UPDATE products.products SET title = :title, description = :description, price_kg = :price_kg 
                         WHERE id = :id";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute($data)) {
            return false;
        }

        return true;
    }

    /**
     * @param int $id
     * @return array
     * @desc Get product by id
     */
    public function getById(int $id): array
    {
        $sql = "SELECT * FROM products.products WHERE id = :id";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute(['id' => $id])) {
            return [];
        }

        $res = $req->fetch();

        if (!$res) {
            return [];
        }

        $res['image'] = EnvManager::getInstance()->getValue('URL') . '/Public/Images/' . $res['image'];

        return $res;
    }

    /**
     * @param int $id
     * @return bool
     * @desc Delete product
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM products.products WHERE id = :id";
        $db = DatabaseManager::getInstance();
        return $db->prepare($sql)->execute(['id' => $id]);
    }

    /**
     * @param int $id
     * @param float $amount
     * @return bool
     */
    public function decrementStock(int $id, float $amount): bool
    {
        $sql = "UPDATE products.products SET kg_remaining = (kg_remaining - :amount) WHERE id = :id";
        $db = DatabaseManager::getInstance();
        return $db->prepare($sql)->execute(['id' => $id, 'amount' => $amount]);
    }
}