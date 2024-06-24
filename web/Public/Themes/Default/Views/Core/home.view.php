<?php

use WEB\Utils\Website;

Website::setTitle("Accueil");
Website::setDescription("Page d'accueil PayeTonKawa.fr");
?>


<div class="bg-zinc-100 h-screen w-screen flex flex-col justify-center items-center space-y-2">
    <h1 class="text-4xl tracking-tighter font-bold">Bienvenue sur payetonkawa.fr</h1>
    <p class="font-semibold">Découvrez les cafés les plus <span class="font-black tracking-widest text-orange-600">chauds</span> de ta région</p>
    <a class="btn" href="/web/products">Slurp</a>
</div>