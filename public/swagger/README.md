# Swagger API Dokümantasyonu

Bu klasör, Laravel StarterPack API'sinin Swagger dokümantasyonunu içerir. Dosyalar modüler bir yapıda organize edilmiştir.

## Dosya Yapısı

```
swagger/
├── main.yaml              # Ana Swagger dosyası
├── paths/                 # API endpoint'leri
│   └── auth.yaml         # Authentication endpoint'leri
├── schemas/               # Veri modelleri
│   ├── index.yaml        # Tüm schema'ları birleştiren dosya
│   ├── user.yaml         # User modeli
│   ├── validation-error.yaml  # Validation error modeli
│   └── unauthorized-error.yaml # Unauthorized error modeli
├── security/              # Güvenlik tanımları
│   └── index.yaml        # Security scheme'leri
├── tags/                  # API tag'leri
│   └── index.yaml        # Tag tanımları
└── README.md              # Bu dosya
```

## Kullanım

Ana Swagger dosyası `main.yaml`'dir. Bu dosya diğer tüm dosyaları referans olarak kullanır.

### Yeni Endpoint Ekleme

1. `paths/` klasöründe yeni bir dosya oluşturun (örn: `users.yaml`)
2. Ana `main.yaml` dosyasında paths bölümüne referans ekleyin:

```yaml
paths:
  $ref: './swagger/paths/auth.yaml'
  $ref: './swagger/paths/users.yaml'  # Yeni eklenen
```

### Yeni Schema Ekleme

1. `schemas/` klasöründe yeni schema dosyası oluşturun
2. `schemas/index.yaml` dosyasına referans ekleyin

### Yeni Tag Ekleme

1. `tags/index.yaml` dosyasına yeni tag ekleyin

## Avantajlar

- **Modüler Yapı**: Her endpoint grubu ayrı dosyada
- **Kolay Bakım**: Küçük, yönetilebilir dosyalar
- **Takım Çalışması**: Farklı geliştiriciler farklı endpoint'ler üzerinde çalışabilir
- **Yeniden Kullanım**: Schema'lar farklı endpoint'lerde kullanılabilir
- **Temiz Kod**: Ana dosya sadece referansları içerir

## Not

Swagger UI'da bu dosyaları görüntülemek için ana `swagger.yaml` dosyasını kullanın. Referanslar otomatik olarak çözülecektir.
