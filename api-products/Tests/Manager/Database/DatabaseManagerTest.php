<?php

namespace Manager\Database;

use PHPUnit\Framework\Attributes\TestDox;
use Products\Manager\Database\DatabaseManager;
use PHPUnit\Framework\TestCase;

/**
 * @uses DatabaseManager
 */
class DatabaseManagerTest extends TestCase
{

    #[TestDox('Test PDO generation.')]
    public function testGetPDO(): void
    {
        $this->expectNotToPerformAssertions();

        DatabaseManager::getInstance();
    }

}
