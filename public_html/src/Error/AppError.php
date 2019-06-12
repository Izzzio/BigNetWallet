<?php

namespace App\Error;

use Cake\Error\BaseErrorHandler;
use Cake\Error\ErrorHandler;

class AppError extends ErrorHandler
{
    public function _displayError($error, $debug)
    {

       /* if (strpos($error['description'], 'session_start()') !== false) {
            setcookie('PHPSESSID', null, -1, '/');
            if (!$debug) {

                header('Location: ' . BASE_PROTOCOL . '://' . BASE_DOMAIN);
                die;
            }
        }*/
        parent::_displayError($error, $debug);
    }

    public function _displayException($exception)
    {
        parent::_displayException($exception);
    }

    public function handleFatalError($code, $description, $file, $line)
    {
        return parent::handleFatalError($code, $description.print_r($_POST, true), $file, $line);
    }
}