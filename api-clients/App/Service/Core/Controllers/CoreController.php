<?php

namespace Clients\Controller\Core;

use Clients\Manager\Class\AbstractController;
use Clients\Manager\Router\Link;
use Clients\Manager\Router\LinkTypes;

class CoreController extends AbstractController
{
    #[Link("/test", LinkTypes::GET, [])]
    private function index(): array
    {
        return ['status' => 1];
    }
}