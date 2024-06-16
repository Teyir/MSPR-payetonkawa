<?php

use WEB\Manager\Security\SecurityManager;
use WEB\Utils\Website;

/* @var \WEB\Entity\Products\ProductEntity $product */

Website::setTitle("Modification produit - " . $product->getTitle());
Website::setDescription("Modification du produit " . $product->getTitle());

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="" method="post">
                    <?php (new SecurityManager())->insertHiddenToken() ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Modification d'un produit:</h3>
                        </div>

                        <div class="card-body">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-heading"></i></span>
                                <input type="text" name="title" class="form-control"
                                       value="<?= $product->getTitle() ?>"
                                       placeholder="Titre" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-paragraph"></i></span>
                                <textarea name="description" class="form-control"
                                          placeholder="Description"
                                          required><?= $product->getDescription() ?></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-scale-unbalanced-flip"></i></span>
                                <input type="text" name="price_kg" class="form-control" step="0.01"
                                       value="<?= $product->getPricePerKg() ?>"
                                       placeholder="Prix au kg" required>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                Ajouter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
