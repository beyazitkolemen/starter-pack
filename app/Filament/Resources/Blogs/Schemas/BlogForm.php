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
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        Textarea::make('content')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->required(),

                        Select::make('status')
                            ->options(BlogStatus::class)
                            ->default('draft')
                            ->required(),
                        Textarea::make('excerpt')
                            ->columnSpanFull(),
                        FileUpload::make('featured_image')
                            ->image(),
                        Select::make('author_id')
                            ->relationship('author', 'name')
                            ->required(),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),
                        DateTimePicker::make('published_at'),
                        TextInput::make('view_count')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_featured')
                            ->required(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
