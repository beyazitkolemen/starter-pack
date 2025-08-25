<?php

namespace App\Domain\Blog\Repositories;

use App\Domain\Blog\Entities\Blog;

interface BlogRepositoryInterface
{
    public function save(Blog $blog): Blog;
    public function findById(int $id): ?Blog;
    public function findBySlug(string $slug): ?Blog;
    public function findPublished(int $page = 1, int $perPage = 10): array;
    public function findByCategory(int $categoryId, int $page = 1, int $perPage = 10): array;
    public function findByTag(int $tagId, int $page = 1, int $perPage = 10): array;
    public function findByAuthor(int $authorId, int $page = 1, int $perPage = 10): array;
    public function search(string $query, int $page = 1, int $perPage = 10): array;
    public function findFeatured(int $limit = 5): array;
    public function findPopular(int $limit = 10): array;
    public function delete(int $id): bool;
    public function countPublished(): int;
    public function countByCategory(int $categoryId): int;
    public function countByTag(int $tagId): int;
}
