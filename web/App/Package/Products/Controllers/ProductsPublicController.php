<?php

namespace WEB\Controller\Products;

use JetBrains\PhpStorm\NoReturn;
use WEB\Manager\Filter\FilterManager;
use WEB\Manager\Flash\Alert;
use WEB\Manager\Flash\Flash;
use WEB\Manager\Package\AbstractController;
use WEB\Manager\Router\Link;
use WEB\Manager\Views\View;
use WEB\Model\Product\ProductModel;
use WEB\Model\Users\UsersModel;
use WEB\Utils\Redirect;

class ProductsPublicController extends AbstractController {
    #[Link("/products", Link::GET)]
    public function publicListProducts(): void
    {
        $productList = ProductModel::getInstance()->getAll(false);
        $productModel = ProductModel::getInstance();

        $view = new View('Products', 'list');
        $view->addVariableList(["productList" => $productList, "productModel" => $productModel]);
        $view->view();
    }

    #[Link("/products/:productId", Link::GET, ["productId" => ".*?"])]
    public function publicProductsIndividual(string $productId): void
    {
        $product = ProductModel::getInstance()->getById($productId);

        if (is_null($product)) {
            Redirect::redirectToHome();
        }

        $view = new View('Products', 'individual');
        $view->addVariableList(["product" => $product]);
        $view->view();
    }

    #[NoReturn] #[Link("/products/:productId", Link::POST, ["productId" => ".*?"])]
    public function publicAddToCart(string $productId): void
    {
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        $_SESSION["cart"][] = $productId;

        Flash::send(Alert::SUCCESS, "Produit ajouté au panier", '');
        Redirect::redirectPreviousRoute();
    }
}