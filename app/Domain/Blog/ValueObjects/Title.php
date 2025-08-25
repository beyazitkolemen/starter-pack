<?php

namespace App\Domain\Blog\ValueObjects;

class Title
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
            throw new \InvalidArgumentException('Title cannot be empty');
        }

        if (strlen($value) > 255) {
            throw new \InvalidArgumentException('Title cannot be longer than 255 characters');
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

    public function equals(Title $other): bool
    {
        return $this->value === $other->value;
    }
}
