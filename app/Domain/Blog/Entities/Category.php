<?php

namespace App\Domain\Blog\Entities;

use App\Domain\Blog\ValueObjects\Name;
use App\Domain\Blog\ValueObjects\Slug;
use App\Domain\Blog\ValueObjects\Description;
use DateTimeImmutable;

class Category
{
    private ?int $id = null;
    private Name $name;
    private Slug $slug;
    private ?Description $description = null;
    private ?string $color = null;
    private ?string $icon = null;
    private bool $isActive = true;
    private int $sortOrder = 0;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['name'])) {
            throw new \InvalidArgumentException('Name is required');
        }

        $this->name = new Name($attributes['name']);
        $this->slug = new Slug($attributes['slug'] ?? $this->generateSlug($attributes['name']));

        if (isset($attributes['description'])) {
            $this->description = new Description($attributes['description']);
        }

        if (isset($attributes['color'])) {
            $this->color = $attributes['color'];
        }

        if (isset($attributes['icon'])) {
            $this->icon = $attributes['icon'];
        }

        if (isset($attributes['is_active'])) {
            $this->isActive = $attributes['is_active'];
        }

        if (isset($attributes['sort_order'])) {
            $this->sortOrder = $attributes['sort_order'];
        }

        if (isset($attributes['id'])) {
            $this->id = $attributes['id'];
        }

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        if (isset($attributes['created_at'])) {
            $this->createdAt = new DateTimeImmutable($attributes['created_at']);
        }

        if (isset($attributes['updated_at'])) {
            $this->updatedAt = new DateTimeImmutable($attributes['updated_at']);
        }
    }

    private function generateSlug(string $name): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    public function activate(): void
    {
        $this->isActive = true;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function deactivate(): void
    {
        $this->isActive = false;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function setSortOrder(int $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
        $this->updatedAt = new DateTimeImmutable();
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): Name { return $this->name; }
    public function getSlug(): Slug { return $this->slug; }
    public function getDescription(): ?Description { return $this->description; }
    public function getColor(): ?string { return $this->color; }
    public function getIcon(): ?string { return $this->icon; }
    public function isActive(): bool { return $this->isActive; }
    public function getSortOrder(): int { return $this->sortOrder; }
    public function getCreatedAt(): DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): DateTimeImmutable { return $this->updatedAt; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setName(Name $name): void { $this->name = $name; $this->updatedAt = new DateTimeImmutable(); }
    public function setSlug(Slug $slug): void { $this->slug = $slug; $this->updatedAt = new DateTimeImmutable(); }
    public function setDescription(?Description $description): void { $this->description = $description; $this->updatedAt = new DateTimeImmutable(); }
    public function setColor(?string $color): void { $this->color = $color; $this->updatedAt = new DateTimeImmutable(); }
    public function setIcon(?string $icon): void { $this->icon = $icon; $this->updatedAt = new DateTimeImmutable(); }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name->getValue(),
            'slug' => $this->slug->getValue(),
            'description' => $this->description?->getValue(),
            'color' => $this->color,
            'icon' => $this->icon,
            'is_active' => $this->isActive,
            'sort_order' => $this->sortOrder,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}
