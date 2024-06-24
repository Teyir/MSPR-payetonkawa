<?php

namespace Service\Core\Models;

use Orders\Model\Core\CoreModels;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class CoreModelsTest extends TestCase
{
    private CoreModels $model;

    protected function setUp(): void
    {
        $this->model = CoreModels::getInstance();
    }

    #[TestDox('Get all orders.')]
    public function testGetAllOrders(): void
    {
        $orders = $this->model->getAll();

        $this->assertNotEmpty($orders);
    }

    #[TestDox('Get user orders')]
    public function testGetUserOrders(): void
    {
        $orders = $this->model->getUserOrders(1);

        $this->assertNotEmpty($orders);
    }
}
