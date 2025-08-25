<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\UserRepository;
use App\Domain\Blog\Repositories\BlogRepositoryInterface;
use App\Infrastructure\Repositories\BlogRepository;
use App\Domain\Blog\Repositories\CategoryRepositoryInterface;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Domain\Blog\Repositories\TagRepositoryInterface;
use App\Infrastructure\Repositories\TagRepository;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
