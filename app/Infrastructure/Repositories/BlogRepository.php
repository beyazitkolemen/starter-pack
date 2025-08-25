<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Blog\Repositories\BlogRepositoryInterface;
use App\Domain\Blog\Entities\Blog;
use App\Infrastructure\Models\Blog as BlogModel;
use App\Infrastructure\Models\Category as CategoryModel;
use App\Infrastructure\Models\Tag as TagModel;
use App\Infrastructure\Models\User as UserModel;
use Illuminate\Support\Collection;

class BlogRepository implements BlogRepositoryInterface
{
    public function save(Blog $blog): Blog
    {
        $blogData = $blog->toArray();

        if ($blog->getId()) {
            // Güncelleme
            $blogModel = BlogModel::find($blog->getId());
            if (!$blogModel) {
                throw new \Exception('Blog not found for update');
            }
            $blogModel->update($blogData);
        } else {
            // Yeni oluşturma
            $blogModel = new BlogModel();
            $blogModel->fill($blogData);
            $blogModel->save();

            // Domain entity'ye ID'yi set et
            $blog->setId($blogModel->id);
        }

        // Tag'leri sync et
        if (!empty($blogData['tags'])) {
            $blogModel->tags()->sync($blogData['tags']);
        }

        return $blog;
    }

    public function findById(int $id): ?Blog
    {
        $blogModel = BlogModel::with(['author', 'category', 'tags'])->find($id);

        if (!$blogModel) {
            return null;
        }

        return $blogModel->toDomainEntity();
    }

    public function findBySlug(string $slug): ?Blog
    {
        $blogModel = BlogModel::with(['author', 'category', 'tags'])
            ->where('slug', $slug)
            ->first();

        if (!$blogModel) {
            return null;
        }

        return $blogModel->toDomainEntity();
    }

    public function findPublished(int $page = 1, int $perPage = 10): array
    {
        $blogs = BlogModel::with(['author', 'category', 'tags'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'blogs' => $blogs->items(),
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ]
        ];
    }

    public function findByCategory(int $categoryId, int $page = 1, int $perPage = 10): array
    {
        $blogs = BlogModel::with(['author', 'category', 'tags'])
            ->published()
            ->byCategory($categoryId)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'blogs' => $blogs->items(),
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ]
        ];
    }

    public function findByTag(int $tagId, int $page = 1, int $perPage = 10): array
    {
        $blogs = BlogModel::with(['author', 'category', 'tags'])
            ->published()
            ->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            })
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'blogs' => $blogs->items(),
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ]
        ];
    }

    public function findByAuthor(int $authorId, int $page = 1, int $perPage = 10): array
    {
        $blogs = BlogModel::with(['author', 'category', 'tags'])
            ->published()
            ->byAuthor($authorId)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'blogs' => $blogs->items(),
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ]
        ];
    }

    public function search(string $query, int $page = 1, int $perPage = 10): array
    {
        $blogs = BlogModel::with(['author', 'category', 'tags'])
            ->published()
            ->search($query)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'blogs' => $blogs->items(),
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ]
        ];
    }

    public function findFeatured(int $limit = 5): array
    {
        $blogs = BlogModel::with(['author', 'category', 'tags'])
            ->published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        return $blogs->map(fn($blog) => $blog->toDomainEntity())->toArray();
    }

    public function findPopular(int $limit = 10): array
    {
        $blogs = BlogModel::with(['author', 'category', 'tags'])
            ->published()
            ->popular($limit)
            ->get();

        return $blogs->map(fn($blog) => $blog->toDomainEntity())->toArray();
    }

    public function delete(int $id): bool
    {
        $blogModel = BlogModel::find($id);

        if (!$blogModel) {
            return false;
        }

        // Tag'leri detach et
        $blogModel->tags()->detach();

        return $blogModel->delete();
    }

    public function countPublished(): int
    {
        return BlogModel::published()->count();
    }

    public function countByCategory(int $categoryId): int
    {
        return BlogModel::published()->byCategory($categoryId)->count();
    }

    public function countByTag(int $tagId): int
    {
        return BlogModel::published()
            ->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            })
            ->count();
    }
}
