# Domain-Driven Design (DDD) Architecture

Bu proje, Laravel framework kullanılarak Domain-Driven Design (DDD) mimarisi prensiplerine göre yapılandırılmıştır.

## Mimari Katmanları

### 1. Domain Layer (app/Domain/)
Domain katmanı, iş mantığının kalbidir ve hiçbir framework bağımlılığı içermez.

#### Auth Domain
- **User**: Kullanıcı domain entity'si
- Value Objects ile güçlendirilmiş
- Eloquent'ten türetilmemiş, saf domain objesi

#### Blog Domain
- **Blog**: Blog post domain entity'si
- **Category**: Blog kategorisi domain entity'si
- **Tag**: Blog etiketi domain entity'si

#### Value Objects
- **Name**: İsim değer objesi
- **Email**: Email değer objesi  
- **Password**: Şifre değer objesi
- **Title**: Blog başlığı değer objesi
- **Content**: Blog içeriği değer objesi
- **Slug**: URL-friendly slug değer objesi
- **Status**: Blog durumu değer objesi (draft, published, archived)
- **Description**: Açıklama değer objesi

#### Services
- **AuthService**: Kimlik doğrulama iş mantığı
- **BlogService**: Blog yönetimi iş mantığı
- Domain kurallarını uygular
- Infrastructure detaylarından bağımsız

#### Repositories (Interfaces)
- **UserRepositoryInterface**: Kullanıcı veri erişim sözleşmesi
- **BlogRepositoryInterface**: Blog veri erişim sözleşmesi
- **CategoryRepositoryInterface**: Kategori veri erişim sözleşmesi
- **TagRepositoryInterface**: Etiket veri erişim sözleşmesi

#### Exceptions
- **InvalidCredentialsException**: Geçersiz kimlik bilgileri
- **UserNotFoundException**: Kullanıcı bulunamadı
- **BlogNotFoundException**: Blog bulunamadı
- **CategoryNotFoundException**: Kategori bulunamadı
- **TagNotFoundException**: Etiket bulunamadı
- **InvalidBlogStatusException**: Geçersiz blog durumu geçişi

### 2. Application Layer (app/Application/)
Uygulama servisleri ve DTO'lar burada bulunur.

#### DTOs
- **LoginResponseDTO**: Giriş yanıt veri transfer objesi
- **RegisterResponseDTO**: Kayıt yanıt veri transfer objesi
- **UserResponseDTO**: Kullanıcı yanıt veri transfer objesi
- **BlogResponseDTO**: Blog yanıt veri transfer objesi

### 3. Infrastructure Layer (app/Infrastructure/)
Framework ve dış servislerle entegrasyon burada bulunur.

#### Models
- **BaseModel**: Tüm Infrastructure modeller için base class
- **User**: Eloquent User modeli (Infrastructure katmanında)
- Laravel Sanctum, Eloquent özellikleri burada

#### Repositories
- **UserRepository**: UserRepositoryInterface implementasyonu
- Eloquent modelleri kullanarak veri erişimi
- Domain entity'leri ile Infrastructure arasında köprü

### 4. Http Layer (app/Http/)
Web arayüzü ve API endpoint'leri.

#### Controllers
- **Auth Controllers**: Kimlik doğrulama API endpoint'leri
  - `RegisterController`: Kullanıcı kaydı
  - `LoginController`: Kullanıcı girişi
  - `LogoutController`: Kullanıcı çıkışı
  - `UserProfileController`: Kullanıcı profili
- **Blog Controllers**: Blog yönetimi API endpoint'leri
  - `CreateBlogController`: Blog oluşturma
- **TestController**: API test endpoint'i

#### Requests
- **Auth Requests**: Kimlik doğrulama validasyonu
  - `LoginRequest`: Giriş isteği validasyonu
  - `RegisterRequest`: Kayıt isteği validasyonu
- **Blog Requests**: Blog validasyonu
  - `CreateBlogRequest`: Blog oluşturma validasyonu

## DDD Prensipleri

### 1. Separation of Concerns
- Her katman kendi sorumluluğuna sahip
- Domain katmanı framework'ten bağımsız
- Infrastructure detayları Domain'e sızamaz

