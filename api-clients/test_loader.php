<?php

//Prevent external requests
if (isset($_SERVER['REQUEST_METHOD'])){
    require_once "index.php";
    die();
}

header("Access-Control-Allow-Origin: *"); //TODO Limit that ?
header('Content-type: application/json;charset=utf-8');
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR");

/* TESTS FEATURES */
ini_set('error_reporting', 1);
ini_set('log_errors_max_len', 0);
ini_set('xdebug.show_exception_trace', 0);
ini_set('xdebug.mode', 'coverage');

use Clients\Manager\Loader\Loader;

require_once("App/Manager/Loader/Loader.php");

Loader::loadProject(isTestLoading: true);

Loader::manageErrors();
