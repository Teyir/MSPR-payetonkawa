<?php

namespace WEB\Utils;


use WEB\Manager\Env\EnvManager;
use WEB\Manager\Requests\HttpMethodsType;
use WEB\Manager\Router\Route;
use WEB\Manager\Router\Router;
use JetBrains\PhpStorm\NoReturn;

class Redirect
{

    private static function getRouteByUrl(string $url): ?Route
    {
        $router = Router::getInstance();
        $route = $router->getRouteByUrl($url, HttpMethodsType::GET);
        if (is_null($route)) {
            $route = $router->getRouteByName($url);
            if (is_null($route)) {
                return null;
            }
        }

        return $route;
    }

    /**
     * @param string $url Url or Route Name.
     */
    #[NoReturn] public static function redirect(string $url, array $params = []): void
    {
        $route = self::getRouteByUrl($url);

        if (is_null($route)) {
            return;
        }

        $strParams = implode(", ", $params);

        http_response_code(302);
        header("Location: " . EnvManager::getInstance()->getValue("PATH_SUBFOLDER") . $route->getUrl() . '/' . $strParams);
        die();
    }

    /**
     * @param string $url Internal URL.
     */
    #[NoReturn] public static function forceInternalRedirect(string $url, array $params = []): void
    {
        $strParams = implode(", ", $params);

        http_response_code(302);
        header("Location: " . EnvManager::getInstance()->getValue("PATH_SUBFOLDER") . $url . '/' . $strParams);
        die();
    }
    /**
     * @param int $code
     * @return void
     * @desc Redirect to errorPage
     */
    #[NoReturn] public static function errorPage(int $code): void
    {
        http_response_code($code);
        header("Location: " . EnvManager::getInstance()->getValue("PATH_SUBFOLDER") . $code);
        die();
    }

    /**
     * @return void
     * @desc Redirect to the website home page with 302
     */
    #[NoReturn] public static function redirectToHome(): void
    {
        http_response_code(302);
        // use self::redirect ??
        header("Location: " . EnvManager::getInstance()->getValue("PATH_SUBFOLDER"));
        die();
    }

    public static function emulateRoute(string $url): void
    {
        $route = self::getRouteByUrl($url);

        if (is_null($route)) {
            return;
        }

        $route->call();
    }

    /**
     * @return void
     * @desc Redirect browser to previous page
     */
    #[NoReturn] public static function redirectPreviousRoute(): void
    {
        http_response_code(302);
        // use self::redirect ??
        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
    }


    /**
     * @param string $url
     * @desc Redirect to external URL
     */
    #[NoReturn] public static function redirectExternal(string $url): void
    {
        http_response_code(302);
        header("Location: $url");
        die();
    }

}
