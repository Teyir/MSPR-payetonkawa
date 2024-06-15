<?php

use WEB\Utils\Website;

Website::setTitle("Erreur");
Website::setDescription("Une erreur est survenue.");

/* @var $errorCode */
?>

<section class="page-section">
    <div class="container">
        Erreur <?= $errorCode ?> !
    </div>
</section>