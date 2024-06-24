<?php

header("Cache-Control: max-age=2592000");

use WEB\Manager\Env\EnvManager;
use WEB\Manager\Views\View;
use WEB\Utils\Website;

/* @var string $title */
/* @var string $description */
/* @var array $includes */

$siteName = Website::getWebsiteName();

?>
    <!DOCTYPE html>
    <html lang="fr-FR">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <meta property="og:title" content=<?= $siteName ?>>
        <meta property="og:site_name" content="<?= $siteName ?>">
        <meta property="og:description" content="<?= Website::getWebsiteDescription() ?>">
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="<?= EnvManager::getInstance()->getValue('PATH_URL') ?>">

        <!-- CUSTOM HEADERS -->
        <?= Website::getCustomHeader() ?>

        <title><?= Website::getTitle() ?></title>
        <meta name="description" content="<?= Website::getDescription() ?>">

        <meta name="author" content="<?= $siteName ?>">
        <meta name="publisher" content="<?= $siteName ?>">
        <meta name="copyright" content="<?= $siteName ?>">
        <meta name="robots" content="follow, index, all"/>

        <!-- Core theme CSS (Includes Bootstrap)-->
        <link
                href="<?= EnvManager::getInstance()->getValue("PATH_SUBFOLDER") ?>Public/Themes/Default/Resources/Assets/Css/main.css"
                rel="stylesheet"/>

        <link
                href="<?= EnvManager::getInstance()->getValue("PATH_SUBFOLDER") ?>Public/Themes/Default/Resources/Assets/Css/output.css"
                rel="stylesheet"/>

        <?php
        View::loadInclude($includes, "styles");
        ?>

        <link rel="icon" type="image/x-icon" href="<?= Website::getFavicon() ?>">
    </head>
    <body>
<?php View::loadInclude($includes, "beforeScript", "beforePhp"); ?>