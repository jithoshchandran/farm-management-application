<?php

namespace App\Filament\Resources\Inseminations\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class InseminationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('expected_calving_date')
                    ->label('Expected Calving')
                    ->date()
                    ->sortable(),
                TextColumn::make('cow.tag_number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Artificial Insemination' => 'info',
                        'Natural' => 'success',
                    }),
                TextColumn::make('cost')
                    ->money('INR'),
                IconColumn::make('is_successful')
                    ->label('Pregnant?')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->placeholder('Pending'), // Null state
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
