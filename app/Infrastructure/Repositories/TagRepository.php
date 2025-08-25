<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Blog\Repositories\TagRepositoryInterface;
use App\Domain\Blog\Entities\Tag;
use App\Infrastructure\Models\Tag as TagModel;

class TagRepository implements TagRepositoryInterface
{
    public function save(Tag $tag): Tag
    {
        $tagData = $tag->toArray();

        if ($tag->getId()) {
            // Güncelleme
            $tagModel = TagModel::find($tag->getId());
            if (!$tagModel) {
                throw new \Exception('Tag not found for update');
            }
            $tagModel->update($tagData);
        } else {
            // Yeni oluşturma
            $tagModel = new TagModel();
            $tagModel->fill($tagData);
            $tagModel->save();

            // Domain entity'ye ID'yi set et
            $tag->setId($tagModel->id);
        }

        return $tag;
    }

    public function findById(int $id): ?Tag
    {
        $tagModel = TagModel::find($id);

        if (!$tagModel) {
            return null;
        }

        return $tagModel->toDomainEntity();
    }

    public function findBySlug(string $slug): ?Tag
    {
        $tagModel = TagModel::where('slug', $slug)->first();

        if (!$tagModel) {
            return null;
        }

        return $tagModel->toDomainEntity();
    }

    public function findByName(string $name): ?Tag
    {
        $tagModel = TagModel::where('name', $name)->first();

        if (!$tagModel) {
            return null;
        }

        return $tagModel->toDomainEntity();
    }

    public function findAll(): array
    {
        $tags = TagModel::orderBy('name')->get();

        return $tags->map(fn($tag) => $tag->toDomainEntity())->toArray();
    }

    public function findActive(): array
    {
        $tags = TagModel::where('is_active', true)
            ->orderBy('name')
            ->get();

        return $tags->map(fn($tag) => $tag->toDomainEntity())->toArray();
    }

    public function findPopular(int $limit = 10): array
    {
        $tags = TagModel::withCount('blogs')
            ->orderBy('blogs_count', 'desc')
            ->limit($limit)
            ->get();

        return $tags->map(fn($tag) => $tag->toDomainEntity())->toArray();
    }

    public function delete(int $id): bool
    {
        $tagModel = TagModel::find($id);

        if (!$tagModel) {
            return false;
        }

        return $tagModel->delete();
    }

    public function count(): int
    {
        return TagModel::count();
    }

    public function countActive(): int
    {
        return TagModel::where('is_active', true)->count();
    }
}
