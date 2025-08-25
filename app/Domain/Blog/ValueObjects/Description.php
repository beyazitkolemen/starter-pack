<?php

namespace App\Domain\Blog\ValueObjects;

class Description
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = trim($value);
    }

    private function validate(string $value): void
    {
        if (strlen($value) > 500) {
            throw new \InvalidArgumentException('Description cannot be longer than 500 characters');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return empty(trim($this->value));
    }

    public function getWordCount(): int
    {
        return str_word_count(trim($this->value));
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Description $other): bool
    {
        return $this->value === $other->value;
    }
}
