<?php

namespace Service\Core\Models;

use Products\Model\Core\CoreModels;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

/**
 * @uses CoreModels
 * @covers
 */
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
