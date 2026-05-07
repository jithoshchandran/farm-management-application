<?php

namespace App\Filament\Resources\Feeds\Schemas;

use App\Models\Feed;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FeedForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category')
                    ->options(Feed::CATEGORY_OPTIONS)
                    ->required(),
                TextInput::make('name')
                    ->label('Feed Name')
                    ->required(),
                Select::make('unit')
                    ->options(Feed::UNIT_OPTIONS)
                    ->default('kg')
                    ->required(),
            ]);
    }
}
