<?php

namespace WEB\Manager\Security;

use WEB\Manager\Env\EnvManager;
use WEB\Manager\Manager\AbstractManager;

class CaptchaManager extends AbstractManager
{
    public function getPublicReCaptchaData(): void
    {
        echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        echo '<div class="g-recaptcha" data-sitekey="' . EnvManager::getInstance()->getValue("RECAPTCHA_SITE_KEY") . '"></div>';
    }

    public function validateReCaptha(): bool
    {
        $recaptcha = $_POST['g-recaptcha-response'];

        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' .
            EnvManager::getInstance()->getValue("RECAPTCHA_SECRET_KEY") . '&response=' . $recaptcha;

        $response = file_get_contents($url);

        return json_decode($response, false, 512, JSON_THROW_ON_ERROR)->success;
    }
}