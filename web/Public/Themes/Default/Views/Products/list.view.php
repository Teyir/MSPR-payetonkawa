<?php

use WEB\Entity\Products\ProductEntity;
use WEB\Model\Product\ProductModel;
use WEB\Utils\Website;

/* @var ProductEntity[] $productList */
/* @var ProductModel $productModel */

Website::setTitle("Liste de nos produits");
Website::setDescription("Découvrez nos merveilleux produits !");
?>

<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="sr-only">Products</h2>
    <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
        <?php foreach ($productList as $product) : ?>
            <a href="/web/products/<?= $product->getId() ?>" class="group">
                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                    <img src="<?= $product->getImage() ?>" alt="<?= $product->getTitle() ?>" class="h-full w-full object-cover object-center group-hover:opacity-75">
                </div>
                <h3 class="mt-4 text-sm text-gray-700"><?= $product->getTitle() ?></h3>
                <p class="mt-1 text-lg font-medium text-gray-900"><?= $product->getPricePerKg() ?>€/kg</p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
