<?php

namespace WEB\Controller\Core;

use WEB\Manager\Package\AbstractController;
use WEB\Manager\Router\Link;
use WEB\Manager\Views\View;

class CoreController extends AbstractController
{
    #[Link('/', Link::GET)]
    private function frontHome(): void
    {
        $view = new View("Core", "home");
        $view->view();
    }

    #[Link('/dashboard', Link::GET, scope: "/admin")]
    #[Link('/', Link::GET, scope: "/admin")]
    private function dashboard(): void
    {
        View::createAdminView("Core", "dashboard")->view();
    }
}