<?php

namespace App\Domain\Auth\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct(string $message = 'Kullanıcı bulunamadı', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
