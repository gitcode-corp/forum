<?php

namespace Soft\Exception;

class ConnectionErrorException extends \Exception
{
    public function __construct($message = "", $previous = null)
    {
        parent::__construct("COnnection failed: " . $message, 500, $previous);
    }
}
