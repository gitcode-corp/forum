<?php

namespace Soft\Exception;

class UnauthorizedException extends \Exception
{
    public function __construct($message = "401. Unauthorized.", $previous = null)
    {
        parent::__construct($message, 401, $previous);
    }
}
