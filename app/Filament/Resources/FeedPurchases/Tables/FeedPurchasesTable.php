<?php

namespace App\Filament\Resources\FeedPurchases\Tables;

use App\Models\Feed;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FeedPurchasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('purchase_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('feed.name')
                    ->label('Feed')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unit')
                    ->formatStateUsing(fn (?string $state): string => Feed::UNIT_OPTIONS[$state] ?? ($state ?: 'Kg'))
                    ->badge(),
                TextColumn::make('unit_price')
                    ->label('Unit Price')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options(Feed::CATEGORY_OPTIONS),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
