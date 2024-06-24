<?php

namespace Manager\Database;

use PHPUnit\Framework\Attributes\TestDox;
use Customers\Manager\Database\DatabaseManager;
use PHPUnit\Framework\TestCase;

class DatabaseManagerTest extends TestCase
{
    protected function setUp(): void
    {
        require_once "test_loader.php";
        parent::setUp();
    }


    #[TestDox('Test PDO generation.')]
    public function testGetPDO(): void
    {
        $this->expectNotToPerformAssertions();

        DatabaseManager::getInstance();
    }

}
