<?php

use WEB\Entity\Products\ProductEntity;
use WEB\Manager\Security\SecurityManager;
use WEB\Utils\Website;

/* @var ProductEntity $product */

Website::setTitle($product->getTitle());
Website::setDescription($product->getDescription());
?>


<div class="py-16 sm:py-24 bg-white">
    <div class="pt-6">
        <!-- Image gallery -->
        <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
            <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
                <img src="<?= $product->getImage() ?>"
                     alt="<?= $product->getTitle() ?>"
                     class="h-full w-full object-cover object-center">
            </div>
        </div>
        <!-- Product info -->
        <div class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
            <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl"><?= $product->getTitle() ?></h1>
            </div>
            <!-- Options -->
            <div class="mt-4 lg:row-span-3 lg:mt-0">
                <h2 class="sr-only">Informations</h2>
                <p class="text-3xl tracking-tight text-gray-900"><?= $product->getPricePerKg() ?>€</p>
                <form class="mt-10" action="" method="post">
                    <?php (new SecurityManager())->insertHiddenToken() ?>
                    <button type="submit"
                            class="mt-10 flex w-full rounded-2xl items-center justify-center rounded-2xl border border-transparent bg-orange-600 px-8 py-3 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        Ajouter au panier
                    </button>
                </form>
            </div>
            <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
                <!-- Description and details -->
                <div>
                    <h3 class="sr-only">Description</h3>
                    <div class="space-y-6">
                        <p class="text-base text-gray-900"><?= $product->getDescription() ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>