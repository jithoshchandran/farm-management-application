<?php

namespace App\Filament\Resources\Feeds\Tables;

use App\Models\Feed;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeedsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Feed Name')
                    ->searchable(),
                TextColumn::make('unit')
                    ->formatStateUsing(fn (?string $state): string => Feed::UNIT_OPTIONS[$state] ?? ($state ?: 'Kg'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('quantity_in_stock')
                    ->label('Current Stock')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cost_per_kg')
                    ->label('Last Unit Price')
                    ->money('INR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('amount')
                    ->label('Stock Value')
                    ->state(fn ($record) => ($record->quantity_in_stock ?? 0) * ($record->cost_per_kg ?? 0))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->options(Feed::CATEGORY_OPTIONS),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
