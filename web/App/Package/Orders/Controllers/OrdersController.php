<?php

namespace WEB\Controller\Orders;

use WEB\Manager\Package\AbstractController;
use WEB\Manager\Router\Link;
use WEB\Manager\Views\View;

class OrdersController extends AbstractController
{
    #[Link('/manage', Link::GET, scope: '/admin/orders')]
    private function manageOrders(): void
    {
        View::createAdminView('Orders', 'manage')
            ->view();
    }
}