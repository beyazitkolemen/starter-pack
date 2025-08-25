# Domain-Driven Design (DDD) Mimarisi

Bu proje, Laravel framework'ü kullanarak Domain-Driven Design (DDD) prensiplerine uygun şekilde yapılandırılmıştır.

## DDD Katmanları

### 1. Domain Layer (app/Domain/)
İş mantığının ve domain kurallarının bulunduğu ana katman.

#### Entities
- **User**: Kullanıcı domain entity'si
- **Value Objects**: Name, Email, Password gibi değer nesneleri
- **Exceptions**: Domain-specific exception'lar

#### Services
- **AuthService**: Kimlik doğrulama iş mantığı

#### Repositories (Interfaces)
- **UserRepositoryInterface**: User repository contract'ı

### 2. Application Layer (app/Application/)
Use case'leri ve application logic'i içerir.

#### DTOs
- **LoginResponseDTO**: Giriş yanıt veri transfer objesi
- **RegisterResponseDTO**: Kayıt yanıt veri transfer objesi
- **UserResponseDTO**: Kullanıcı yanıt veri transfer objesi

### 3. Infrastructure Layer (app/Infrastructure/)
External concerns ve technical implementation'ları içerir.

#### Repositories
- **UserRepository**: UserRepositoryInterface'in concrete implementation'ı

### 4. Presentation Layer (app/Http/)
HTTP isteklerini karşılayan ve response'ları dönen katman.

#### Controllers
- **AuthController**: Sadece HTTP isteklerini alır ve domain service'lere yönlendirir

## DDD Prensipleri

### 1. Separation of Concerns
- Her katman kendi sorumluluğuna sahip
- Controller'lar sadece HTTP ile ilgilenir
- Domain logic domain layer'da
- Infrastructure concerns ayrı

### 2. Dependency Inversion
- Domain layer hiçbir external dependency'e sahip değil
- Repository interface'leri domain'de tanımlanır
- Concrete implementation'lar infrastructure'da

### 3. Value Objects
- Name, Email, Password gibi değerler value object olarak tanımlanır
- Immutable ve validation logic'i içerir
- Domain kurallarını enforce eder

### 4. Domain Entities
- User entity'si domain logic'i içerir
- Business rules'ları enforce eder
- Value object'leri kullanır

## Avantajlar

1. **Maintainability**: Kod daha organize ve bakımı kolay
2. **Testability**: Her katman bağımsız olarak test edilebilir
3. **Scalability**: Yeni özellikler eklemek daha kolay
4. **Business Logic**: İş mantığı domain layer'da merkezi olarak yönetilir
5. **Flexibility**: Infrastructure değişiklikleri domain'i etkilemez

## Kullanım

### Controller'da
```php
public function register(RegisterRequest $request): JsonResponse
{
    try {
        $result = $this->authService->register(
            $request->name,
            $request->email,
            $request->password
        );
        
        $responseDTO = new RegisterResponseDTO($result['user'], $result['token']);
        return response()->json($responseDTO->toArray(), 201);
    } catch (\Exception $e) {
        // Error handling
    }
}
```

### Domain Service'de
```php
public function register(string $name, string $email, string $password): array
{
    $nameValueObject = new Name($name);
    $emailValueObject = new Email($email);
    $passwordValueObject = new Password($password);
    
    // Business logic
    $user = new User($nameValueObject, $emailValueObject, $passwordValueObject);
    $savedUser = $this->userRepository->save($user);
    
    return ['user' => $savedUser, 'token' => $token];
}
```

## Sonraki Adımlar

1. **Event Sourcing**: Domain event'leri eklenebilir
2. **CQRS**: Command ve Query separation
3. **Aggregate Pattern**: Complex domain logic için
4. **Specification Pattern**: Complex query logic için
5. **Unit of Work**: Transaction management
