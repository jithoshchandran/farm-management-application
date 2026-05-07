<?php

namespace App\Filament\Resources\Feeds\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FeedForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('category')
                    ->options([
                        'Green Fodder' => 'Green Fodder',
                        'Dry Fodder' => 'Dry Fodder',
                        'Concentrates' => 'Concentrates',
                        'Food Supplements & Vitamins' => 'Food Supplements & Vitamins',
                        'Mineral Licks' => 'Mineral Licks',
                    ])
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('quantity_in_stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('cost_per_kg')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
