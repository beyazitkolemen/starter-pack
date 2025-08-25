<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Blog\Repositories\CategoryRepositoryInterface;
use App\Domain\Blog\Entities\Category;
use App\Infrastructure\Models\Category as CategoryModel;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function save(Category $category): Category
    {
        $categoryData = $category->toArray();

        if ($category->getId()) {
            // Güncelleme
            $categoryModel = CategoryModel::find($category->getId());
            if (!$categoryModel) {
                throw new \Exception('Category not found for update');
            }
            $categoryModel->update($categoryData);
        } else {
            // Yeni oluşturma
            $categoryModel = new CategoryModel();
            $categoryModel->fill($categoryData);
            $categoryModel->save();

            // Domain entity'ye ID'yi set et
            $category->setId($categoryModel->id);
        }

        return $category;
    }

    public function findById(int $id): ?Category
    {
        $categoryModel = CategoryModel::find($id);

        if (!$categoryModel) {
            return null;
        }

        return $categoryModel->toDomainEntity();
    }

    public function findBySlug(string $slug): ?Category
    {
        $categoryModel = CategoryModel::where('slug', $slug)->first();

        if (!$categoryModel) {
            return null;
        }

        return $categoryModel->toDomainEntity();
    }

    public function findAll(): array
    {
        $categories = CategoryModel::orderBy('name')->get();

        return $categories->map(fn($category) => $category->toDomainEntity())->toArray();
    }

    public function findActive(): array
    {
        $categories = CategoryModel::where('is_active', true)
            ->orderBy('name')
            ->get();

        return $categories->map(fn($category) => $category->toDomainEntity())->toArray();
    }

    public function findActiveOrdered(): array
    {
        $categories = CategoryModel::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return $categories->map(fn($category) => $category->toDomainEntity())->toArray();
    }

    public function delete(int $id): bool
    {
        $categoryModel = CategoryModel::find($id);

        if (!$categoryModel) {
            return false;
        }

        return $categoryModel->delete();
    }

    public function count(): int
    {
        return CategoryModel::count();
    }

    public function countActive(): int
    {
        return CategoryModel::where('is_active', true)->count();
    }
}
