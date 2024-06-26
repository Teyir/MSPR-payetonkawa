<?php

namespace Mails\Controller\Core;

use JetBrains\PhpStorm\NoReturn;
use Mails\Manager\Broker\BrokerManager;
use Mails\Manager\Class\AbstractController;
use Mails\Manager\Documentation\DocumentationManager;
use Mails\Manager\Error\RequestsError;
use Mails\Manager\Error\RequestsErrorsTypes;
use Mails\Manager\Router\Link;
use Mails\Manager\Router\LinkTypes;
use Mails\Manager\Security\EncryptManager;
use Mails\Manager\Mails\MailsManager;
use Mails\Model\Core\CoreModels;

class CoreController extends AbstractController
{

    /**
     * @return void
     * @desc Return doc page
     */
    #[NoReturn] #[Link("/", LinkTypes::GET, [], isUsingCache: false)]
    private function index(): void
    {
        new DocumentationManager();
        die();
    }

    /**
     * @desc Send mail with broker listener
     */
    #[Link("/send", LinkTypes::POST)]
    private function sendMail(): array
    {
        $broker = BrokerManager::getInstance();

        $broker->listen('orders', function ($msg) {

            //print $msg->body;
            
            $user = CoreModels::getInstance()->getUserById($msg->body);

            MailsManager::sendMailSMTP(
                EncryptManager::decrypt($user['email']),
                "Merci pour votre commande !",
                "Bonjour {$user['first_name']} {$user['last_name']}, <br>Merci pour votre commande sur payetonkawa.fr !",
            );

            if (empty($user)) {
                RequestsError::returnError(RequestsErrorsTypes::NOT_FOUND, ["Description" => "Unable to find user #{$msg->body}."]);
            }



            BrokerManager::getInstance()->close();
            exit;
        });

        return ['status' => 1];
    }
}
