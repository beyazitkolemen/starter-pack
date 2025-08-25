# Blog API Swagger Documentation

Bu klasör, Blog API'si için Swagger/OpenAPI 3.0 dokümantasyonunu içerir.

## Dosya Yapısı

```
swagger/
├── main.yaml              # Ana OpenAPI dosyası
├── paths/                 # API endpoint tanımları
│   ├── auth.yaml         # Kimlik doğrulama endpoint'leri
│   ├── blog.yaml         # Blog CRUD endpoint'leri
│   └── blog-detail.yaml  # Blog detay işlemleri
├── schemas/               # Veri modelleri
│   ├── blog-create.yaml  # Blog oluşturma şeması
│   ├── blog-update.yaml  # Blog güncelleme şeması
│   ├── blog-response.yaml # Blog response şeması
│   ├── blog-list-response.yaml # Blog listesi response şeması
│   ├── validation-error.yaml # Validation hatası şeması
│   ├── unauthorized-error.yaml # Yetkisiz erişim hatası şeması
│   ├── not-found-error.yaml # Bulunamadı hatası şeması
│   └── server-error.yaml # Server hatası şeması
└── README.md              # Bu dosya
```

## API Endpoints

### Blog Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/blogs` | Yeni blog oluştur | ✅ |
| GET | `/blogs` | Blog listesini getir | ❌ |
| GET | `/blogs/{slug}` | Tek blog getir | ❌ |
| PUT | `/blogs/{blogId}` | Blog güncelle | ✅ |
| DELETE | `/blogs/{blogId}` | Blog sil | ✅ |

### Auth Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/register` | Kullanıcı kaydı | ❌ |
| POST | `/login` | Kullanıcı girişi | ❌ |
| POST | `/logout` | Kullanıcı çıkışı | ✅ |
| GET | `/user` | Kullanıcı profili | ✅ |

## Kullanım

1. **Swagger UI**: `http://localhost:8000/api-docs.html` adresinden erişebilirsiniz
2. **OpenAPI Spec**: `http://localhost:8000/swagger/main.yaml` adresinden OpenAPI spesifikasyonunu indirebilirsiniz

## Özellikler

- **Bearer Token Authentication**: Laravel Sanctum ile JWT token desteği
- **Comprehensive Schemas**: Tüm request/response modelleri tanımlanmış
- **Error Handling**: Detaylı hata kodları ve mesajları
- **Interactive Testing**: Swagger UI üzerinden API test edebilme
- **Turkish Language**: Türkçe açıklamalar ve örnekler

## Geliştirme

Yeni endpoint eklemek için:

1. `paths/` klasöründe yeni path dosyası oluşturun
2. `schemas/` klasöründe gerekli şemaları tanımlayın
3. `main.yaml` dosyasında referansları ekleyin
4. Swagger UI'da test edin

## Notlar

- Tüm blog endpoint'leri DDD mimarisi ile geliştirilmiştir
- Value Objects, Entities, Services ve Repository pattern kullanılmıştır
- PHP 8.1+ enum'ları ile type safety sağlanmıştır
