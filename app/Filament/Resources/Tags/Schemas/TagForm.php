<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Etiket Bilgileri')
                    ->description('Etiket hakkında temel bilgileri girin')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        TextInput::make('name')
                            ->label('Etiket Adı')
                            ->placeholder('Örn: PHP, Laravel, Vue.js')
                            ->required()
                            ->maxLength(50)
                            ->columnSpan(1),

                        TextInput::make('slug')
                            ->label('URL Kısayolu')
                            ->placeholder('php, laravel, vuejs')
                            ->required()
                            ->maxLength(50)
                            ->columnSpan(1),

                        Textarea::make('description')
                            ->label('Açıklama')
                            ->placeholder('Etiket hakkında kısa açıklama girin')
                            ->rows(3)
                            ->maxLength(300)
                            ->columnSpanFull(),

                        TextInput::make('color')
                            ->label('Renk Kodu')
                            ->placeholder('#10B981')
                            ->helperText('Etiket için hex renk kodu girin')
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label('Aktif Etiket')
                            ->helperText('Bu etiket görünür olsun mu?')
                            ->default(true)
                            ->columnSpan(1),

                        TextInput::make('usage_count')
                            ->label('Kullanım Sayısı')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Etiketin kaç kez kullanıldığını gösterir')
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
