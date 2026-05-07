<?php

namespace App\Filament\Resources\Feeds\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeedsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('category')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('quantity_in_stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cost_per_kg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Green Fodder' => 'Green Fodder',
                        'Dry Fodder' => 'Dry Fodder',
                        'Concentrates' => 'Concentrates',
                        'Food Supplements & Vitamins' => 'Food Supplements & Vitamins',
                        'Mineral Licks' => 'Mineral Licks',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
