<?php

namespace App\Domain\Auth\ValueObjects;

class Password
{
    private string $value;

    public function __construct(string $password)
    {
        $this->validate($password);
        $this->value = $password;
    }

    private function validate(string $password): void
    {
        if (empty($password)) {
            throw new \InvalidArgumentException('Şifre boş olamaz');
        }

        if (strlen($password) < 8) {
            throw new \InvalidArgumentException('Şifre en az 8 karakter olmalıdır');
        }

        if (strlen($password) > 255) {
            throw new \InvalidArgumentException('Şifre çok uzun');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function hash(): string
    {
        return password_hash($this->value, PASSWORD_DEFAULT);
    }

    public function verify(string $hash): bool
    {
        return password_verify($this->value, $hash);
    }
}
