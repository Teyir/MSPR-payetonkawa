<?php

namespace WEB\Controller\Orders;

use WEB\Manager\Filter\FilterManager;
use WEB\Manager\Flash\Alert;
use WEB\Manager\Flash\Flash;
use WEB\Manager\Package\AbstractController;
use WEB\Manager\Router\Link;
use WEB\Manager\Views\View;
use WEB\Model\Orders\OrderModel;
use WEB\Model\Product\ProductModel;
use WEB\Model\Users\UsersModel;
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

        if (!UsersModel::getInstance()->isLogged()) {
            Flash::send(Alert::WARNING, "Il faut être connecté pour pouvoir faire une commande", '');
            Redirect::redirectPreviousRoute();
        }

        $view = new View('Orders', 'checkout');
        $view->addVariableList(["productList" => $products]);
        $view->view();
    }

    #[Link("/checkout", Link::POST)]
    public function createOrder(): void
    {
        $cart = [];
        $user = UsersModel::getInstance()->getCurrentUser();

        foreach ($_SESSION["cart"] as $productId) {
            $cart[] = ProductModel::getInstance()->getById($productId);
        }

        if (empty($cart)) {
            Flash::send(Alert::WARNING, "Panier vide", '');
            Redirect::redirectPreviousRoute();
        }

        $orderInfos = [
            'name' => FilterManager::filterInputStringPost('name'),
            'country' => FilterManager::filterInputStringPost('country'),
            'address' => FilterManager::filterInputStringPost('address'),
            'zipCode' => FilterManager::filterInputStringPost('zip-code'),
            'city' => FilterManager::filterInputStringPost('city')
        ];

        $allFieldsFilled = true;

        foreach ($orderInfos as $value) {
            if (empty($value)) {
                $allFieldsFilled = false;
                break;
            }
        }

        if (!$allFieldsFilled) {
            Flash::send(Alert::WARNING, "Merci de remplir tous les champs", '');
            Redirect::redirectPreviousRoute();
        }

        $fullAddress = $orderInfos['address'] . ", " . $orderInfos['zipCode'] . ", " . $orderInfos['city'] . ", " . $orderInfos['country'];

        foreach ($cart as $product) {
            OrderModel::getInstance()->create(1, $product->getPricePerKg(), $product->getId(), $user->getId(), $fullAddress);
        }

        $_SESSION["cart"] = [];

        $view = new View('Orders', 'thanks');
        $view->addVariableList(["productList" => $cart, "orderInfos" => $orderInfos]);
        $view->view();
    }
}