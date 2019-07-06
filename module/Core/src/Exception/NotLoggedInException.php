<?php

namespace Core\Exception;

use Exception;

class NotLoggedInException extends Exception
{
    public function __construct($message = null)
    {
        if($message == null) {
            $message = "Not logged in";
        }

        parent::__construct($message, 40302);
    }
}
