<?php

namespace Mails\Manager\Mails;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Mails\Manager\Env\EnvManager;

class MailsManager
{
    /**
     * @Param string $receiver -> mail to send
     * @Param string $subject -> subject of mail
     * @Param string $body -> html content with data
     *
     */
    public static function sendMailSMTP(string $receiver, string $subject, string $body): void
    {
        $env = EnvManager::getInstance();

        require_once('App/Manager/Mails/Vendors/PHPMailer/PHPMailer.php');
        require_once('App/Manager/Mails/Vendors/PHPMailer/SMTP.php');
        require_once('App/Manager/Mails/Vendors/PHPMailer/Exception.php');

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                    //To enable verbose debug output → SMTP::DEBUG_SERVER;
            $mail->isSMTP();                                       //Send using SMTP
            $mail->Host = $env->getValue("SMTP_ADDRESS");               //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                //Enable SMTP authentication
            $mail->Username = $env->getValue("SMTP_USER");                  //SMTP username
            $mail->Password = $env->getValue("SMTP_PASSWORD");             //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //TLS OR SSL
            $mail->Port = 465;               //TCP port
            $mail->CharSet = 'UTF-8';
            $mail->getSMTPInstance()->setTimeout(10);

            //Receiver config
            $mail->setFrom("noreply@traknard.com", "PayeTonKawa.fr");
            $mail->addAddress($receiver);
            $mail->addReplyTo("contact@traknard.com");

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body . "<br><br><br>" . "Propulsé par <a href='https://traknard.com'>Traknard</a>";

            //Send mail
            $mail->send();
        } catch (Exception) {
            echo "Message could not be sent. Mailer Error: $mail->ErrorInfo";
        }
    }
}