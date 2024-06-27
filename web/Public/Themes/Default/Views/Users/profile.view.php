<?php

use WEB\Entity\Orders\OrderEntity;
use WEB\Entity\Users\UserEntity;
use WEB\Model\Product\ProductModel;
use WEB\Utils\Website;

Website::setTitle("Profil");
Website::setDescription("Votre profil PayeTonKawa.fr");

/* @var UserEntity $user */
/* @var OrderEntity[] $orders */

if ($orders) {
    $orders = array_reverse($orders);
}
?>

<section class="max-w-7xl px-8 py-16 mx-auto my-10 bg-white overflow-hidden">
    <div  class="mb-4 flex flex-col gap-2 sm:flex-row justify-between items-start sm:items-center">
        <div>
            <h1 class="font-bold tracking-tighter text-4xl">Bonjour <?= $user->getFirstName() ?> !</h1>
            <p class="text-zinc-600">Voilà vos dernières commandes chez Paye Ton Kawa</p>
        </div>
        <div>
            <a href="/logout" class="btn">Se déconnecter</a>
        </div>
    </div>
    <div class="space-y-4">
        <?php foreach ($orders as $order): ?>
            <?php $product = ProductModel::getInstance()->getById($order->getProductId()) ?>
            <div class="bg-zinc-100 shadow-md rounded-2xl border border-zinc-600">
                <div class="p-4">
                    <div class="flex flex-col sm:flex-row gap-6 justify-between items-start sm:items-center pb-4 mb-4 border-b-2">
                        <div>
                            <h3 class="font-semibold">Numéro de commande</h3>
                            <p>#<?= $order->getId() ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold">Adresse</h3>
                            <p><?= $order->getAddress() ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold">Total TTC</h3>
                            <p><?= $order->getPrice() ?>€</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Produits</h3>
                        <div class="flex flex-row gap-2 items-center">
                            <img src="<?= $product->getImage() ?>" alt="<?= $product->getTitle() ?>" class="h-12 w-12 object-cover rounded">
                            <div class="flex flex-col w-full">
                                <div class="flex flex-row gap-5 items-center">
                                    <h2 class="font-semibold"><?= $product->getTitle() ?></h2>
                                    <p><?= $product->getPricePerKg() ?>€</p>
                                </div>
                                <p class="text-zinc-600 max-lines-2 max-w-xl"><?=substr( $product->getDescription(), 0, 100) ?>...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        <?php if(!$orders): ?>
            <div class="text-center mt-10">
                <p class="text-2xl tracking-tighter font-semibold mb-2">C'est un peu vide, mais on peut arranger ça</p>
                <a href="/products" class="btn">Voir les produits</a>
            </div>
        <?php endif; ?>
    </div>
</section>