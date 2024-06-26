<!-- Navigation-->
<?php

use WEB\Manager\Env\EnvManager;
use WEB\Model\Product\ProductModel;
use WEB\Model\Users\UsersModel;

$cartItems = [];
$subtotal = 0;
$cartList = $_SESSION['cart'] ?? [];
foreach ($cartList as $cartItem) {
    $item = ProductModel::getInstance()->getById($cartItem);
    $subtotal += $item->getPricePerKg();
    $cartItems[] = $item;
}

?>
<header class="bg-white absolute top-0 w-full">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex flex-1">
            <a href="/" class="-m-1.5 p-1.5">
                <p class="font-black tracking-tighter text-2xl">PayeTonKawa</p>
            </a>
        </div>
        <div class="flex lg:hidden">
            <button id="openMenuButton" type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-zinc-600">
                <span class="sr-only">Menu principal</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            <a href="/products" class="text-sm font-semibold leading-6 text-gray-900">Produits</a>
            <?php if(UsersModel::getInstance()->isAdmin()): ?>
                <a href="<?= EnvManager::getInstance()->getValue('PATH_SUBFOLDER') ?>admin/dashboard" class="text-sm font-semibold leading-6 text-gray-900">Dashboard</a>
            <?php endif; ?>
            <button id="toggleMenuBtn" class="text-sm font-semibold leading-6 text-gray-900">Panier</button>
        </div>
        <div class="hidden lg:flex flex-1 justify-end">
            <?php if(UsersModel::getInstance()->isLogged()): ?>
                <a href="/profile" class="text-sm font-semibold leading-6 text-gray-900">Profil <span aria-hidden="true">&rarr;</span></a>
            <?php else: ?>
                <a href="/login" class="text-sm font-semibold leading-6 text-gray-900">Se connecter <span aria-hidden="true">&rarr;</span></a>
            <?php endif; ?>
        </div>
    </nav>
    <div id="mobileMenu" class="hidden lg:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 z-10"></div>
        <div class="fixed flex flex-col justify-between inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-zinc-900/10">
            <div class="flex items-center justify-between">
                <a href="/" class="-m-1.5 p-1.5">
                    <p class="font-black tracking-tighter text-2xl">PayeTonKawa</p>
                </a>
                <button id="closeMenuButton" type="button" class="-m-2.5 rounded-md p-2.5 text-foreground">
                    <span class="sr-only">Fermer le menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6">
                    <div class="space-y-2 py-6">
                        <a class="mobile-menu-btn" href="<?= EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'products' ?>">Produits</a>
                        <div class="mobile-menu-btn" id="toggleMenuBtnMobile"><p>Panier</p></div>
                    </div>
                    <hr class="hr">
                    <div class="py-6">
                        <?php if (UsersModel::getInstance()->isLogged()): ?>
                            <a href="<?= EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'profile' ?>" class="mobile-menu-btn">Mon profil</a>
                        <?php else: ?>
                            <a href="<?= EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'login' ?>" class="mobile-menu-btn">Se connecter</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="slideOverMenu" class="relative z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-zinc-500 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div id="innerMenu" class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-md slide-in" id="menuContent">
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
                                                            <a href="/products/<?= $item->getId() ?>"><?= $item->getTitle() ?></a>
                                                        </h3>
                                                        <p class="ml-4"><?= $item->getPricePerKg() ?>€</p>
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
                                <a href="/checkout" class="flex items-center justify-center rounded-2xl border border-transparent bg-orange-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-orange-700">Commander</a>
                            </div>
                            <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                <p>
                                    ou
                                    <button id="continueShopping" type="button" class="font-medium text-orange-600 hover:text-orange-500">
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
        const toggleMenuBtnMobile = document.getElementById('toggleMenuBtnMobile');
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const slideOverMenu = document.getElementById('slideOverMenu');
        const innerMenu = document.getElementById('innerMenu');
        const menuContent = document.getElementById('menuContent');
        const continueShopping = document.getElementById('continueShopping');

        const closeMenu = () => {
            menuContent.classList.remove('slide-in');
            menuContent.classList.add('slide-out');
            setTimeout(() => {
                slideOverMenu.classList.add('hidden');
            }, 400);
        };

        toggleMenuBtn.addEventListener('click', () => {
            if (slideOverMenu.classList.contains('hidden')) {
                menuContent.classList.remove('slide-out');
                slideOverMenu.classList.remove('hidden');
                menuContent.classList.add('slide-in');
            } else {
                closeMenu();
            }
        });

        toggleMenuBtnMobile.addEventListener('click', () => {
            if (slideOverMenu.classList.contains('hidden')) {
                menuContent.classList.remove('slide-out');
                slideOverMenu.classList.remove('hidden');
                menuContent.classList.add('slide-in');
            } else {
                closeMenu();
            }
        });

        closeMenuBtn.addEventListener('click', closeMenu);
        continueShopping.addEventListener('click', closeMenu);

        document.addEventListener('click', (e) => {
            if (!innerMenu.contains(e.target) && !toggleMenuBtn.contains(e.target) && !toggleMenuBtnMobile.contains(e.target)) {
                if (!slideOverMenu.classList.contains('hidden')) {
                    closeMenu();
                }
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (!slideOverMenu.classList.contains('hidden')) {
                    closeMenu();
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        let openMenuButton = document.getElementById('openMenuButton');
        let closeMenuButton = document.getElementById('closeMenuButton');
        let mobileMenu = document.getElementById('mobileMenu');
        let backdrop = mobileMenu.querySelector('.fixed.inset-0');

        function openMenu() {
            mobileMenu.classList.remove('hidden');
        }

        function closeMenu() {
            mobileMenu.classList.add('hidden');
        }

        openMenuButton.addEventListener('click', openMenu);
        closeMenuButton.addEventListener('click', closeMenu);
        backdrop.addEventListener('click', closeMenu);
    });
</script>