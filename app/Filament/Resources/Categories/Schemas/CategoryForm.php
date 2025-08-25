<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategori Bilgileri')
                    ->description('Kategori hakkında temel bilgileri girin')
                    ->icon('heroicon-o-rectangle-stack')
                    ->schema([
                        TextInput::make('name')
                            ->label('Kategori Adı')
                            ->placeholder('Örn: Teknoloji, Spor, Sanat')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(1),

                        TextInput::make('slug')
                            ->label('URL Kısayolu')
                            ->placeholder('teknoloji, spor, sanat')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(1),

                        Textarea::make('description')
                            ->label('Açıklama')
                            ->placeholder('Kategori hakkında kısa açıklama girin')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('color')
                            ->label('Renk Kodu')
                            ->placeholder('#3B82F6')
                            ->helperText('Kategori için hex renk kodu girin')
                            ->columnSpan(1),

                        TextInput::make('icon')
                            ->label('İkon')
                            ->placeholder('heroicon-o-computer-desktop')
                            ->helperText('Heroicon ikon adı girin')
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label('Aktif Kategori')
                            ->helperText('Bu kategori görünür olsun mu?')
                            ->default(true)
                            ->columnSpan(1),

                        TextInput::make('sort_order')
                            ->label('Sıralama')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Kategorilerin sıralanması için sayı girin')
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
