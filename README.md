# 🚀 Laravel Blog Starter Pack (Eğitim amaçlı)

Modern Laravel blog uygulaması için kapsamlı bir başlangıç paketi. Domain-Driven Design (DDD) mimarisi, Filament admin paneli ve RESTful API ile geliştirilmiştir.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)
![Filament](https://img.shields.io/badge/Filament-4.x-orange.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## ✨ Özellikler

- 🏗️ **Domain-Driven Design (DDD)** mimarisi
- 🎨 **Filament 3** admin paneli
- 🔐 **Laravel Sanctum** authentication
- 📝 **Blog yönetim sistemi**
- 🏷️ **Kategori ve etiket sistemi**
- 👥 **Kullanıcı yönetimi**
- 🚀 **RESTful API**
- 📊 **Swagger/OpenAPI dokümantasyonu**
- 🎯 **Modern UI/UX tasarımı**
- 📱 **Responsive tasarım**

## 🛠️ Teknolojiler

- **Backend:** Laravel 12.x, PHP 8.1+
- **Admin Panel:** Filament 4.x
- **Database:** MySQL/PostgreSQL
- **Authentication:** Laravel Sanctum
- **API Documentation:** Swagger/OpenAPI
- **Frontend:** Tailwind CSS, Alpine.js
- **Testing:** PHPUnit

## 📋 Gereksinimler

- PHP 8.1 veya üzeri
- Composer
- MySQL 8.0+ veya PostgreSQL 12+
- Node.js 16+ ve NPM
- Git

## 🚀 Kurulum

### 1. Projeyi Klonlayın

```bash
git clone https://github.com/username/starter-pack.git
cd starter-pack
```

### 2. Bağımlılıkları Yükleyin

```bash
composer install
npm install
```

### 3. Environment Dosyasını Hazırlayın

```bash
cp .env.example .env
```

`.env` dosyasını düzenleyin:

```env
APP_NAME="Laravel Blog"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_blog
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Uygulama Anahtarını Oluşturun

```bash
php artisan key:generate
```

### 5. Veritabanını Hazırlayın

```bash
php artisan migrate
php artisan db:seed
```

### 6. Storage Linkini Oluşturun

```bash
php artisan storage:link
```

### 7. Frontend Varlıklarını Derleyin

```bash
npm run build
```

### 8. Uygulamayı Başlatın

```bash
php artisan serve
```

Tarayıcınızda `http://localhost:8000` adresine gidin.

## 🔐 Admin Paneli

Filament admin paneline erişim:

- **URL:** `http://localhost:8000/admin`
- **Varsayılan Kullanıcı:** `admin@example.com`
- **Şifre:** `password`

### Admin Panel Özellikleri

- 📝 **Blog Yönetimi:** Blog yazıları oluşturma, düzenleme, silme
- 🏷️ **Kategori Yönetimi:** Blog kategorileri
- 🏷️ **Etiket Yönetimi:** Blog etiketleri
- 👥 **Kullanıcı Yönetimi:** Kullanıcı hesapları
- 📊 **Dashboard:** İstatistikler ve genel bakış

## 🌐 API Kullanımı

### Authentication

```bash
# Giriş
POST /api/auth/login
{
    "email": "user@example.com",
    "password": "password"
}

# Kayıt
POST /api/auth/register
{
    "name": "Kullanıcı Adı",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

### Blog API Endpoints

```bash
# Blog listesi
GET /api/blogs

# Blog detayı
GET /api/blogs/{id}

# Blog arama
GET /api/blogs/search?q=arama_terimi
```

### API Dokümantasyonu

Swagger dokümantasyonuna erişim:
- **URL:** `http://localhost:8000/api-docs.html`

## 🏗️ Proje Yapısı

```
starter-pack/
├── app/
│   ├── Application/          # Application Layer
│   │   └── DTOs/            # Data Transfer Objects
│   ├── Domain/              # Domain Layer
│   │   ├── Auth/            # Authentication domain
│   │   ├── Blog/            # Blog domain
│   │   └── Entities/        # Domain entities
│   ├── Infrastructure/      # Infrastructure Layer
│   │   ├── Models/          # Eloquent models
│   │   └── Repositories/    # Repository implementations
│   └── Filament/            # Admin panel resources
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories
├── routes/
│   ├── api.php              # API routes
│   └── web.php              # Web routes
└── public/
    └── swagger/             # API documentation
```

## 🧪 Testler

```bash
# Tüm testleri çalıştır
php artisan test

# Belirli test dosyasını çalıştır
php artisan test tests/Feature/BlogTest.php

# Test coverage raporu
php artisan test --coverage
```

## 📦 Docker ile Kurulum

```bash
# Docker container'larını başlat
docker-compose up -d

# Container'a bağlan
docker-compose exec app bash

# Migration'ları çalıştır
php artisan migrate
```

## 🔧 Geliştirme

### Yeni Blog Kategorisi Ekleme

```bash
php artisan make:filament-resource Category
```

### Yeni API Endpoint Ekleme

```bash
php artisan make:controller Api/BlogController
```

### Yeni Migration Oluşturma

```bash
php artisan make:migration create_new_table
```

## 📚 Öğrenme Kaynakları

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Domain-Driven Design](https://martinfowler.com/bliki/DomainDrivenDesign.html)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)

## 🤝 Katkıda Bulunma

1. Bu repository'yi fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add amazing feature'`)
4. Branch'inizi push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## 📝 Changelog

### v1.0.0 (2025-01-01)
- İlk sürüm
- Blog yönetim sistemi
- Filament admin paneli
- RESTful API
- DDD mimarisi

## 📄 Lisans

Bu proje [MIT License](LICENSE) altında lisanslanmıştır.

## 👨‍💻 Geliştirici

**Beyazıt Kolemen**
- GitHub: [@beyazitkolemen](https://github.com/beyazitkolemen)
- LinkedIn: [Beyazıt Kolemen](https://linkedin.com/in/beyazitkolemen)

## 🙏 Teşekkürler

- [Laravel Team](https://laravel.com) - Harika framework için
- [Filament Team](https://filamentphp.com) - Admin paneli için
- [Tailwind CSS](https://tailwindcss.com) - CSS framework için

---

⭐ Bu projeyi beğendiyseniz yıldız vermeyi unutmayın!
