<?php

namespace WEB\Controller\Users;

use JetBrains\PhpStorm\NoReturn;
use WEB\Manager\Filter\FilterManager;
use WEB\Manager\Flash\Alert;
use WEB\Manager\Flash\Flash;
use WEB\Manager\Package\AbstractController;
use WEB\Manager\Router\Link;
use WEB\Manager\Views\View;
use WEB\Model\Users\UsersModel;
use WEB\Utils\Redirect;

class UsersPublicController extends AbstractController
{
    #[Link('/login', Link::GET)]
    private function frontLogin(): void
    {
        if (UsersModel::getInstance()->isLogged()) {
            Redirect::redirectToHome();
        }

        $view = new View("Users", "login");
        $view->view();
    }

    #[NoReturn] #[Link('/login', Link::POST)]
    private function frontLoginPost(): void
    {
        $email = FilterManager::filterInputStringPost('email');
        $password = FilterManager::filterInputStringPost('password');

        if (UsersModel::getInstance()->login($email, $password)) {
            Flash::send(Alert::SUCCESS, "Content de vous revoir !", '');
            Redirect::redirectToHome();
        } else {
            Flash::send(Alert::WARNING, 'Attention', "Identifiants invalides.");
            Redirect::redirectPreviousRoute();
        }
    }

    #[Link('/register', Link::GET)]
    private function frontRegister(): void
    {
        if (UsersModel::getInstance()->isLogged()) {
            Redirect::redirectToHome();
        }

        $view = new View("Users", "register");
        $view->view();
    }

    #[NoReturn] #[Link('/register', Link::POST)]
    private function frontRegisterPost(): void
    {
        $firstName = FilterManager::filterInputStringPost('first_name');
        $lastName = FilterManager::filterInputStringPost('last_name');
        $email = FilterManager::filterInputStringPost('email');
        $password = FilterManager::filterInputStringPost('password');

        if (UsersModel::getInstance()->register($firstName, $lastName, $email, $password)) {
            Flash::send(Alert::SUCCESS, "Bienvenue ", "$firstName $lastName");
            Redirect::redirectToHome();
        } else {
            Flash::send(Alert::WARNING, 'Attention', "E-mail déjà utilisée.");
            Redirect::redirectPreviousRoute();
        }
    }

    #[NoReturn] #[Link('/logout', Link::GET)]
    private function logout(): void
    {
        if (!UsersModel::getInstance()->isLogged()) {
            Redirect::redirectExternal("https://traknard.com");
        } else {
            UsersModel::getInstance()->logout();
            Flash::send(Alert::SUCCESS, 'Succès', "Vous avez bien été déconnecté !");
        }

        Redirect::redirectToHome();
    }
}