<?php

namespace Soft\Exception;

class PageNotFoundException extends \Exception
{
    public function __construct($message = "404. Page not found.", $code = 404, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
