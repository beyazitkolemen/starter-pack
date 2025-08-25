<?php

namespace App\Domain\Blog\Repositories;

use App\Domain\Blog\Entities\Category;

interface CategoryRepositoryInterface
{
    public function save(Category $category): Category;
    public function findById(int $id): ?Category;
    public function findBySlug(string $slug): ?Category;
    public function findAll(): array;
    public function findActive(): array;
    public function findActiveOrdered(): array;
    public function delete(int $id): bool;
    public function count(): int;
    public function countActive(): int;
}
