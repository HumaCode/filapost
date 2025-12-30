<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        Section::make()
                            ->columnSpan(2)
                            ->schema([
                                TextEntry::make('title'),
                                TextEntry::make('slug'),
                                TextEntry::make('content')
                                    ->html()
                                    ->columnSpanFull(),
                                TextEntry::make('category.name')
                                    ->badge()
                                    ->label('Category'),
                                TextEntry::make('tags.name')
                                    ->badge()
                                    ->color('info')
                                    ->label('Tag'),
                            ]),
                        Section::make()
                            ->schema([
                                ImageEntry::make('image'),
                                TextEntry::make('user.name')
                                    ->label('Author'),
                                TextEntry::make('created_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('updated_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),
                    ])
            ]);
    }
}
