<?php

namespace WEB\Manager\Package;

interface IPackageConfig
{
    public function name(): string;

    public function version(): string;

    public function authors(): array;

    public function isCore(): bool;

    /**
     * @return \WEB\Manager\Package\PackageMenuType[]|null
     */
    public function menus(): ?array;
}