<?php

use WEB\Utils\Website;

Website::setTitle("Gestion des produits");
Website::setDescription("Gérez les produits.");

/* @var \WEB\Entity\Products\ProductEntity[] $products */

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des produits</h3>
                    </div>
                    <div class="card-body">
                        <table id="table1" class="table table-bordered table-striped text-center">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prix /kg</th>
                                <th>Kg restants</th>
                                <th>Commandes</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $product) : ?>
                                <tr>
                                    <td><?= $product->getId() ?></td>
                                    <td><?= $product->getTitle() ?></td>
                                    <td><?= $product->getPricePerKg() ?>€</td>
                                    <td><?= $product->getKgRemaining() ?></td>
                                    <td>XXX</td>
                                    <td>
                                        <a href="manage/edit/<?= $product->getId() ?>" class="text-primary mr-3">
                                            <i class="fa fa-cog"></i>
                                        </a>
                                        <a href="manage/delete/<?= $product->getId() ?>" class="text-danger mr-3">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>