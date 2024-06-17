<?php

namespace Mails\Model\Core;

use Mails\Manager\Api\APIManager;
use Mails\Manager\Api\APITypes;
use Mails\Manager\Class\AbstractModel;
use Mails\Manager\Requests\HttpMethodsType;

class CoreModels extends AbstractModel
{
    /**
     * @param int $id
     * @return array
     */
    public function getUserById(int $id): array
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::GET,
            APITypes::CUSTOMERS,
            "customers/$id",
        );

        return isset($req['id']) ? $req : [];
    }
}