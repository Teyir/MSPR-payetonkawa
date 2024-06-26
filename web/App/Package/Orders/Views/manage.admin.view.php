<?php

use WEB\Utils\Website;

Website::setTitle("Gestion des commandes");
Website::setDescription("Gérez les commandes.");

/* @var \WEB\Entity\Orders\OrderEntity[] $orders */
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des commandes</h3>
                    </div>
                    <div class="card-body">
                        <table id="table1" class="table table-bordered table-striped text-center">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Total</th>
                                <th>User</th>
                                <th>Address</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td><?= $order->getId() ?></td>
                                    <td><?= $order->getProductId() ?></td>
                                    <td><?= $order->getPrice() ?>€</td>
                                    <td><?= $order->getUserId() ?></td>
                                    <td><?= $order->getAddress() ?></td>
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