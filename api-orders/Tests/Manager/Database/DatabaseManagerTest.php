<?php

namespace Manager\Database;

use PHPUnit\Framework\Attributes\TestDox;
use Orders\Manager\Database\DatabaseManager;
use PHPUnit\Framework\TestCase;

class DatabaseManagerTest extends TestCase
{

    #[TestDox('Test PDO generation.')]
    public function testGetPDO(): void
    {
        $this->expectNotToPerformAssertions();

        DatabaseManager::getInstance();
    }

}
