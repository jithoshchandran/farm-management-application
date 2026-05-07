<?php

namespace App\Filament\Resources\Cryocans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CryocansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('serial_number')
                    ->searchable(),
                TextColumn::make('tank_size_liters')
                    ->label('Size (L)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_refill_date')
                    ->label('Refilled')
                    ->date()
                    ->sortable(),
                TextColumn::make('refill_quantity_liters')
                    ->label('Qty (L)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('refill_price')
                    ->label('Price')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('next_scheduled_refill')
                    ->label('Next Refill')
                    ->date()
                    ->sortable(),
                TextColumn::make('current_level_cm')
                    ->label('Level (cm)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('supplier_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('technician_contact')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Maintenance' => 'warning',
                        'Empty' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
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
