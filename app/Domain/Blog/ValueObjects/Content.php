<?php

namespace App\Domain\Blog\ValueObjects;

class Content
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('Content cannot be empty');
        }

        if (strlen($value) < 10) {
            throw new \InvalidArgumentException('Content must be at least 10 characters long');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getExcerpt(int $length = 150): string
    {
        $excerpt = strip_tags($this->value);
        if (strlen($excerpt) <= $length) {
            return $excerpt;
        }
        return substr($excerpt, 0, $length) . '...';
    }

    public function getWordCount(): int
    {
        return str_word_count(strip_tags($this->value));
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Content $other): bool
    {
        return $this->value === $other->value;
    }
}
