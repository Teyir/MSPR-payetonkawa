<?php


namespace WEB\Package\Users;

use WEB\Manager\Package\IPackageConfig;

class Package implements IPackageConfig
{
    public function name(): string
    {
        return "Users";
    }

    public function version(): string
    {
        return "1.0.0";
    }

    public function authors(): array
    {
        return ["Overheat Studio"];
    }

    public function isCore(): bool
    {
        return true;
    }

    public function menus(): ?array
    {
        return [];
    }
}