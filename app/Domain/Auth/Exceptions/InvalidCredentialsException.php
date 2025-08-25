<?php

namespace App\Domain\Auth\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception
{
    public function __construct(string $message = 'Geçersiz kimlik bilgileri', int $code = 401)
    {
        parent::__construct($message, $code);
    }
}
