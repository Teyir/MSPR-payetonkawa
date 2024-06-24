<!-- Navigation-->
<?php

use WEB\Manager\Security\SecurityManager;
use WEB\Model\Product\ProductModel;

$cartItems = [];
$subtotal = 0;
$cartList = $_SESSION['cart'];
foreach ($cartList as $cartItem) {
    $item = ProductModel::getInstance()->getById($cartItem);
    $subtotal += $item->getPricePerKg();
    $cartItems[] = $item;
}

?>
<header class="bg-white absolute top-0 w-full">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex flex-1">
            <a href="/web" class="-m-1.5 p-1.5">
                <p class="font-black tracking-tighter text-2xl">PayeTonKawa</p>
            </a>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            <a href="/web/products" class="text-sm font-semibold leading-6 text-gray-900">Produits</a>
            <button id="toggleMenuBtn" class="text-sm font-semibold leading-6 text-gray-900">Panier</button>
        </div>
        <div class="flex flex-1 justify-end">
            <a href="/web/login" class="text-sm font-semibold leading-6 text-gray-900">Se connecter <span aria-hidden="true">&rarr;</span></a>
        </div>
    </nav>
</header>

<div id="slideOverMenu" class="relative z-10 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-md">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Panier</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button id="closeMenuBtn" type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                        <span class="absolute -inset-0.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                                        <?php foreach ($cartItems as $item): ?>
                                            <li class="flex py-6">
                                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded border border-gray-200">
                                                    <img src="<?= $item->getImage() ?>" alt="<?= $item->getTitle() ?>" class="h-full w-full object-cover object-center">
                                                </div>
                                                <div class="ml-4 flex flex-1 flex-col">
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3>
                                                            <a href="/web/products/<?= $item->getId() ?>"><?= $item->getTitle() ?></a>
                                                        </h3>
                                                        <p class="ml-4"><?= $item->getPricePerKg() ?>€ / 1kg</p>
                                                    </div>
                                                    <p class="mt-1 text-sm text-gray-500">Il en reste <?= $item->getKgRemaining() ?>kg !</p>
                                                    <div class="flex flex-1 items-end justify-between text-sm">
                                                        <p class="text-gray-500">x 1</p>
                                                        <div class="flex">
                                                            <button type="submit" class="font-medium text-orange-600 hover:text-orange-500">Supprimer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Sous-total</p>
                                <p><?= $subtotal ?>€</p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Frais de port et taxes calculés au checkout.</p>
                            <div class="mt-6">
                                <a href="/web/checkout" class="flex items-center justify-center rounded-2xl border border-transparent bg-orange-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-orange-700">Commander</a>
                            </div>
                            <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                <p>
                                    ou
                                    <button type="button" class="font-medium text-orange-600 hover:text-orange-500">
                                        Continuer vos achats
                                        <span aria-hidden="true"> &rarr;</span>
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleMenuBtn = document.getElementById('toggleMenuBtn');
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const slideOverMenu = document.getElementById('slideOverMenu');

        toggleMenuBtn.addEventListener('click', () => {
            slideOverMenu.classList.toggle('hidden');
        });

        closeMenuBtn.addEventListener('click', () => {
            slideOverMenu.classList.add('hidden');
        });
    });
</script>