<?php

namespace Service\Core\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Products\Manager\Class\GlobalObject;
use Products\Manager\Database\DatabaseManager;
use Products\Manager\Env\EnvManager;
use Products\Manager\Loader\AutoLoad;
use Products\Model\Core\CoreModels;

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

    #[TestDox('Get all customers.')]
    public function testGetCustomers(): void
    {
        $customers = $this->model->getAll(false);

        $this->assertNotEmpty($customers);
    }

    #[TestDox('Get customer id 1')]
    public function testGetCustomersById(): void
    {
        $customers = $this->model->getById(1);

        $this->assertNotEmpty($customers);
    }
}
