<?php

namespace Soft\Exception;

class ViewNotFoundException extends \RuntimeException
{
    public function __construct($path)
    {
        parent::__construct(sprintf('The file "%s" does not exist.', $path));
    }
}
