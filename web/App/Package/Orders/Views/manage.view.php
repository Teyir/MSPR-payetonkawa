<?php

use WEB\Utils\Website;

Website::setTitle("Gestion des commandes");
Website::setDescription("Gérez les commandes.");
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
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Café cool</td>
                                    <td>20€</td>
                                    <td>HowBaka</td>
                                    <td>
                                        <a href="#" class="text-primary mr-3">
                                            <i class="fa fa-cog"></i>
                                        </a>
                                        <a href="#" class="text-danger mr-3">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>