<?php

namespace App\Domain\Blog\Exceptions;

use Exception;

class BlogNotFoundException extends Exception
{
    public function __construct(string $message = 'Blog not found', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
