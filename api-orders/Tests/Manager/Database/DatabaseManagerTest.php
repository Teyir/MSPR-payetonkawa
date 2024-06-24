<?php

namespace Manager\Database;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Orders\Manager\Database\DatabaseManager;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Orders\Manager\Env\EnvManager;
use Orders\Manager\Loader\AutoLoad;

#[CoversClass(DatabaseManager::class)]
#[UsesClass(DatabaseManager::class)]
#[UsesClass(EnvManager::class)]
#[UsesClass(AutoLoad::class)]
class DatabaseManagerTest extends TestCase
{

    #[TestDox('Test PDO generation.')]
    public function testGetPDO(): void
    {
        $this->expectNotToPerformAssertions();

        DatabaseManager::getInstance();
    }

}
