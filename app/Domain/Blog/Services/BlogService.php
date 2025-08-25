<?php

namespace App\Domain\Blog\Services;

use App\Domain\Blog\Entities\Blog;
use App\Domain\Blog\Entities\Category;
use App\Domain\Blog\Entities\Tag;
use App\Domain\Blog\Repositories\BlogRepositoryInterface;
use App\Domain\Blog\Repositories\CategoryRepositoryInterface;
use App\Domain\Blog\Repositories\TagRepositoryInterface;
use App\Domain\Auth\Entities\User;
use App\Domain\Blog\ValueObjects\Title;
use App\Domain\Blog\ValueObjects\Content;
use App\Domain\Blog\ValueObjects\Slug;
use App\Domain\Blog\Enums\BlogStatus;
use App\Domain\Blog\Exceptions\BlogNotFoundException;
use App\Domain\Blog\Exceptions\CategoryNotFoundException;
use App\Domain\Blog\Exceptions\TagNotFoundException;
use App\Domain\Blog\Exceptions\InvalidBlogStatusException;

class BlogService
{
    public function __construct(
        private BlogRepositoryInterface $blogRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private TagRepositoryInterface $tagRepository
    ) {}

    public function createBlog(array $data, User $author): Blog
    {
        // Category kontrolü
        $category = $this->categoryRepository->findById($data['category_id']);
        if (!$category) {
            throw new CategoryNotFoundException('Category not found');
        }

        // Blog oluştur
        $blog = new Blog([
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => $author,
            'category' => $category,
            'excerpt' => $data['excerpt'] ?? null,
            'featured_image' => $data['featured_image'] ?? null,
            'status' => $data['status'] ?? BlogStatus::DRAFT->getValue(),
        ]);

        // Tags ekle
        if (isset($data['tags']) && is_array($data['tags'])) {
            foreach ($data['tags'] as $tagId) {
                $tag = $this->tagRepository->findById($tagId);
                if ($tag) {
                    $blog->addTag($tag);
                }
            }
        }

        return $this->blogRepository->save($blog);
    }

    public function updateBlog(int $blogId, array $data): Blog
    {
        $blog = $this->blogRepository->findById($blogId);
        if (!$blog) {
            throw new BlogNotFoundException('Blog not found');
        }

        // Title güncelle
        if (isset($data['title'])) {
            $blog->setTitle(new Title($data['title']));
        }

        // Content güncelle
        if (isset($data['content'])) {
            $blog->setContent(new Content($data['content']));
        }

        // Category güncelle
        if (isset($data['category_id'])) {
            $category = $this->categoryRepository->findById($data['category_id']);
            if (!$category) {
                throw new CategoryNotFoundException('Category not found');
            }
            $blog->setCategory($category);
        }

        // Excerpt güncelle
        if (isset($data['excerpt'])) {
            $blog->setExcerpt($data['excerpt']);
        }

        // Featured image güncelle
        if (isset($data['featured_image'])) {
            $blog->setFeaturedImage($data['featured_image']);
        }

        // Tags güncelle
        if (isset($data['tags']) && is_array($data['tags'])) {
            // Mevcut tag'leri temizle
            $currentTags = $blog->getTags();
            foreach ($currentTags as $tag) {
                $blog->removeTag($tag);
            }

            // Yeni tag'leri ekle
            foreach ($data['tags'] as $tagId) {
                $tag = $this->tagRepository->findById($tagId);
                if ($tag) {
                    $blog->addTag($tag);
                }
            }
        }

        return $this->blogRepository->save($blog);
    }

    public function publishBlog(int $blogId): Blog
    {
        $blog = $this->blogRepository->findById($blogId);
        if (!$blog) {
            throw new BlogNotFoundException('Blog not found');
        }

        try {
            $blog->publish();
        } catch (\InvalidArgumentException $e) {
            throw new InvalidBlogStatusException($e->getMessage());
        }

        return $this->blogRepository->save($blog);
    }

    public function draftBlog(int $blogId): Blog
    {
        $blog = $this->blogRepository->findById($blogId);
        if (!$blog) {
            throw new BlogNotFoundException('Blog not found');
        }

        $blog->draft();
        return $this->blogRepository->save($blog);
    }

    public function archiveBlog(int $blogId): Blog
    {
        $blog = $this->blogRepository->findById($blogId);
        if (!$blog) {
            throw new BlogNotFoundException('Blog not found');
        }

        try {
            $blog->archive();
        } catch (\InvalidArgumentException $e) {
            throw new InvalidBlogStatusException($e->getMessage());
        }

        return $this->blogRepository->save($blog);
    }

    public function deleteBlog(int $blogId): bool
    {
        $blog = $this->blogRepository->findById($blogId);
        if (!$blog) {
            throw new BlogNotFoundException('Blog not found');
        }

        return $this->blogRepository->delete($blogId);
    }

    public function getBlogBySlug(string $slug): Blog
    {
        $blog = $this->blogRepository->findBySlug($slug);
        if (!$blog) {
            throw new BlogNotFoundException('Blog not found');
        }

        // View count artır
        $blog->incrementViewCount();
        $this->blogRepository->save($blog);

        return $blog;
    }

    public function getPublishedBlogs(int $page = 1, int $perPage = 10): array
    {
        return $this->blogRepository->findPublished($page, $perPage);
    }

    public function getBlogsByCategory(int $categoryId, int $page = 1, int $perPage = 10): array
    {
        $category = $this->categoryRepository->findById($categoryId);
        if (!$category) {
            throw new CategoryNotFoundException('Category not found');
        }

        return $this->blogRepository->findByCategory($categoryId, $page, $perPage);
    }

    public function getBlogsByTag(int $tagId, int $page = 1, int $perPage = 10): array
    {
        $tag = $this->tagRepository->findById($tagId);
        if (!$tag) {
            throw new TagNotFoundException('Tag not found');
        }

        return $this->blogRepository->findByTag($tagId, $page, $perPage);
    }

    public function searchBlogs(string $query, int $page = 1, int $perPage = 10): array
    {
        return $this->blogRepository->search($query, $page, $perPage);
    }

    public function getFeaturedBlogs(int $limit = 5): array
    {
        return $this->blogRepository->findFeatured($limit);
    }

    public function getPopularBlogs(int $limit = 10): array
    {
        return $this->blogRepository->findPopular($limit);
    }
}
