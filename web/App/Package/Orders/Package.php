<?php

namespace WEB\Package\Orders;

use WEB\Manager\Package\IPackageConfig;
use WEB\Manager\Package\PackageMenuType;
use WEB\Manager\Package\PackageSubMenuType;

class Package implements IPackageConfig
{
    public function name(): string
    {
        return "Orders";
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
        return [
            new PackageMenuType(
                lang: "fr",
                icon: "fas fa-cart-shopping",
                title: "Commandes",
                url: null,
                subMenus: [
                    new PackageSubMenuType(
                        title: 'Liste',
                        url: 'orders/manage',
                    ),
                ],
            ),
        ];
    }
}