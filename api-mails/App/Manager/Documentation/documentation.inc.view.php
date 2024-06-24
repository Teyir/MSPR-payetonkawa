<?php

/* @var array $data */

use Mails\Manager\Version\VersionManager;


?>
<style>
    body {
        font-family: Consolas, Helvetica, sans-serif;
    }

    .shadow {
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    p {
        margin: 0;
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    .flex {
        display: flex;
        align-items: center;
    }

    .mx-4 {
        margin-top: 3rem;
        margin-bottom: 3rem;
    }

    .px-4 {
        padding-right: 1.5rem;
        padding-left: 1.5rem;
    }

    .py-4 {
        padding-top: 0.1rem;
        padding-bottom: 0.1rem;
    }

    .px-96 {
        padding-right: 24rem;
        padding-left: 24rem;
    }

    @media (max-width: 1280px) {
        .px-96 {
            padding-right: 16rem; /* Réduire à 16rem */
            padding-left: 16rem;
        }
    }

    @media (max-width: 1024px) {
        .px-96 {
            padding-right: 8rem;
            padding-left: 8rem;
        }
    }

    @media (max-width: 768px) {
        .px-96 {
            padding-right: 4rem;
            padding-left: 4rem;
        }
    }

    @media (max-width: 480px) {
        .px-96 {
            padding-right: 2rem;
            padding-left: 2rem;
        }
    }

    .slug {
        font-weight: bold;
        margin-right: 1rem;
    }

    .get-card {
        color: white;
        background-color: #4791d7;
        padding-top: 0.2rem;
        padding-bottom: 0.2rem;
        border-radius: 0.25rem;
        width: 5rem;
        text-align: center;
        font-weight: bold;
        font-size: large;
        margin-right: 1rem;
    }

    .get {
        color: black;
        background-color: #E6F1FA;
    }

    .put-card {
        color: white;
        background-color: #FFA103;
        padding-top: 0.2rem;
        padding-bottom: 0.2rem;
        border-radius: 0.25rem;
        width: 5rem;
        text-align: center;
        font-weight: bold;
        font-size: large;
        margin-right: 1rem;
    }

    .put {
        color: black;
        background-color: #FAF0E0;
    }

    .post-card {
        color: white;
        background-color: #00D891;
        padding-top: 0.2rem;
        padding-bottom: 0.2rem;
        border-radius: 0.25rem;
        width: 5rem;
        text-align: center;
        font-weight: bold;
        font-size: large;
        margin-right: 1rem;
    }

    .post {
        color: black;
        background-color: #E0F6EF;
    }

    .delete-card {
        color: white;
        background-color: #FF0029;
        padding-top: 0.2rem;
        padding-bottom: 0.2rem;
        border-radius: 0.25rem;
        width: 5rem;
        text-align: center;
        font-weight: bold;
        font-size: large;
        margin-right: 1rem;
    }

    .delete {
        color: black;
        background-color: #FAE0E4;
    }


    .accordion-button {
        border-radius: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        width: 100%;
        text-align: left;
        border: none;
        outline: none;
        transition: background-color 0.2s ease;
    }

    .accordion-item {
        border-radius: 0.25rem;
        margin-bottom: 1rem;
        padding: 10px;
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        padding: 0 10px;
    }

    /* Style lors de l'ouverture de l'accordéon */
    .accordion-button.active + .accordion-content {
        max-height: 100px;
        margin-top: 8px;
        border-top: #d2d2d2 solid 1px;
    }

    .arrow-down {
        width: 0;
        height: 0;
        border-left: 10px solid transparent; /* Taille du côté gauche de la flèche */
        border-right: 10px solid transparent; /* Taille du côté droit de la flèche */
        border-top: 10px solid black; /* Couleur et taille de la flèche */
    }

    .arrow-up {
        width: 0;
        height: 0;
        border-left: 10px solid transparent; /* Taille du côté gauche de la flèche */
        border-right: 10px solid transparent; /* Taille du côté droit de la flèche */
        border-bottom: 10px solid black; /* Couleur et taille de la flèche */
    }
</style>

<section class="mx-4 px-96">
    <div class="px-4 py-4 shadow rounded-lg">
        <h1>PayeTonKawa - Mails - API v<?= VersionManager::VERSION ?></h1>
        <div class="accordion">

            <?php foreach ($data as $controller): ?>
                <div>
                    <?php if ($controller !== []): ?>
                        <br>
                    <?php endif; ?>

                    <?php foreach ($controller as $item): /* @var \Mails\Manager\Documentation\DocumentationEntity $item */ ?>
                        <div class="accordion-item <?= $item->getMethodeLowerCase() ?>">
                            <div class="accordion-button <?= $item->getMethodeLowerCase() ?>">
                                <div class="flex">
                                    <p class="<?= $item->getMethodeLowerCase() ?>-card"><?= $item->getMethode() ?></p>
                                    <p class="slug"><?= $item->getSlug() ?></p>
                                    <p><?= $item->getDocFormatted() ?></p>
                                </div>
                                <div class="arrow arrow-down"></div>
                            </div>
                            <div class="accordion-content">
                                <?php if ($item->getMethode() === "POST"): ?>
                                    <ul>
                                        <?php foreach ($item->getDocForPost() as $doc): ?>
                                            <li><?= $doc ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php elseif ($item->getMethode() === "PUT"): ?>
                                    <ul>
                                        <?php foreach ($item->getDocForPut() as $doc): ?>
                                            <li><?= $doc ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <ul>
                                        <?php foreach ($item->getTypes() as $type): ?>
                                            <li><?= $type->getName() ?> => <?= $type->getType() ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<script>
    const buttons = document.querySelectorAll('.accordion-button');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const arrow = button.querySelector('.arrow');
            button.classList.toggle('active');
            arrow.classList.toggle('arrow-down');
            arrow.classList.toggle('arrow-up');

            const content = button.nextElementSibling;
            if (button.classList.contains('active')) {
                content.style.maxHeight = content.scrollHeight + "px";
            } else {
                content.style.maxHeight = null;
            }
        });
    });
</script>