### 2. Dependency Inversion
- Domain katmanı Infrastructure'a bağımsız değil
- Repository pattern ile soyutlama
- Interface'ler üzerinden bağımlılık

### 3. Value Objects
- Primitive obsession'ı önler
- Domain kurallarını kapsüller
- Immutable ve type-safe

### 4. Repository Pattern
- Veri erişim soyutlaması
- Domain entity'leri Infrastructure'dan izole eder
- Test edilebilirliği artırır

### 5. Invokable Controllers
- Her endpoint için ayrı controller
- Tek sorumluluk prensibi
- Kolay test edilebilirlik

## Blog Sistemi Özellikleri

### Blog Entity
- **Status Management**: Draft → Published → Archived durum geçişleri
- **Content Management**: Title, Content, Excerpt, Featured Image
- **Relationships**: Author (User), Category, Tags
- **Analytics**: View count, Featured status
- **Validation**: Required fields, content length, status transitions

### Category Entity
- **Hierarchical**: Parent-child relationships (gelecekte eklenebilir)
- **Customization**: Color, Icon, Sort order
- **Status**: Active/Inactive toggle
- **SEO**: Slug generation

### Tag Entity
- **Usage Tracking**: Tag kullanım sayısı
- **Flexibility**: Optional description, color
- **Status**: Active/Inactive toggle
- **SEO**: Slug generation

## Kullanım Örnekleri

### Blog Oluşturma
```php
// Domain Service'de
$blog = $this->blogService->createBlog([
    'title' => 'Laravel DDD Tutorial',
    'content' => 'Bu makalede Laravel ile DDD...',
    'category_id' => 1,
    'tags' => [1, 2, 3],
    'status' => 'draft'
], $user);

// Controller'da
$blog = $this->blogService->createBlog($validated, $request->user());
```

### Blog Durum Yönetimi
```php
// Publish blog
$blog = $this->blogService->publishBlog($blogId);

// Archive blog
$blog = $this->blogService->archiveBlog($blogId);

// Status transition validation
if (!$blog->getStatus()->canTransitionTo('published')) {
    throw new InvalidBlogStatusException('Cannot publish from current status');
}
```

### Repository Pattern
```php
// Interface üzerinden
$blogs = $this->blogRepository->findPublished($page, $perPage);

// Infrastructure implementasyonu
$blogModels = BlogModel::where('status', 'published')
    ->orderBy('created_at', 'desc')
    ->paginate($perPage);

return array_map(fn($model) => $model->toDomainEntity(), $blogModels);
```

## Avantajlar

1. **Test Edilebilirlik**: Domain logic framework'ten bağımsız test edilebilir
2. **Maintainability**: Kod organizasyonu ve sorumluluk ayrımı
3. **Scalability**: Yeni özellikler kolayca eklenebilir
4. **Framework Independence**: Domain logic framework değişikliklerinden etkilenmez
5. **Team Collaboration**: Farklı ekipler farklı katmanlarda çalışabilir
6. **Business Logic**: İş kuralları domain katmanında merkezi olarak yönetilir

## Best Practices

1. **Domain katmanında framework kodu bulundurmayın**
2. **Value Objects kullanarak primitive obsession'ı önleyin**
3. **Repository pattern ile veri erişimi soyutlayın**
4. **Exception'ları domain seviyesinde tanımlayın**
5. **DTO'lar ile veri transferini standartlaştırın**
6. **Invokable controller'lar ile tek sorumluluk prensibini uygulayın**
7. **Status transition'ları domain kurallarına göre yönetin**
8. **Validation'ları request seviyesinde yapın**

## Sonraki Adımlar

1. **Database Migrations**: Blog, categories, tags tabloları
2. **Infrastructure Implementations**: Repository concrete classes
3. **Additional Controllers**: Update, Delete, List blog endpoints
4. **Search Functionality**: Elasticsearch entegrasyonu
5. **File Upload**: Featured image management
6. **Caching**: Redis ile performans optimizasyonu
7. **Events**: Domain event'leri ve listener'lar
8. **API Documentation**: Swagger/OpenAPI entegrasyonu
