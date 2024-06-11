<?php
header("Access-Control-Allow-Origin: *"); //TODO Limit that ?
header('Content-type: application/json;charset=utf-8');
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR");

use Clients\Manager\Env\EnvManager;
use Clients\Manager\Loader\Loader;
use Clients\Manager\Security\AuthorizationManager;

require_once("App/Manager/Loader/Loader.php");

Loader::loadProject(isTestLoading: false);

//Load Composer autoload
require_once EnvManager::getInstance()->getValue('DIR') . 'vendor/autoload.php';

Loader::manageErrors();

AuthorizationManager::handleAuthorization();

Loader::loadAttributes();

Loader::loadRoutes();

Loader::listenRouter();