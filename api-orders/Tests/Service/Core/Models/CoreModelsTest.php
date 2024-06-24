<?php

namespace Service\Core\Models;

use Orders\Model\Core\CoreModels;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Orders\Manager\Class\GlobalObject;
use Orders\Manager\Database\DatabaseManager;
use Orders\Manager\Env\EnvManager;
use Orders\Manager\Loader\AutoLoad;

#[CoversClass(CoreModels::class)]
#[UsesClass(CoreModels::class)]
#[UsesClass(GlobalObject::class)]
#[UsesClass(DatabaseManager::class)]
#[UsesClass(EnvManager::class)]
#[UsesClass(AutoLoad::class)]
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
