<?php

use WEB\Entity\Products\ProductEntity;
use WEB\Manager\Security\SecurityManager;
use WEB\Utils\Website;

Website::setTitle("Checkout");
Website::setDescription("Finalisation de ta commande PayeTonKawa");

/* @var ProductEntity[] $productList */

$subtotal = 0;
foreach ($productList as $cartItem) {
    $subtotal += $cartItem->getPricePerKg();
}
?>

<section class="bg-white py-20 antialiased dark:bg-gray-900 md:py-28">
    <form action="#" method="post" class="mx-auto max-w-screen-xl px-8">
        <?php (new SecurityManager())->insertHiddenToken() ?>
        <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
            <div class="min-w-0 flex-1 space-y-8">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Détails de livraison</h2>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Nom </label>
                            <input type="text" id="name" name="name" class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Ada Lovelace" required />
                        </div>

                        <div>
                            <div class="mb-2 flex items-center gap-2">
                                <label for="country" class="block text-sm font-medium text-gray-900 dark:text-white"> Pays </label>
                            </div>
                            <select id="country" name="country" class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                <option value="FR" selected>France</option>
                                <option value="ES">Espagne</option>
                                <option value="UK">Royaume Uni</option>
                                <option value="IT">Italie</option>
                                <option value="PT">Portugal</option>
                            </select>
                        </div>

                        <div>
                            <label for="address" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Adresse </label>
                            <input type="text" id="address" name="address" class="z-20 block w-full rounded border border-s-0 border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:border-s-gray-700  dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500" placeholder="2 Rue du Kawa" required />
                        </div>

                        <div>
                            <label for="zip-code" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Code postal </label>
                            <input type="number" id="zip-code" name="zip-code" class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="12345" required />
                        </div>

                        <div>
                            <label for="city" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Ville </label>
                            <input type="text" id="city" name="city" class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Kawa City" required />
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Livraison</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="classic" aria-describedby="classic" type="radio" name="delivery-method" value="5" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" checked />
                                </div>

                                <div class="ms-4 text-sm">
                                    <label for="classic" class="font-medium leading-none text-gray-900 dark:text-white">5€ - Classique</label>
                                    <p id="classic" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Chez-vous dans 6/7 jours ouvrés</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="express" aria-describedby="express" type="radio" name="delivery-method" value="10" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />
                                </div>

                                <div class="ms-4 text-sm">
                                    <label for="express" class="font-medium leading-none text-gray-900 dark:text-white">10€ - Express</label>
                                    <p id="express" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Chez-vous dans 2/3 jours ouvrés</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Carte Bancaire</h2>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="card-number" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Numéro de carte </label>
                            <input type="text" pattern="(\d{4}[- ]){3}\d{4}|\d{16}" id="card-number" name="card-number" class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="0000 0000 0000 0000" required />
                        </div>

                        <div>
                            <label for="card-expiration" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Expiration </label>
                            <input type="text" id="card-expiration" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" name="card-expiration" class="z-20 block w-full rounded border border-s-0 border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:border-s-gray-700  dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500" placeholder="20/03" required />
                        </div>

                        <div>
                            <label for="card-cvc" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> CVC </label>
                            <input type="number" id="card-cvc" pattern="\d{3}" name="card-cvc" class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="123" required />
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-6 w-full space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
                <div>
                    <div class="-my-3 divide-y divide-gray-200 dark:divide-gray-800">
                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Sous-total</dt>
                            <dd class="text-base font-medium text-gray-900 dark:text-white"><?= $subtotal ?>€</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Livraison</dt>
                            <dd id="shipping-field" class="text-base font-medium text-gray-900 dark:text-white">0€</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Dont TVA</dt>
                            <dd id="tax-field" class="text-base font-medium text-gray-900 dark:text-white">0€</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                            <dd id="total-field" class="text-base font-bold text-gray-900 dark:text-white">0€</dd>
                        </dl>
                    </div>
                </div>

                <div class="space-y-3">
                    <button type="submit" class="flex w-full items-center justify-center rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Commander</button>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deliveryMethods = document.getElementsByName('delivery-method');
        const shippingField = document.getElementById('shipping-field');
        const taxField = document.getElementById('tax-field');
        const totalField = document.getElementById('total-field');
        const subtotal = <?= $subtotal ?>;

        function updateFields() {
            let shippingCost = 0;
            for (const method of deliveryMethods) {
                if (method.checked) {
                    shippingCost = parseFloat(method.value);
                    break;
                }
            }
            const tax = (subtotal + shippingCost) * 0.2;
            const total = subtotal + shippingCost;

            shippingField.textContent = shippingCost.toFixed(2) + '€';
            taxField.textContent = tax.toFixed(2) + '€';
            totalField.textContent = total.toFixed(2) + '€';
        }

        for (const method of deliveryMethods) {
            method.addEventListener('change', updateFields);
        }

        updateFields();
    });
</script>

