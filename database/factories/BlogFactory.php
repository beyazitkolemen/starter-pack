<?php

namespace Database\Factories;

use App\Infrastructure\Models\Blog;
use App\Infrastructure\Models\Category;
use App\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);
        
        return [
            'title' => $title,
            'content' => fake()->paragraphs(rand(3, 8), true),
            'slug' => Str::slug($title),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'excerpt' => fake()->paragraph(2),
            'featured_image' => fake()->imageUrl(800, 600, 'technology'),
            'author_id' => User::factory(),
            'category_id' => Category::factory(),
            'published_at' => fake()->optional()->dateTimeBetween('-1 year', 'now'),
            'view_count' => fake()->numberBetween(0, 10000),
            'is_featured' => fake()->boolean(20), // %20 ihtimalle featured
        ];
    }

    /**
     * Blog'u published olarak ayarla
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    /**
     * Blog'u draft olarak ayarla
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Blog'u featured olarak ayarla
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
