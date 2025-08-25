<?php

namespace Database\Factories;

use App\Infrastructure\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(rand(1, 2), true);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->optional()->paragraph(1),
            'color' => fake()->hexColor(),
            'is_active' => fake()->boolean(95), // %95 ihtimalle active
            'usage_count' => fake()->numberBetween(0, 1000),
        ];
    }

    /**
     * Tag'i active olarak ayarla
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Tag'i inactive olarak ayarla
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Tag'i popular olarak ayarla (yüksek usage count)
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => fake()->numberBetween(100, 10000),
        ]);
    }
}
