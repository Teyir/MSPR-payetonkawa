<?php

namespace Manager\Database;

use Mails\Manager\Env\EnvManager;
use Mails\Manager\Loader\AutoLoad;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Mails\Manager\Database\DatabaseManager;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

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
