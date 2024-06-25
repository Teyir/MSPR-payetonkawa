<?php

namespace WEB\Controller\Orders;

use WEB\Manager\Flash\Alert;
use WEB\Manager\Flash\Flash;
use WEB\Manager\Package\AbstractController;
use WEB\Manager\Router\Link;
use WEB\Manager\Views\View;
use WEB\Model\Product\ProductModel;
use WEB\Utils\Redirect;

class OrdersPublicController extends AbstractController {
    #[Link("/checkout", Link::GET)]
    public function publicCheckout(): void
    {
        $products = [];

        foreach ($_SESSION["cart"] as $productId) {
            $products[] = ProductModel::getInstance()->getById($productId);
        }

        if (empty($products)) {
            Flash::send(Alert::WARNING, "Votre panier est vide", '');
            Redirect::redirectPreviousRoute();
        }

        $view = new View('Orders', 'checkout');
        $view->addVariableList(["productList" => $products]);
        $view->view();
    }
}