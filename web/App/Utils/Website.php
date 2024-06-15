<?php

namespace WEB\Utils;

use JetBrains\PhpStorm\ExpectedValues;
use WEB\Manager\Env\EnvManager;

class Website
{

    private static string $title;
    private static string $description;
    private static ?string $customHeader;

    /**
     * @param string $title
     * @return string
     */
    public static function setTitle(string $title): string
    {
        self::$title = $title;
        return $title;
    }

    /**
     * @param bool $useSiteName
     * @return string
     */
    public static function getTitle(bool $useSiteName = true): string
    {
        $title = $useSiteName ? self::getWebsiteName() . " | " . self::$title : self::$title;

        return htmlspecialchars_decode($title, ENT_QUOTES);
    }

    /**
     * @param string $description
     * @return string
     */
    public static function setDescription(string $description): string
    {
        self::$description = $description;
        return $description;
    }

    public static function getDescription(): string
    {
        return htmlspecialchars_decode(self::$description, ENT_QUOTES);
    }

    /**
     * @param string $data
     * @return string
     */
    public static function setCustomHeader(string $data): string
    {
        self::$customHeader = $data;
        return $data;
    }

    /**
     * @return string
     */
    public static function getCustomHeader(): string
    {
        return htmlspecialchars_decode(self::$customHeader ?? "", ENT_HTML5);
    }

    #[ExpectedValues(values: ['https', 'http'])]
    public static function getProtocol(): string
    {
        return in_array($_SERVER['HTTPS'] ?? '', ['on', 1], true) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https' ? 'https' : 'http';
    }

    public static function getUrl(): string
    {
        return self::getProtocol() . "://$_SERVER[HTTP_HOST]" . EnvManager::getInstance()->getValue("PATH_SUBFOLDER");
    }

    /**
     * @desc Return the client ip, for local users -> 127.0.0.1, if IP not valid -> 0.0.0.0
     * @return string
     */
    public static function getClientIp(): string
    {
        $NOT_VALID_IP = "0.0.0.0";

        $clientIp = $_SERVER['HTTP_CLIENT_IP'] ?? ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']);

        if (!filter_var($clientIp, FILTER_VALIDATE_IP)) {
            return $NOT_VALID_IP;
        }

        return $clientIp;
    }

    public static function refresh(bool $die = false): void
    {
        header("Refresh:0");

        if ($die) {
            die();
        }
    }

    /**
     * @param string $targetUrl
     * @return bool
     * @desc Useful function for active navbar page
     */
    public static function isCurrentPage(string $targetUrl): bool
    {
        $currentUrl = $_SERVER['REQUEST_URI'];

        if ($targetUrl[0] === '/') {
            $targetUrl = substr($targetUrl, 0);
        }

        $targetUrl = EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . $targetUrl;

        return $currentUrl === $targetUrl || $currentUrl === $targetUrl . '/' || $currentUrl === $targetUrl . '#';
    }

    /**
     * @param string $targetUrl
     * @return bool
     */
    public static function isContainingRoute(string $targetUrl): bool
    {
        $path = explode("/", $_SERVER["REQUEST_URI"]);
        return in_array($targetUrl, $path);
    }


    /**
     * @return string
     * @Desc Get the website name
     */
    public static function getWebsiteName(): string
    {
        return EnvManager::getInstance()->getValue('WEBSITE_NAME');
    }

    /**
     * @return string
     * @Desc Get the website description
     */
    public static function getWebsiteDescription(): string
    {
        return EnvManager::getInstance()->getValue('WEBSITE_DESCRIPTION');
    }

    public static function getFavicon(): string
    {
        return EnvManager::getInstance()->getValue("PATH_SUBFOLDER") . 'Public/Uploads/Favicon/favicon.ico';
    }

}