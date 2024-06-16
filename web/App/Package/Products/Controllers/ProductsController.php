<?php

namespace WEB\Controller\Products;

use CURLFile;
use JetBrains\PhpStorm\NoReturn;
use WEB\Manager\Filter\FilterManager;
use WEB\Manager\Flash\Alert;
use WEB\Manager\Flash\Flash;
use WEB\Manager\Package\AbstractController;
use WEB\Manager\Router\Link;
use WEB\Manager\Views\View;
use WEB\Model\Product\ProductModel;
use WEB\Utils\Redirect;

class ProductsController extends AbstractController
{
    #[Link('/manage', Link::GET, scope: "/admin/products")]
    private function productsManage(): void
    {
        $products = ProductModel::getInstance()->getAll(false);

        View::createAdminView("Products", "manage")
            ->addVariableList(['products' => $products])
            ->addStyle("Admin/Resources/Vendors/Simple-datatables/style.css",
                "Admin/Resources/Assets/Css/Pages/simple-datatables.css",
                'Admin/Resources/Vendors/Izitoast/iziToast.min.css')
            ->addScriptBefore("App/Package/Users/Views/Assets/Js/edit.js",
                'Admin/Resources/Vendors/Izitoast/iziToast.min.js')
            ->addScriptAfter("Admin/Resources/Vendors/Simple-datatables/Umd/simple-datatables.js",
                "Admin/Resources/Assets/Js/Pages/simple-datatables.js")
            ->view();
    }

    #[Link('/add', Link::GET, scope: "/admin/products")]
    private function productsAdd(): void
    {
        View::createAdminView("Products", "add")
            ->view();
    }

    #[NoReturn] #[Link('/add', Link::POST, scope: "/admin/products")]
    private function productsAddPost(): void
    {
        $title = FilterManager::filterInputStringPost("title", 50);
        $description = FilterManager::filterInputStringPost("description", 65000);
        $price = FilterManager::filterInputFloatPost("price_kg");
        $kgRemaining = FilterManager::filterInputFloatPost("kg_remaining");

        $image = new CURLFile($_FILES['image']['tmp_name']);

        if (!ProductModel::getInstance()->create($title, $description, $price, $kgRemaining, $image)) {
            Flash::send(Alert::ERROR, 'Erreur', "Impossible de créer le produit.");
        } else {
            Flash::send(Alert::SUCCESS, "Succès", "Produit ajouté !");
        }

        Redirect::redirectPreviousRoute();
    }

    #[Link('/manage/edit/:id', Link::GET, ['id' => '[0-9]+'], "/admin/products")]
    private function productsEdit(int $id): void
    {
        $product = ProductModel::getInstance()->getById($id);

        if (is_null($product)) {
            Redirect::errorPage(404);
        }

        View::createAdminView("Products", "edit")
            ->addVariableList(['product' => $product])
            ->view();
    }

    #[NoReturn] #[Link('/manage/edit/:id', Link::POST, ['id' => '[0-9]+'], "/admin/products")]
    private function productsEditPost(int $id): void
    {
        $title = FilterManager::filterInputStringPost("title", 50);
        $description = FilterManager::filterInputStringPost("description", 65000);
        $price = FilterManager::filterInputFloatPost("price_kg");

        if (!ProductModel::getInstance()->update($id, $title, $description, $price)) {
            Flash::send(Alert::ERROR, 'Erreur', "Impossible de modifier le produit.");
        } else {
            Flash::send(Alert::SUCCESS, "Succès", "Produit modifié !");
        }

        Redirect::redirectPreviousRoute();
    }

    #[NoReturn] #[Link('/manage/delete/:id', Link::GET, ['id' => '[0-9]+'], "/admin/products")]
    private function productsDelete(int $id): void
    {
        $product = ProductModel::getInstance()->getById($id);

        if (is_null($product)) {
            Redirect::errorPage(404);
        }

        if (ProductModel::getInstance()->delete($id)) {
            Flash::send(Alert::SUCCESS, "Succès", "Produit supprimé !");
            Redirect::redirect("admin/products/manage");
        } else {
            Flash::send(Alert::ERROR, 'Erreur', "Impossible de supprimer le produit.");
            Redirect::redirectPreviousRoute();
        }
    }
}