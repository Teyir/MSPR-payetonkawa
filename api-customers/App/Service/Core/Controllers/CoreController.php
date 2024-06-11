<?php

namespace Customers\Controller\Core;

use Customers\Manager\Cache\CacheManager;
use Customers\Manager\Class\AbstractController;
use Customers\Manager\Error\RequestsError;
use Customers\Manager\Error\RequestsErrorsTypes;
use Customers\Manager\Router\Link;
use Customers\Manager\Router\LinkTypes;
use Customers\Manager\Security\EncryptManager;
use Customers\Manager\Security\FilterManager;
use Customers\Model\Core\CoreModels;

class CoreController extends AbstractController
{
    #[Link("/customers", LinkTypes::GET)]
    private function getCustomers(): array
    {
        return CoreModels::getInstance()->getAll();
    }

    #[Link("/customers/:id", LinkTypes::GET, ['id' => '[0-9]+'])]
    private function getCustomerById(int $id): array
    {
        return CoreModels::getInstance()->getById($id);
    }

    #[Link("/customers", LinkTypes::POST)]
    private function createNewCustomer(): array
    {
        if (!isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'])) {
            RequestsError::returnError(RequestsErrorsTypes::WRONG_PARAMS);
        }

        $firstName = FilterManager::filterInputStringPost('first_name', 50);
        $lastName = FilterManager::filterInputStringPost('last_name', 50);
        $email = FilterManager::filterInputStringPost('email');
        $password = FilterManager::filterInputStringPost('password');

        $securedEmail = EncryptManager::encrypt($email);
        $securedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userId = CoreModels::getInstance()->create($firstName, $lastName, $securedEmail, $securedPassword);

        if (is_null($userId)) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to create user"]);
        }

        CacheManager::deleteCacheFilesForFolder('Customers');

        return ['status' => 1, 'id' => $userId];
    }

    #[Link("/customers/:id", LinkTypes::PUT, ['id' => '[0-9]+'])]
    private function updateCustomer(int $id): array
    {
        $data = json_decode(file_get_contents('php://input', 'r'), true);

        if (!isset($data['first_name'], $data['last_name'], $data['email'])) {
            RequestsError::returnError(RequestsErrorsTypes::WRONG_PARAMS);
        }

        $firstName = FilterManager::filterData($data['first_name'], 50);
        $lastName = FilterManager::filterData($data['last_name'], 50);
        $email = FilterManager::filterData($data['email'], 255, FILTER_SANITIZE_EMAIL);

        $securedEmail = EncryptManager::encrypt($email);

        if (!CoreModels::getInstance()->update($id, $firstName, $lastName, $securedEmail)) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to update user."]);
        }

        CacheManager::deleteCacheFilesForFolder('Customers');

        return ['status' => 1];
    }

    #[Link("/customers/:id", LinkTypes::DELETE, ['id' => '[0-9]+'])]
    private function deleteCustomer(int $id): array
    {
        $user = CoreModels::getInstance()->getById($id);

        if (empty($user)) {
            RequestsError::returnError(RequestsErrorsTypes::NOT_FOUND);
        }

        if (!CoreModels::getInstance()->delete($id)) {
            RequestsError::returnError(RequestsErrorsTypes::INTERNAL_SERVER_ERROR, ['Description' => "Unable to delete user."]);
        }

        CacheManager::deleteCacheFilesForFolder('Customers');

        return ['status' => 1];
    }
}
