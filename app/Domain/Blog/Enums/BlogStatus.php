<?php

namespace App\Domain\Blog\Enums;

enum BlogStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    /**
     * Enum değerini string olarak döndür
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Enum'ın label'ını döndür
     */
    public function getLabel(): string
    {
        return match($this) {
            self::DRAFT => 'Taslak',
            self::PUBLISHED => 'Yayınlandı',
            self::ARCHIVED => 'Arşivlendi',
        };
    }

    /**
     * Enum'ın color'ını döndür
     */
    public function getColor(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PUBLISHED => 'green',
            self::ARCHIVED => 'red',
        };
    }

    /**
     * Enum'ın icon'ını döndür
     */
    public function getIcon(): string
    {
        return match($this) {
            self::DRAFT => 'fas fa-edit',
            self::PUBLISHED => 'fas fa-check-circle',
            self::ARCHIVED => 'fas fa-archive',
        };
    }

    /**
     * Geçerli durumdan yeni duruma geçiş yapılabilir mi?
     */
    public function canTransitionTo(self $newStatus): bool
    {
        return match($this) {
            self::DRAFT => in_array($newStatus, [self::PUBLISHED, self::ARCHIVED]),
            self::PUBLISHED => $newStatus === self::ARCHIVED,
            self::ARCHIVED => false,
        };
    }

    /**
     * Tüm geçerli durumları döndür
     */
    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * String'den enum oluştur
     */
    public static function fromString(string $value): self
    {
        return match($value) {
            'draft' => self::DRAFT,
            'published' => self::PUBLISHED,
            'archived' => self::ARCHIVED,
            default => throw new \InvalidArgumentException("Invalid blog status: {$value}")
        };
    }

    /**
     * Enum'ın published olup olmadığını kontrol et
     */
    public function isPublished(): bool
    {
        return $this === self::PUBLISHED;
    }

    /**
     * Enum'ın draft olup olmadığını kontrol et
     */
    public function isDraft(): bool
    {
        return $this === self::DRAFT;
    }

    /**
     * Enum'ın archived olup olmadığını kontrol et
     */
    public function isArchived(): bool
    {
        return $this === self::ARCHIVED;
    }
}
