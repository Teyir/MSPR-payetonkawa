<?php

use WEB\Manager\Security\SecurityManager;
use WEB\Utils\Website;

Website::setTitle("Ajouter un produit");
Website::setDescription("Ajoutez un nouveau produit.");

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <?php (new SecurityManager())->insertHiddenToken() ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Ajouter au nouveau produit:</h3>
                        </div>

                        <div class="card-body">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-heading"></i></span>
                                <input type="text" name="title" class="form-control"
                                       placeholder="Titre" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-paragraph"></i></span>
                                <textarea name="description" class="form-control"
                                          placeholder="Description" required></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-scale-unbalanced-flip"></i></span>
                                <input type="text" name="price_kg" class="form-control" step="0.01"
                                       placeholder="Prix au kg" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-boxes-stacked"></i></span>
                                <input type="number" name="kg_remaining" class="form-control"
                                       placeholder="Stock de départ" required>
                            </div>
                            <div class="form-group">
                                <label>Image :</label>
                                <input class="mt-2 form-control form-control-lg" type="file"
                                       id="formFile"
                                       accept=".png, .jpg, .jpeg, .webp, .gif"
                                       name="image" required>
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
