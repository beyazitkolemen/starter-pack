<?php

namespace App\Domain\Blog\ValueObjects;

class Status
{
    private const VALID_STATUSES = ['draft', 'published', 'archived'];

    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = strtolower(trim($value));
    }

    private function validate(string $value): void
    {
        if (!in_array(strtolower(trim($value)), self::VALID_STATUSES)) {
            throw new \InvalidArgumentException(
                'Status must be one of: ' . implode(', ', self::VALID_STATUSES)
            );
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isDraft(): bool
    {
        return $this->value === 'draft';
    }

    public function isPublished(): bool
    {
        return $this->value === 'published';
    }

    public function isArchived(): bool
    {
        return $this->value === 'archived';
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $newStatus = strtolower(trim($newStatus));

        // Draft -> Published veya Archived
        if ($this->isDraft()) {
            return in_array($newStatus, ['published', 'archived']);
        }

        // Published -> Archived
        if ($this->isPublished()) {
            return $newStatus === 'archived';
        }

        // Archived -> hiçbir şeye geçemez
        return false;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Status $other): bool
    {
        return $this->value === $other->value;
    }

    public static function draft(): self
    {
        return new self('draft');
    }

    public static function published(): self
    {
        return new self('published');
    }

    public static function archived(): self
    {
        return new self('archived');
    }
}
