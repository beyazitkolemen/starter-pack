<?php

namespace Database\Factories;

use App\Infrastructure\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(rand(1, 3), true);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(2),
            'color' => fake()->hexColor(),
            'icon' => fake()->randomElement([
                'fas fa-code', 'fas fa-palette', 'fas fa-database',
                'fas fa-server', 'fas fa-mobile-alt', 'fas fa-brain',
                'fas fa-shield-alt', 'fas fa-microchip', 'fas fa-globe'
            ]),
            'is_active' => fake()->boolean(90), // %90 ihtimalle active
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    /**
     * Kategoriyi active olarak ayarla
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Kategoriyi inactive olarak ayarla
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
