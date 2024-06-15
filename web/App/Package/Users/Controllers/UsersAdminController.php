<?php

namespace WEB\Controller\Users;

use WEB\Manager\Package\AbstractController;
use WEB\Manager\Router\Link;
use WEB\Manager\Views\View;

class UsersAdminController extends AbstractController
{
    #[Link('/manage', Link::GET, scope: '/admin/users')]
    private function manageUsers(): void
    {
        View::createAdminView('Users', 'manage')
            ->view();
    }
}