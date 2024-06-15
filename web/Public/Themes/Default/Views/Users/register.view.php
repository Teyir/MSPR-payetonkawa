<?php

use WEB\Manager\Security\SecurityManager;
use WEB\Utils\Website;

Website::setTitle("Inscription");
Website::setDescription("Inscrivez-vous sur PayeTonKawa.fr");
?>


<section class="page-section" id="contact">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Inscription</h2>
                <hr class="divider">
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
            <div class="col-lg-6">
                <form action="" method="post" class="mb-4">
                    <?php (new SecurityManager())->insertHiddenToken() ?>
                    <div class="form-floating mb-3">
                        <input class="form-control" name="first_name" id="first_name" type="text" placeholder="Prénom"
                               required>
                        <label for="first_name">Prénom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" name="last_name" id="last_name" type="text" placeholder="Nom"
                               required>
                        <label for="last_name">Nom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" name="email" id="email" type="email" placeholder="Votre mail"
                               required>
                        <label for="email">E-Mail</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="password" id="password" name="password" placeholder="****"
                               required>
                        <label for="password">Mot de passe</label>
                    </div>

                    <!-- TODO CAPTCHA -->

                    <div class="d-grid">
                        <button class="btn btn-xl" type="submit">
                            Connexion
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>