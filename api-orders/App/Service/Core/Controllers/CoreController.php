<?php

namespace Orders\Controller\Core;

use Orders\Manager\Api\APIManager;
use Orders\Manager\Api\APITypes;
use Orders\Manager\Broker\BrokerManager;
use Orders\Manager\Cache\CacheManager;
use Orders\Manager\Class\AbstractController;
use Orders\Manager\Error\RequestsError;
use Orders\Manager\Error\RequestsErrorsTypes;
use Orders\Manager\Requests\HttpMethodsType;
use Orders\Manager\Router\Link;
use Orders\Manager\Router\LinkTypes;
use Orders\Manager\Security\EncryptManager;
use Orders\Manager\Security\FilterManager;
use Orders\Model\Core\CoreModels;
use PhpAmqpLib\Message\AMQPMessage;

class CoreController extends AbstractController
{
    #[Link("/orders", LinkTypes::GET)]
    private function getOrders(): array
    {
        return CoreModels::getInstance()->getAll();
    }

    #[Link("/orders/:id", LinkTypes::GET, ['id' => '[0-9]+'])]
    private function getOrdersByUserId(int $id): array
    {
        return CoreModels::getInstance()->getUserOrders($id);
    }

    #[Link("/orders", LinkTypes::POST)]
    private function createOrder(): array
    {
        if (!isset($_POST['amount'], $_POST['price'], $_POST['product_id'], $_POST['user_id'])) {
            RequestsError::returnError(RequestsErrorsTypes::WRONG_PARAMS);
        }

        $amount = FilterManager::filterInputFloatPost('amount');
        $price = FilterManager::filterInputFloatPost('price');
        $productId = FilterManager::filterInputIntPost('product_id', 11);
        $userId = FilterManager::filterInputIntPost('user_id', 11);

        $orderId = CoreModels::getInstance()->create($amount, $price, $productId, $userId);

        if (is_null($orderId)) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to create order."]);
        }

        if (!CoreModels::getInstance()->decrementStock($productId, $amount)) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to decrement stock."]);
        }

        //Send customer an email
        $broker = BrokerManager::getInstance();
        $broker->publish(
            new AMQPMessage($userId),
            "orders",
        );

        APIManager::getInstance()->send(HttpMethodsType::POST, APITypes::MAILS, 'send');


        CacheManager::deleteAllFiles();

        return ['status' => 1, 'id' => $orderId];
    }
}
