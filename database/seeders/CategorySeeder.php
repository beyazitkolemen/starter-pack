<?php

namespace Database\Seeders;

use App\Infrastructure\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Teknoloji',
                'description' => 'Teknoloji ile ilgili blog yazıları',
                'color' => '#3B82F6',
                'icon' => 'fas fa-microchip',
                'sort_order' => 1,
            ],
            [
                'name' => 'Yazılım Geliştirme',
                'description' => 'Yazılım geliştirme ve programlama',
                'color' => '#10B981',
                'icon' => 'fas fa-code',
                'sort_order' => 2,
            ],
            [
                'name' => 'Web Tasarım',
                'description' => 'Web tasarım ve kullanıcı deneyimi',
                'color' => '#F59E0B',
                'icon' => 'fas fa-palette',
                'sort_order' => 3,
            ],
            [
                'name' => 'Veritabanı',
                'description' => 'Veritabanı yönetimi ve optimizasyonu',
                'color' => '#8B5CF6',
                'icon' => 'fas fa-database',
                'sort_order' => 4,
            ],
            [
                'name' => 'DevOps',
                'description' => 'DevOps ve deployment süreçleri',
                'color' => '#EF4444',
                'icon' => 'fas fa-server',
                'sort_order' => 5,
            ],
            [
                'name' => 'Mobil Uygulama',
                'description' => 'Mobil uygulama geliştirme',
                'color' => '#06B6D4',
                'icon' => 'fas fa-mobile-alt',
                'sort_order' => 6,
            ],
            [
                'name' => 'Yapay Zeka',
                'description' => 'Yapay zeka ve makine öğrenmesi',
                'color' => '#EC4899',
                'icon' => 'fas fa-brain',
                'sort_order' => 7,
            ],
            [
                'name' => 'Güvenlik',
                'description' => 'Siber güvenlik ve güvenlik açıkları',
                'color' => '#DC2626',
                'icon' => 'fas fa-shield-alt',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'color' => $category['color'],
                'icon' => $category['icon'],
                'is_active' => true,
                'sort_order' => $category['sort_order'],
            ]);
        }
    }
}
