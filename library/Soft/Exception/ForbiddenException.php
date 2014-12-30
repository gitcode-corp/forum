<?php

namespace Soft\Exception;

class ForbiddenException extends \Exception
{
    public function __construct($message = "403. Forbidden.", $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }
}
