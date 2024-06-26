<?php

namespace WEB\Controller\Orders;

use WEB\Manager\Package\AbstractController;
use WEB\Manager\Router\Link;
use WEB\Manager\Views\View;
use WEB\Model\Orders\OrderModel;

class OrdersController extends AbstractController
{
    #[Link('/manage', Link::GET, scope: '/admin/orders')]
    private function manageOrders(): void
    {
        $orders = OrderModel::getInstance()->getAll();

        View::createAdminView("Orders", "manage")
            ->addVariableList(['orders' => $orders])
            ->addStyle("Admin/Resources/Vendors/Simple-datatables/style.css",
                "Admin/Resources/Assets/Css/Pages/simple-datatables.css",
                'Admin/Resources/Vendors/Izitoast/iziToast.min.css')
            ->addScriptBefore("App/Package/Users/Views/Assets/Js/edit.js",
                'Admin/Resources/Vendors/Izitoast/iziToast.min.js')
            ->addScriptAfter("Admin/Resources/Vendors/Simple-datatables/Umd/simple-datatables.js",
                "Admin/Resources/Assets/Js/Pages/simple-datatables.js")
            ->view();
    }
}