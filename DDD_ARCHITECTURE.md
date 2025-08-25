# Domain-Driven Design (DDD) Architecture

Bu proje, Laravel framework kullanılarak Domain-Driven Design (DDD) mimarisi prensiplerine göre yapılandırılmıştır.

## Mimari Katmanları

### 1. Domain Layer (app/Domain/)
Domain katmanı, iş mantığının kalbidir ve hiçbir framework bağımlılığı içermez.

#### Entities
- **User**: Kullanıcı domain entity'si
- Value Objects ile güçlendirilmiş
- Eloquent'ten türetilmemiş, saf domain objesi

#### Value Objects
- **Name**: İsim değer objesi
- **Email**: Email değer objesi  
- **Password**: Şifre değer objesi

#### Services
- **AuthService**: Kimlik doğrulama iş mantığı
- Domain kurallarını uygular
- Infrastructure detaylarından bağımsız

#### Repositories (Interfaces)
- **UserRepositoryInterface**: Kullanıcı veri erişim sözleşmesi

#### Exceptions
- **InvalidCredentialsException**: Geçersiz kimlik bilgileri
- **UserNotFoundException**: Kullanıcı bulunamadı

### 2. Application Layer (app/Application/)
Uygulama servisleri ve DTO'lar burada bulunur.

#### DTOs
- **LoginResponseDTO**: Giriş yanıt veri transfer objesi
- **RegisterResponseDTO**: Kayıt yanıt veri transfer objesi
- **UserResponseDTO**: Kullanıcı yanıt veri transfer objesi

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
- **AuthController**: Kimlik doğrulama API endpoint'leri
- Application katmanındaki DTO'ları kullanır

#### Requests
- **LoginRequest**: Giriş isteği validasyonu
- **RegisterRequest**: Kayıt isteği validasyonu

## DDD Prensipleri

### 1. Separation of Concerns
- Her katman kendi sorumluluğuna sahip
- Domain katmanı framework'ten bağımsız
- Infrastructure detayları Domain'e sızamaz

### 2. Dependency Inversion
- Domain katmanı Infrastructure'a bağımlı değil
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

## Kullanım Örnekleri

### Token Oluşturma
```php
// Infrastructure katmanında
$userModel = UserModel::find($userId);
$tokenResult = $userModel->createToken('auth_token');
$plainToken = $tokenResult->plainTextToken;

// Domain katmanında
$user = new User(['name' => 'John', 'email' => 'john@example.com']);
```

### Repository Kullanımı
```php
// Interface üzerinden
$user = $this->userRepository->findByEmail($email);

// Infrastructure implementasyonu
$userModel = UserModel::where('email', $email->getValue())->first();
return $userModel->toDomainEntity();
```

## Avantajlar

1. **Test Edilebilirlik**: Domain logic framework'ten bağımsız test edilebilir
2. **Maintainability**: Kod organizasyonu ve sorumluluk ayrımı
3. **Scalability**: Yeni özellikler kolayca eklenebilir
4. **Framework Independence**: Domain logic framework değişikliklerinden etkilenmez
5. **Team Collaboration**: Farklı ekipler farklı katmanlarda çalışabilir

## Best Practices

1. **Domain katmanında framework kodu bulundurmayın**
2. **Value Objects kullanarak primitive obsession'ı önleyin**
3. **Repository pattern ile veri erişimi soyutlayın**
4. **Exception'ları domain seviyesinde tanımlayın**
5. **DTO'lar ile veri transferini standartlaştırın**
