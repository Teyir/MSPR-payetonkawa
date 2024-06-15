<?php

namespace WEB\Manager\Router;

use Exception;

class RouterException extends Exception
{
    public function __construct($message = null, $code = 403)
    {
        $message ??= 'Unknown ' . get_class($this);
        parent::__construct($message, $code);
    }
}