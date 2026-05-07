<?php

namespace App\Filament\Resources\SemenStocks\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class SemenStocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('bull_image')
                    ->label('Bull')
                    ->disk('public')
                    ->circular(),
                \Filament\Tables\Columns\TextColumn::make('full_display_name')
                    ->label('Bull / Stock ID')
                    ->searchable(['bull_name', 'id'])
                    ->sortable(['bull_name']),
                \Filament\Tables\Columns\TextColumn::make('bull_tag')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('breed')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('initial_quantity')->label('Purchased'),
                \Filament\Tables\Columns\TextColumn::make('remaining_quantity')
                    ->label('Stocks Left')
                    ->badge()
                    ->color(fn ($state) => $state > 5 ? 'success' : 'warning'),
                \Filament\Tables\Columns\TextColumn::make('cryocan.serial_number')->label('Storage'),
                \Filament\Tables\Columns\TextColumn::make('purchase_date')->date()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
