<?php

namespace Service\Core\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Products\Model\Core\CoreModels;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoreModels::class)]
#[UsesClass(CoreModels::class)]
class CoreModelsTest extends TestCase
{
    private CoreModels $model;

    protected function setUp(): void
    {
        $this->model = CoreModels::getInstance();
    }

    #[TestDox('Get all products.')]
    public function testGetProducts(): void
    {
        $products = $this->model->getAll(false);

        $this->assertNotEmpty($products);
    }
}
