<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Schemas\Schema;
use App\Domain\Blog\Enums\BlogStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Blog Bilgileri')
                    ->description('Blog yazısının temel bilgilerini girin')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make('title')
                            ->label('Başlık')
                            ->placeholder('Blog başlığını girin')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('slug')
                            ->label('URL Kısayolu')
                            ->placeholder('blog-baslik-ornegi')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Textarea::make('excerpt')
                            ->label('Özet')
                            ->placeholder('Blog yazısının kısa özetini girin')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Textarea::make('content')
                            ->label('İçerik')
                            ->placeholder('Blog yazısının detaylı içeriğini girin')
                            ->required()
                            ->rows(10)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make('Kategori ve Etiketler')
                    ->description('Blog yazısının kategorisini ve etiketlerini seçin')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Kategori seçin')
                            ->columnSpan(1),

                        Select::make('author_id')
                            ->label('Yazar')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Yazar seçin')
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),

                Section::make('Görsel ve Durum')
                    ->description('Blog yazısının görselini ve yayın durumunu ayarlayın')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Öne Çıkan Görsel')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675')
                            ->directory('blog-images')
                            ->placeholder('Görsel seçin veya sürükleyin')
                            ->columnSpan(1),

                        Select::make('status')
                            ->label('Durum')
                            ->options(BlogStatus::class)
                            ->default('draft')
                            ->required()
                            ->placeholder('Durum seçin')
                            ->columnSpan(1),

                        DateTimePicker::make('published_at')
                            ->label('Yayın Tarihi')
                            ->placeholder('Yayın tarihini seçin')
                            ->displayFormat('d/m/Y H:i')
                            ->columnSpan(1),

                        TextInput::make('view_count')
                            ->label('Görüntülenme Sayısı')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->placeholder('0')
                            ->columnSpan(1),

                        Toggle::make('is_featured')
                            ->label('Öne Çıkan Blog')
                            ->helperText('Bu blog yazısı ana sayfada öne çıkarılsın mı?')
                            ->default(false)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
