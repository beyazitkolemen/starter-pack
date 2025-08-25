<?php

namespace App\Domain\Blog\Exceptions;

use Exception;

class InvalidBlogStatusException extends Exception
{
    public function __construct(string $message = 'Invalid blog status transition', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
