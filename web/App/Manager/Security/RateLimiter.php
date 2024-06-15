<?php


namespace WEB\Manager\Security;


use WEB\Manager\Env\EnvManager;

class RateLimiter
{
    private string $cookieName = "web_rate_limit";
    private int $maxCount = 100;

    public function __construct()
    {
        $this->logic();
    }

    /**
     * @return void
     * @desc Check rate limit and return 429 if spam is detected
     */
    private function logic(): void
    {
        // If we are in devmode, we ignore the rateLimiter
        if (EnvManager::getInstance()->getValue('DEVMODE') === '1'){
            return;
        }

        if ($this->getCount() >= $this->maxCount) {
            http_response_code(429);
            die();
        }

        $this->increaseCounter();
    }

    /**
     * @return int
     * @desc Return count
     */
    private function getCount(): int
    {
        return isset($_COOKIE[$this->cookieName]) ? (int)$_COOKIE[$this->cookieName] : 0;
    }

    /**
     * @return void
     * @desc Increment counter
     */
    private function increaseCounter(): void
    {
        setcookie($this->cookieName, $this->getCount() + 1, time() + 60, "/", false, true);
    }

}