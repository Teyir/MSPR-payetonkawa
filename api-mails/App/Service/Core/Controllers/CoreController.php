<?php

namespace Mails\Controller\Core;

use Mails\Manager\Broker\BrokerManager;
use Mails\Manager\Class\AbstractController;
use Mails\Manager\Error\RequestsError;
use Mails\Manager\Error\RequestsErrorsTypes;
use Mails\Manager\Router\Link;
use Mails\Manager\Router\LinkTypes;
use Mails\Manager\Security\EncryptManager;
use Mails\Model\Core\CoreModels;

class CoreController extends AbstractController
{
    #[Link("/send", LinkTypes::POST)]
    private function sendMail(): array
    {
        $broker = BrokerManager::getInstance();

        $broker->listen('orders', function ($msg) {

            print $msg->body;

            $user = CoreModels::getInstance()->getUserById($msg->body);

            if (empty($user)) {
                RequestsError::returnError(RequestsErrorsTypes::NOT_FOUND, ["Description" => "Unable to find user #{$msg->body}."]);
            }

            mail(
                EncryptManager::decrypt($user['email']),
                "Merci pour votre commande !",
                "Bonjour {$user['first_name']} {$user['last_name']}, \nMerci pour votre commande sur payetonkawa.fr !",
            );

            BrokerManager::getInstance()->close();
            exit;
        });

        return ['status' => 1];
    }
}
