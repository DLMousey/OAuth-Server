<?php

namespace Core\Exception;

use Exception;

class AlreadyLoggedInException extends Exception
{
    public function __construct($message = null)
    {
        if($message == null) {
            $message = "Already logged in";
        }

        parent::__construct($message, 40301);
    }
}
