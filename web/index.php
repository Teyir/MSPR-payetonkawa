<?php

use WEB\Manager\Loader\Loader;

require_once("App/Manager/Loader/Loader.php");

Loader::loadProject();

Loader::manageErrors();

Loader::loadAttributes();

Loader::loadRoutes();

Loader::listenRouter();
