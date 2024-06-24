<?php

namespace Products\Controller\Core;

use JetBrains\PhpStorm\NoReturn;
use JsonException;
use Products\Manager\Documentation\DocumentationManager;
use Products\Manager\Cache\CacheManager;
use Products\Manager\Class\AbstractController;
use Products\Manager\Env\EnvManager;
use Products\Manager\Error\RequestsError;
use Products\Manager\Error\RequestsErrorsTypes;
use Products\Manager\Images\ImagesManager;
use Products\Manager\Router\Link;
use Products\Manager\Router\LinkTypes;
use Products\Manager\Security\FilterManager;
use Products\Model\Core\CoreModels;

class CoreController extends AbstractController
{

    /**
     * @return void
     * @desc Return doc page
     */
    #[NoReturn] #[Link("/", LinkTypes::GET, [], isUsingCache: false)]
    private function index(): void
    {
        new DocumentationManager();
        die();
    }

    /**
     * @return array
     * @desc Get products
     */
    #[Link("/products", LinkTypes::GET)]
    private function getProducts(): array
    {
        return CoreModels::getInstance()->getAll(false);
    }

    /**
     * @return array
     * @desc Get available products
     */
    #[Link("/products/availables", LinkTypes::GET)]
    private function getProductsAvailable(): array
    {
        return CoreModels::getInstance()->getAll(true);
    }

    /**
     * @param int $id
     * @return array
     * @desc Get product by id
     */
    #[Link("/products/:id", LinkTypes::GET, ['id' => '[0-9]+'])]
    private function getProductsById(int $id): array
    {
        return CoreModels::getInstance()->getById($id);
    }

    /**
     * @return array
     * @post title => string
     * @post description => string
     * @post image => string
     * @post price_kg => float
     * @post kg_remaining => float
     * @desc Create new product
     */
    #[Link("/products", LinkTypes::POST)]
    private function createProduct(): array
    {
        if (!isset($_POST['title'], $_POST['description'], $_FILES['image'], $_POST['price_kg'], $_POST['kg_remaining'])) {
            RequestsError::returnError(RequestsErrorsTypes::WRONG_PARAMS);
        }

        $title = FilterManager::filterInputStringPost("title", 50);
        $description = FilterManager::filterInputStringPost("description", 65000);
        $price = FilterManager::filterInputFloatPost("price_kg");
        $kgRemaining = FilterManager::filterInputFloatPost("kg_remaining");

        $image = ImagesManager::getInstance()->upload($_FILES['image']);

        if (str_starts_with("ERR_", $image)) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ["Description" => "Upload image error: $image"]);
        }

        $productId = CoreModels::getInstance()->create($title, $description, $image, $price, $kgRemaining);

        if (is_null($productId)) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to create product."]);
        }

        CacheManager::deleteAllFiles();

        return ['status' => 1, 'id' => $productId];
    }

    /**
     * @param int $id
     * @return int[]
     * @desc Delete product
     */
    #[Link("/products/:id", LinkTypes::DELETE, ['id' => '[0-9]+'])]
    private function deleteProduct(int $id): array
    {
        $product = CoreModels::getInstance()->getById($id);

        if (empty($product)) {
            RequestsError::returnError(RequestsErrorsTypes::NOT_FOUND);
        }

        if (!CoreModels::getInstance()->delete($id)) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to delete product."]);
        }

        unlink(EnvManager::getInstance()->getValue('DIR') . 'Public/Images/' . $product['image']);

        CacheManager::deleteAllFiles();

        return ['status' => 1];
    }

    /**
     * @param int $id
     * @return int[]
     * @put title => string
     * @put description => string
     * @put price_kg => float
     * @desc Update product
     */
    #[Link("/products/:id", LinkTypes::PUT, ['id' => '[0-9]+'])]
    private function updateProduct(int $id): array
    {
        try {
            $data = json_decode(file_get_contents('php://input', 'r'), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to decode PUT data."]);
        }

        if (!isset($data['title'], $data['description'], $data['price_kg'])) {
            RequestsError::returnError(RequestsErrorsTypes::WRONG_PARAMS);
        }

        $title = FilterManager::filterData($data['title'], 50);
        $description = FilterManager::filterData($data['description'], 65000);
        $price = FilterManager::filterData($data['price_kg'], 50, FILTER_SANITIZE_NUMBER_FLOAT);

        $productId = CoreModels::getInstance()->update($id, $title, $description, $price);

        if (!$productId) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to update product."]);
        }

        CacheManager::deleteAllFiles();

        return ['status' => 1, 'id' => $id];
    }

    /**
     * @param int $id
     * @return int[]
     * @put amount => float
     * @desc Take some amount of a product
     */
    #[Link("/products/:id/take", LinkTypes::PUT, ['id' => '[0-9]+'])]
    private function takeStock(int $id): array
    {
        try {
            $data = json_decode(file_get_contents('php://input', 'r'), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to decode PUT data."]);
        }

        if (empty(CoreModels::getInstance()->getById($id))) {
            RequestsError::returnError(RequestsErrorsTypes::NOT_FOUND);
        }

        if (!isset($data['amount'])) {
            RequestsError::returnError(RequestsErrorsTypes::WRONG_PARAMS);
        }

        $amount = (float)FilterManager::filterData($data['amount'], 50, FILTER_SANITIZE_NUMBER_FLOAT);

        if (!CoreModels::getInstance()->decrementStock($id, $amount)) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to decrement stock."]);
        }

        CacheManager::deleteAllFiles();

        return ['status' => 1];
    }
}
