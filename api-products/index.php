<?php
header("Access-Control-Allow-Origin: *"); //TODO Limit that ?
header('Content-type: application/json;charset=utf-8');
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR");

use Products\Manager\Loader\Loader;
use Products\Manager\Security\AuthorizationManager;

require_once("App/Manager/Loader/Loader.php");

Loader::loadProject(isTestLoading: false);

Loader::manageErrors();

AuthorizationManager::handleAuthorization();

Loader::loadAttributes();

Loader::loadRoutes();

Loader::listenRouter();