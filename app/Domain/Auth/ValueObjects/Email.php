<?php

namespace App\Domain\Auth\ValueObjects;

class Email
{
    private string $value;

    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = strtolower(trim($email));
    }

    private function validate(string $email): void
    {
        if (empty(trim($email))) {
            throw new \InvalidArgumentException('Email adresi boş olamaz');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Geçersiz email formatı');
        }

        if (strlen($email) > 255) {
            throw new \InvalidArgumentException('Email adresi çok uzun');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
