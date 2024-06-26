<?php

use WEB\Entity\Products\ProductEntity;
use WEB\Manager\Env\EnvManager;
use WEB\Utils\Website;

Website::setTitle("Merci pour votre commande !");
Website::setDescription("Page récapitulative de votre commande PayeTonKawa.");

/* @var ProductEntity[] $productList */
/* @var array $orderInfos */

$subtotal = 0;
foreach ($productList as $cartItem) {
    $subtotal += $cartItem->getPricePerKg();
}
?>

<section class="max-w-7xl px-8 py-16 mx-auto my-10 bg-white overflow-hidden">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <!-- Left Image -->
        <div class="bg-zinc-200 rounded-2xl">
            <img src="<?= EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'Public/Themes/Default/Resources/Assets/Img/coffee.webp'?>" alt="Coffee" class="rounded-2xl w-full h-full object-cover shadow-xl">
        </div>
        <!-- Right Content -->
        <div class="p-6 md:p-10">
            <div class="text-sm text-orange-600 font-semibold">Paiement réussi</div>
            <div class="text-2xl font-bold mt-2 mb-2">Merci pour votre commande !</div>
            <p class="text-zinc-600">Votre commande arrive bientôt, vous devriez recevoir un mail très prochainement !</p>
            <div class="mt-6 bg-zinc-100 rounded-xl p-4">
                <div class="space-y-4">
                    <?php foreach ($productList as $item): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex">
                                <img src="<?= $item->getImage() ?>" alt="<?= $item->getTitle() ?>" class="w-12 h-12 rounded mr-4 object-cover">
                                <div>
                                    <div class="font-semibold"><?= $item->getTitle() ?></div>
                                    <div class="text-zinc-600 text-sm">x 1</div>
                                </div>
                            </div>
                            <div class="font-semibold"><?= $item->getPricePerKg() ?>€</div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-6">
                    <div class="flex justify-between">
                        <div class="text-zinc-600">Sous-total</div>
                        <div class="text-zinc-800 font-semibold"><?= $subtotal ?>€</div>
                    </div>
                    <div class="flex justify-between mt-2">
                        <div class="text-zinc-600">Livraison</div>
                        <div class="text-zinc-800 font-semibold"><?= $orderInfos["shipping"] ?>€</div>
                    </div>
                    <div class="flex justify-between mt-2">
                        <div class="text-zinc-600">TVA</div>
                        <div class="text-zinc-800 font-semibold"><?= round((($subtotal + intval($orderInfos["shipping"])) / 1.20) * 0.2, 2) ?>€</div>
                    </div>
                    <div class="flex justify-between mt-4 border-t pt-4 border-zinc-200">
                        <div class="text-zinc-800 font-semibold">Total</div>
                        <div class="text-zinc-800 font-semibold"><?= $subtotal + intval($orderInfos["shipping"]) ?>€</div>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <div class="text-zinc-600">Adresse de livraison</div>
                <div class="font-semibold text-zinc-800 mt-1"><?= $orderInfos["name"] ?></div>
                <div class="text-zinc-600"><?= $orderInfos["address"] . ", " . $orderInfos["zipCode"] ?><br><?= $orderInfos["city"] . ", " . $orderInfos["country"] ?></div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-zinc-600">Informations de paiement</div>
                        <svg aria-hidden="true" width="36" height="24" viewBox="0 0 36 24" class="mt-1">
                            <rect width="36" height="24" rx="4" fill="#224DBA"></rect>
                            <path d="M10.925 15.673H8.874l-1.538-6c-.073-.276-.228-.52-.456-.635A6.575 6.575 0 005 8.403v-.231h3.304c.456 0 .798.347.855.75l.798 4.328 2.05-5.078h1.994l-3.076 7.5zm4.216 0h-1.937L14.8 8.172h1.937l-1.595 7.5zm4.101-5.422c.057-.404.399-.635.798-.635a3.54 3.54 0 011.88.346l.342-1.615A4.808 4.808 0 0020.496 8c-1.88 0-3.248 1.039-3.248 2.481 0 1.097.969 1.673 1.653 2.02.74.346 1.025.577.968.923 0 .519-.57.75-1.139.75a4.795 4.795 0 01-1.994-.462l-.342 1.616a5.48 5.48 0 002.108.404c2.108.057 3.418-.981 3.418-2.539 0-1.962-2.678-2.077-2.678-2.942zm9.457 5.422L27.16 8.172h-1.652a.858.858 0 00-.798.577l-2.848 6.924h1.994l.398-1.096h2.45l.228 1.096h1.766zm-2.905-5.482l.57 2.827h-1.596l1.026-2.827z" fill="#fff"></path>
                        </svg>
                        <div class="text-zinc-800 font-semibold mt-1">
                            Se terminant par <?= substr($orderInfos["card-number"], -4) ?>
                        </div>
                        <div class="text-zinc-600">Expire le <?= $orderInfos["card-expiration"] ?></div>
                    </div>
                </div>
            </div>
            <div class="mt-6 text-center">
                <a href="/" class="text-orange-600 hover:underline">Continuer vos achats →</a>
            </div>
        </div>
    </div>
</section>