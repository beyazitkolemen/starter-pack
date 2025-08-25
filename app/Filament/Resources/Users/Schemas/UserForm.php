<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kullanıcı Bilgileri')
                    ->description('Kullanıcı hesabı için gerekli bilgileri girin')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('name')
                            ->label('Ad Soyad')
                            ->placeholder('Örn: Ahmet Yılmaz')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('email')
                            ->label('E-posta Adresi')
                            ->placeholder('ornek@email.com')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpan(1),

                        DateTimePicker::make('email_verified_at')
                            ->label('E-posta Doğrulama Tarihi')
                            ->placeholder('E-posta doğrulandığında otomatik doldurulur')
                            ->displayFormat('d/m/Y H:i')
                            ->columnSpan(1),

                        TextInput::make('password')
                            ->label('Şifre')
                            ->placeholder('Güçlü bir şifre girin')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->helperText('En az 8 karakter olmalıdır')
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
