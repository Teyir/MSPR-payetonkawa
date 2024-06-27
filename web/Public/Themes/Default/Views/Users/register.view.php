<?php

use WEB\Manager\Security\SecurityManager;
use WEB\Utils\Website;

Website::setTitle("Inscription");
Website::setDescription("Inscrivez-vous sur PayeTonKawa.fr");
?>

<section class="h-screen">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-4xl font-bold leading-9 tracking-tight text-gray-900 tracking-tighter">Inscription</h2>
        </div>

        <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="" method="POST">
                <?php (new SecurityManager())->insertHiddenToken() ?>
                <div>
                    <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Nom</label>
                    <div class="mt-2">
                        <input id="last_name" name="last_name" type="text" autocomplete="family-name" placeholder="Lovelace" required
                               class="block w-full rounded-xl border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">Prénom</label>
                    <div class="mt-2">
                        <input id="first_name" name="first_name" type="text" autocomplete="given-name" placeholder="Ada" required
                               class="block w-full rounded-xl border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" placeholder="ada.lovelace@payetonkawa.fr" required
                               class="block w-full rounded-xl border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Mot de
                            passe</label>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" placeholder="**********" required
                               class="block w-full rounded-xl border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="mx-auto">
                    <!-- TODO : Captcha here -->
                </div>

                <div>
                    <button type="submit"
                            class="w-full btn">
                        S'inscrire
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Déjà membre ?
                <a href="/login"
                   class="font-semibold leading-6 text-orange-600 hover:text-orange-500">Se connecter</a>
            </p>
        </div>
    </div>
</section>