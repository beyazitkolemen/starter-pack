<?php

namespace Database\Seeders;

use App\Infrastructure\Models\Blog;
use App\Infrastructure\Models\Category;
use App\Infrastructure\Models\Tag;
use App\Infrastructure\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Örnek blog yazıları
        $blogs = [
            [
                'title' => 'Laravel ile DDD Mimarisi Nasıl Uygulanır?',
                'content' => 'Bu makalede Laravel framework kullanarak Domain-Driven Design (DDD) mimarisini nasıl uygulayacağımızı öğreneceğiz. DDD, karmaşık iş mantığını yönetmek için güçlü bir yaklaşımdır ve Laravel ile mükemmel bir şekilde entegre edilebilir.

                ## DDD Nedir?
                Domain-Driven Design, iş mantığını (domain logic) kodun merkezine koyan bir yazılım geliştirme yaklaşımıdır. Bu yaklaşım, teknik detaylardan ziyade iş kurallarına odaklanır.

                ## Laravel ile DDD
                Laravel, DDD prensiplerini uygulamak için gerekli tüm araçları sağlar. Service layer, repository pattern ve value objects gibi konseptleri kolayca implement edebiliriz.

                ## Avantajları
                - İş mantığı framework\'ten bağımsız
                - Test edilebilirlik artar
                - Kod organizasyonu daha iyi
                - Bakım kolaylığı',
                'excerpt' => 'Laravel framework kullanarak Domain-Driven Design (DDD) mimarisini nasıl uygulayacağımızı öğrenin.',
                'category_name' => 'Yazılım Geliştirme',
                'tags' => ['Laravel', 'PHP', 'DDD'],
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'title' => 'Modern PHP Uygulamalarında Value Objects Kullanımı',
                'content' => 'Value Objects, domain-driven design\'ın temel yapı taşlarından biridir. Bu makalede PHP\'de value objects nasıl oluşturulur ve kullanılır, bunları öğreneceğiz.

                ## Value Object Nedir?
                Value Object, değeri olan ama kimliği olmayan objelerdir. Örneğin, bir email adresi, para miktarı veya tarih bir value object olabilir.

                ## PHP\'de Implementation
                PHP\'de value objects immutable olarak tasarlanmalıdır. Bu, objenin oluşturulduktan sonra değiştirilememesi anlamına gelir.

                ## Avantajları
                - Type safety
                - Validation logic
                - Immutability
                - Domain rules enforcement',
                'excerpt' => 'PHP\'de value objects nasıl oluşturulur ve kullanılır, bunları öğrenin.',
                'category_name' => 'PHP',
                'tags' => ['PHP', 'DDD', 'Value Objects'],
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'RESTful API Tasarım Prensipleri',
                'content' => 'Modern web uygulamalarında RESTful API\'ler kritik öneme sahiptir. Bu makalede RESTful API tasarımının temel prensiplerini ve best practice\'lerini inceleyeceğiz.

                ## REST Nedir?
                REST (Representational State Transfer), web servisleri için bir mimari stilidir. HTTP protokolünün özelliklerini kullanarak stateless, cacheable ve scalable API\'ler oluşturmayı amaçlar.

                ## Temel Prensipler
                - Stateless
                - Client-Server
                - Cacheable
                - Uniform Interface
                - Layered System

                ## HTTP Methods
                - GET: Veri okuma
                - POST: Yeni veri oluşturma
                - PUT: Veri güncelleme
                - DELETE: Veri silme',
                'excerpt' => 'RESTful API tasarımının temel prensiplerini ve best practice\'lerini öğrenin.',
                'category_name' => 'API',
                'tags' => ['API', 'REST', 'Web Development'],
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'Docker ile Laravel Uygulaması Deployment',
                'content' => 'Docker, modern uygulama deployment\'ında vazgeçilmez bir araç haline geldi. Bu makalede Laravel uygulamasını Docker kullanarak nasıl deploy edeceğimizi öğreneceğiz.

                ## Docker Nedir?
                Docker, uygulamaları container\'lar içinde çalıştırmaya olanak sağlayan bir platformdur. Bu sayede "benim makinemde çalışıyor" sorununu ortadan kaldırır.

                ## Laravel Dockerfile
                Laravel uygulaması için optimize edilmiş bir Dockerfile oluşturacağız. Bu Dockerfile, production ortamı için gerekli tüm optimizasyonları içerecek.

                ## Docker Compose
                Geliştirme ortamı için Docker Compose kullanarak tüm servisleri (Laravel, MySQL, Redis) tek komutla başlatabiliriz.',
                'excerpt' => 'Laravel uygulamasını Docker kullanarak nasıl deploy edeceğimizi öğrenin.',
                'category_name' => 'DevOps',
                'tags' => ['Docker', 'Laravel', 'DevOps', 'Deployment'],
                'status' => 'draft',
                'is_featured' => false,
            ],
        ];

        // İlk kullanıcıyı al (admin)
        $user = User::first();
        if (!$user) {
            $this->command->error('Önce UserSeeder çalıştırılmalı!');
            return;
        }

        foreach ($blogs as $blogData) {
            // Kategoriyi bul
            $category = Category::where('name', $blogData['category_name'])->first();
            if (!$category) {
                continue;
            }

            // Blog oluştur
            $blog = Blog::create([
                'title' => $blogData['title'],
                'content' => $blogData['content'],
                'slug' => Str::slug($blogData['title']),
                'excerpt' => $blogData['excerpt'],
                'status' => $blogData['status'],
                'author_id' => $user->id,
                'category_id' => $category->id,
                'is_featured' => $blogData['is_featured'],
                'published_at' => $blogData['status'] === 'published' ? now() : null,
                'view_count' => rand(10, 1000),
            ]);

            // Tag'leri ekle
            foreach ($blogData['tags'] as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                if ($tag) {
                    $blog->tags()->attach($tag->id);
                    // Tag kullanım sayısını artır
                    $tag->increment('usage_count');
                }
            }
        }

        $this->command->info('Blog seeder tamamlandı!');
    }
}
