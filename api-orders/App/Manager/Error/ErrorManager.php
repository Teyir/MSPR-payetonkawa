<?php

namespace Orders\Manager\Error;


use DateTime;
use ErrorException;
use Throwable;

class ErrorManager
{
    private string $dirStorage = "App/Storage/Errors";

    public function __invoke(): void
    {
        self::enableErrorDisplays();
        $this->handleError();
    }

    /**
     * @return void
     */
    public static function enableErrorDisplays(): void
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    private function handleError(): void
    {
        register_shutdown_function(
            function () {
                $this->checkForFatal();
            }
        );
        set_error_handler(
            function ($num, $str, $file, $line) {
                $this->logError($num, $str, $file, $line);
            }
        );
        set_exception_handler(
            function ($e) {
                $this->logException($e);
            }
        );

    }

    /**
     * @throws \ErrorException
     */
    private function logError($num, $str, $file, $line): void
    {
        throw new ErrorException($str, 0, $num, $file, $line);
    }

    private function logException(Throwable $e): void
    {
        $message = $this->getLogMessage($e);
        file_put_contents("$this->dirStorage/{$this->getFileLogName()}", $message . PHP_EOL, FILE_APPEND);


        echo $this->displayError($e);
    }

    private function getFileLogName(): string
    {
        return "log_" . (new DateTime())->format("d-m-Y") . ".txt";
    }

    private function getLogMessage(Throwable $e): string
    {
        $date = (new DateTime())->format("H:i:s");
        $classType = get_class($e);
        return <<<EOL
        ==> Orders         : LOGGER SYSTEM
            [$date] Type     : $classType
            [$date] Message  : {$e->getMessage()}
            [$date] Location : {$e->getFile()}:{$e->getLine()}
            
        EOL;
    }

    private function displayError(Throwable $e): string
    {
        $classType = get_class($e);
        $trace = preg_replace("/#(\d)/", "<b>#$1</b><br>", $e->getTraceAsString());
        $trace = preg_replace("/<br>/", "</code><code style='margin: .6rem 0; display: block'>", $trace);
        return <<<HTML
        <style>
            .error {
                background: #343749;
                font-family: Verdana, sans-serif;
                color: white;
                padding: 1rem;
            }
            h2 {
                text-align: center;
            }
            h4 {
                text-align: center;
            }
            .error-message {
                color: red;
                font-size: 1rem;
            }
            .file {
                color: yellowgreen;
                font-size: 1rem;
            }
            .line {
                color: #ABB015;
                font-weight: bold;
                font-size: 1rem;
            }
            a {
                color: red;
            }
        </style>
            <div class="error">
                <h2>$classType</h2>
                    <p>Error : <code class="error-message">{$e->getMessage()}</code></p>
                    <p>Found in <code><span class="file">{$e->getFile()}</span></code> at the line <span class="line">{$e->getLine()}</span><p>
                    <p>Trace : <code class="trace">$trace</code></p>
            </div>
        HTML;

    }

    private function checkForFatal(): void
    {
        $error = error_get_last();
        if (!is_null($error) && $error["type"] === E_ERROR) {
            $this->logError($error["type"], $error["message"], $error["file"], $error["line"]);
        }
    }
}