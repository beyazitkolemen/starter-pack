<?php

namespace App\Domain\Auth\ValueObjects;

class Name
{
    private string $value;

    public function __construct(string $name)
    {
        $this->validate($name);
        $this->value = trim($name);
    }

    private function validate(string $name): void
    {
        if (empty(trim($name))) {
            throw new \InvalidArgumentException('İsim boş olamaz');
        }

        if (strlen($name) < 2) {
            throw new \InvalidArgumentException('İsim en az 2 karakter olmalıdır');
        }

        if (strlen($name) > 50) {
            throw new \InvalidArgumentException('İsim en fazla 50 karakter olabilir');
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
