<?php

namespace App\Domain\Blog\ValueObjects;

class Slug
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $this->normalize($value);
    }

    private function validate(string $value): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('Slug cannot be empty');
        }

        if (strlen($value) > 255) {
            throw new \InvalidArgumentException('Slug cannot be longer than 255 characters');
        }

        if (!preg_match('/^[a-z0-9-]+$/', $value)) {
            throw new \InvalidArgumentException('Slug can only contain lowercase letters, numbers and hyphens');
        }
    }

    private function normalize(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9-]+/', '-', $value);
        $value = trim($value, '-');
        return $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Slug $other): bool
    {
        return $this->value === $other->value;
    }

    public static function fromTitle(string $title): self
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9\s-]+/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return new self($slug);
    }
}
