<?php

namespace Database\Seeders;

use App\Infrastructure\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Laravel',
                'description' => 'Laravel framework ile ilgili yazılar',
                'color' => '#FF2D20',
            ],
            [
                'name' => 'PHP',
                'description' => 'PHP programlama dili',
                'color' => '#777BB4',
            ],
            [
                'name' => 'JavaScript',
                'description' => 'JavaScript programlama dili',
                'color' => '#F7DF1E',
            ],
            [
                'name' => 'Vue.js',
                'description' => 'Vue.js frontend framework',
                'color' => '#4FC08D',
            ],
            [
                'name' => 'React',
                'description' => 'React frontend framework',
                'color' => '#61DAFB',
            ],
            [
                'name' => 'Node.js',
                'description' => 'Node.js runtime environment',
                'color' => '#339933',
            ],
            [
                'name' => 'MySQL',
                'description' => 'MySQL veritabanı',
                'color' => '#4479A1',
            ],
            [
                'name' => 'PostgreSQL',
                'description' => 'PostgreSQL veritabanı',
                'color' => '#336791',
            ],
            [
                'name' => 'Redis',
                'description' => 'Redis cache ve veritabanı',
                'color' => '#DC382D',
            ],
            [
                'name' => 'Docker',
                'description' => 'Docker containerization',
                'color' => '#2496ED',
            ],
            [
                'name' => 'Git',
                'description' => 'Git version control',
                'color' => '#F05032',
            ],
            [
                'name' => 'API',
                'description' => 'API geliştirme ve tasarımı',
                'color' => '#FF6B6B',
            ],
            [
                'name' => 'Testing',
                'description' => 'Yazılım testleri',
                'color' => '#28A745',
            ],
            [
                'name' => 'Performance',
                'description' => 'Performans optimizasyonu',
                'color' => '#FFC107',
            ],
            [
                'name' => 'Security',
                'description' => 'Güvenlik konuları',
                'color' => '#DC3545',
            ],
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag['name'],
                'slug' => Str::slug($tag['name']),
                'description' => $tag['description'],
                'color' => $tag['color'],
                'is_active' => true,
                'usage_count' => 0,
            ]);
        }
    }
}
