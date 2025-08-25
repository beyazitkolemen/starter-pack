<?php

namespace App\Domain\Blog\Repositories;

use App\Domain\Blog\Entities\Tag;

interface TagRepositoryInterface
{
    public function save(Tag $tag): Tag;
    public function findById(int $id): ?Tag;
    public function findBySlug(string $slug): ?Tag;
    public function findByName(string $name): ?Tag;
    public function findAll(): array;
    public function findActive(): array;
    public function findPopular(int $limit = 10): array;
    public function delete(int $id): bool;
    public function count(): int;
    public function countActive(): int;
}
