<?php


namespace WEB\Package\Products;

use WEB\Manager\Package\IPackageConfig;
use WEB\Manager\Package\PackageMenuType;
use WEB\Manager\Package\PackageSubMenuType;

class Package implements IPackageConfig
{
    public function name(): string
    {
        return "Products";
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
        return false;
    }

    public function menus(): ?array
    {
        return [
            new PackageMenuType(
                lang: "fr",
                icon: "fas fa-boxes-stacked",
                title: "Produits",
                url: null,
                subMenus: [
                    new PackageSubMenuType(
                        title: 'Liste',
                        url: 'products/manage',
                    ),
                    new PackageSubMenuType(
                        title: 'Ajout',
                        url: 'products/add',
                    ),
                ],
            ),
        ];
    }
}