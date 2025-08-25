<?php

namespace App\Domain\Blog\Exceptions;

use Exception;

class TagNotFoundException extends Exception
{
    public function __construct(string $message = 'Tag not found', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
