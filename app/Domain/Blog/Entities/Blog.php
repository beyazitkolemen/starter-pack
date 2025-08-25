<?php

namespace App\Domain\Blog\Entities;

use App\Domain\Blog\ValueObjects\Title;
use App\Domain\Blog\ValueObjects\Content;
use App\Domain\Blog\ValueObjects\Slug;
use App\Domain\Blog\Enums\BlogStatus;
use App\Domain\Auth\Entities\User;
use App\Domain\Blog\Entities\Category;
use App\Domain\Blog\Entities\Tag;
use DateTimeImmutable;

class Blog
{
    private ?int $id = null;
    private Title $title;
    private Content $content;
    private Slug $slug;
    private BlogStatus $status;
    private ?string $excerpt = null;
    private ?string $featuredImage = null;
    private User $author;
    private Category $category;
    private array $tags = [];
    private DateTimeImmutable $publishedAt;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private int $viewCount = 0;
    private bool $isFeatured = false;

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['title'])) {
            throw new \InvalidArgumentException('Title is required');
        }
        if (!isset($attributes['content'])) {
            throw new \InvalidArgumentException('Content is required');
        }
        if (!isset($attributes['author'])) {
            throw new \InvalidArgumentException('Author is required');
        }
        if (!isset($attributes['category'])) {
            throw new \InvalidArgumentException('Category is required');
        }

        $this->title = new Title($attributes['title']);
        $this->content = new Content($attributes['content']);
        $this->author = $attributes['author'];
        $this->category = $attributes['category'];

        // Slug otomatik oluştur
        $this->slug = new Slug($attributes['slug'] ?? $this->generateSlug($attributes['title']));

        // Status varsayılan olarak draft
        $this->status = isset($attributes['status'])
            ? BlogStatus::fromString($attributes['status'])
            : BlogStatus::DRAFT;

        // Timestamps
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        // Diğer özellikler
        if (isset($attributes['excerpt'])) {
            $this->excerpt = $attributes['excerpt'];
        }
        if (isset($attributes['featured_image'])) {
            $this->featuredImage = $attributes['featured_image'];
        }
        if (isset($attributes['tags'])) {
            $this->tags = $attributes['tags'];
        }
        if (isset($attributes['is_featured'])) {
            $this->isFeatured = $attributes['is_featured'];
        }
        if (isset($attributes['view_count'])) {
            $this->viewCount = $attributes['view_count'];
        }
        if (isset($attributes['published_at'])) {
            $this->publishedAt = new DateTimeImmutable($attributes['published_at']);
        }
        if (isset($attributes['id'])) {
            $this->id = $attributes['id'];
        }
        if (isset($attributes['created_at'])) {
            $this->createdAt = new DateTimeImmutable($attributes['created_at']);
        }
        if (isset($attributes['updated_at'])) {
            $this->updatedAt = new DateTimeImmutable($attributes['updated_at']);
        }
    }

    private function generateSlug(string $title): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }

    public function publish(): void
    {
        if (!$this->status->canTransitionTo(BlogStatus::PUBLISHED)) {
            throw new \InvalidArgumentException('Blog cannot be published from current status');
        }

        $this->status = BlogStatus::PUBLISHED;
        $this->publishedAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function draft(): void
    {
        $this->status = BlogStatus::DRAFT;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function archive(): void
    {
        if (!$this->status->canTransitionTo(BlogStatus::ARCHIVED)) {
            throw new \InvalidArgumentException('Blog cannot be archived from current status');
        }

        $this->status = BlogStatus::ARCHIVED;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function incrementViewCount(): void
    {
        $this->viewCount++;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function addTag(Tag $tag): void
    {
        if (!in_array($tag, $this->tags, true)) {
            $this->tags[] = $tag;
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags = array_filter($this->tags, fn($t) => $t !== $tag);
        $this->updatedAt = new DateTimeImmutable();
    }

    public function setFeatured(bool $featured): void
    {
        $this->isFeatured = $featured;
        $this->updatedAt = new DateTimeImmutable();
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getTitle(): Title { return $this->title; }
    public function getContent(): Content { return $this->content; }
    public function getSlug(): Slug { return $this->slug; }
    public function getStatus(): BlogStatus { return $this->status; }
    public function getExcerpt(): ?string { return $this->excerpt; }
    public function getFeaturedImage(): ?string { return $this->featuredImage; }
    public function getAuthor(): User { return $this->author; }
    public function getCategory(): Category { return $this->category; }
    public function getTags(): array { return $this->tags; }
    public function getPublishedAt(): ?DateTimeImmutable { return $this->publishedAt; }
    public function getCreatedAt(): DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): DateTimeImmutable { return $this->updatedAt; }
    public function getViewCount(): int { return $this->viewCount; }
    public function isFeatured(): bool { return $this->isFeatured; }
    public function isPublished(): bool { return $this->status->isPublished(); }
    public function isDraft(): bool { return $this->status->isDraft(); }
    public function isArchived(): bool { return $this->status->isArchived(); }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setTitle(Title $title): void { $this->title = $title; $this->updatedAt = new DateTimeImmutable(); }
    public function setContent(Content $content): void { $this->content = $content; $this->updatedAt = new DateTimeImmutable(); }
    public function setSlug(Slug $slug): void { $this->slug = $slug; $this->updatedAt = new DateTimeImmutable(); }
    public function setExcerpt(?string $excerpt): void { $this->excerpt = $excerpt; $this->updatedAt = new DateTimeImmutable(); }
    public function setFeaturedImage(?string $featuredImage): void { $this->featuredImage = $featuredImage; $this->updatedAt = new DateTimeImmutable(); }
    public function setCategory(Category $category): void { $this->category = $category; $this->updatedAt = new DateTimeImmutable(); }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title->getValue(),
            'content' => $this->content->getValue(),
            'slug' => $this->slug->getValue(),
            'status' => $this->status->getValue(),
            'excerpt' => $this->excerpt,
            'featured_image' => $this->featuredImage,
            'author_id' => $this->author->getId(),
            'category_id' => $this->category->getId(),
            'tags' => array_map(fn($tag) => $tag->getId(), $this->tags),
            'published_at' => $this->publishedAt?->format('Y-m-d H:i:s'),
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
            'view_count' => $this->viewCount,
            'is_featured' => $this->isFeatured,
        ];
    }
}
