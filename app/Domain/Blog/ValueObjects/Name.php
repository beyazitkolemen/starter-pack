<?php

namespace App\Domain\Blog\ValueObjects;

class Name
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = trim($value);
    }

    private function validate(string $value): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }

        if (strlen($value) > 100) {
            throw new \InvalidArgumentException('Name cannot be longer than 100 characters');
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

    public function equals(Name $other): bool
    {
        return $this->value === $other->value;
    }
}
