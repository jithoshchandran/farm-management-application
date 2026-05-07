<?php

namespace App\Filament\Resources\Veterinarians\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VeterinariansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('contact_number')
                    ->searchable(),
                TextColumn::make('whatsapp_number')
                    ->searchable()
                    ->label('WhatsApp'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ]);
    }
}
