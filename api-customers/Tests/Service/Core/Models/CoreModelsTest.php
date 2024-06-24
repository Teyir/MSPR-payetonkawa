<?php

namespace Service\Core\Models;

use Customers\Model\Core\CoreModels;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class CoreModelsTest extends TestCase
{
    private CoreModels $model;

    protected function setUp(): void
    {
        $this->model = CoreModels::getInstance();
    }

    #[TestDox('Get all customers.')]
    public function testGetCustomers(): void
    {
        $customers = $this->model->getAll();

        $this->assertNotEmpty($customers);
    }

    #[TestDox('Get customer id 1')]
    public function testGetCustomersById(): void
    {
        $customers = $this->model->getById(1);

        $this->assertNotEmpty($customers);
    }
}
