<?php

namespace Customers\Controller\Core;

use Customers\Manager\Class\AbstractController;
use Customers\Manager\Router\Link;
use Customers\Manager\Router\LinkTypes;

class CoreController extends AbstractController
{
    #[Link("/customers", LinkTypes::GET)]
    private function getCustomers(): array
    {
        return ['status' => 1]; //TODO
    }

    #[Link("/customers/:id", LinkTypes::GET, ['id' => '[0-9]+'])]
    private function getCustomerById(int $id): array
    {
        return ['status' => 1]; //TODO
    }

    #[Link("/customers", LinkTypes::POST)]
    private function createNewCustomer(): array
    {
        return ['status' => 1]; //TODO
    }

    #[Link("/customers/:id", LinkTypes::PUT, ['id' => '[0-9]+'])]
    private function updateCustomer(int $d): array
    {
        return ['status' => 1]; //TODO
    }

    #[Link("/customers/:id", LinkTypes::DELETE, ['id' => '[0-9]+'])]
    private function deleteCustomer(int $d): array
    {
        return ['status' => 1]; //TODO
    }

}