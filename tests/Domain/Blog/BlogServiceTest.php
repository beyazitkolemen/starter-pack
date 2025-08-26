<?php

namespace Tests\Domain\Blog;

use App\Domain\Blog\Services\BlogService;
use App\Domain\Blog\Repositories\BlogRepositoryInterface;
use App\Domain\Blog\Repositories\CategoryRepositoryInterface;
use App\Domain\Blog\Repositories\TagRepositoryInterface;
use App\Domain\Blog\Exceptions\CategoryNotFoundException;
use App\Domain\Blog\Exceptions\BlogNotFoundException;
use App\Domain\Blog\Entities\Category;
use App\Domain\Auth\Entities\User;
use Mockery;
use PHPUnit\Framework\TestCase;

class BlogServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_blog_throws_exception_when_category_not_found(): void
    {
        $blogRepo = Mockery::mock(BlogRepositoryInterface::class);
        $categoryRepo = Mockery::mock(CategoryRepositoryInterface::class);
        $tagRepo = Mockery::mock(TagRepositoryInterface::class);

        $categoryRepo->shouldReceive('findById')->with(1)->andReturn(null);

        $service = new BlogService($blogRepo, $categoryRepo, $tagRepo);

        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password123']);

        $this->expectException(CategoryNotFoundException::class);

        $service->createBlog([
            'title' => 'Test Blog',
            'content' => 'Content',
            'category_id' => 1
        ], $user);
    }

    public function test_get_blog_by_slug_throws_exception_when_not_found(): void
    {
        $blogRepo = Mockery::mock(BlogRepositoryInterface::class);
        $categoryRepo = Mockery::mock(CategoryRepositoryInterface::class);
        $tagRepo = Mockery::mock(TagRepositoryInterface::class);

        $blogRepo->shouldReceive('findBySlug')->with('missing-blog')->andReturn(null);

        $service = new BlogService($blogRepo, $categoryRepo, $tagRepo);

        $this->expectException(BlogNotFoundException::class);
        $service->getBlogBySlug('missing-blog');
    }

    public function test_get_published_blogs_returns_data(): void
    {
        $blogRepo = Mockery::mock(BlogRepositoryInterface::class);
        $categoryRepo = Mockery::mock(CategoryRepositoryInterface::class);
        $tagRepo = Mockery::mock(TagRepositoryInterface::class);

        $expected = ['blogs' => [], 'pagination' => ['current_page' => 1, 'per_page' => 10, 'total' => 0]];
        $blogRepo->shouldReceive('findPublished')->with(1, 10)->andReturn($expected);

        $service = new BlogService($blogRepo, $categoryRepo, $tagRepo);

        $result = $service->getPublishedBlogs();
        $this->assertSame($expected, $result);
    }
}

