<?php

namespace App\Filament\Resources\Cryocans\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RefillsRelationManager extends RelationManager
{
    protected static string $relationship = 'refills';

    protected static ?string $recordTitleAttribute = 'refill_date';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('refill_date')
                    ->required()
                    ->default(now())
                    ->label('Refill Date'),
                TextInput::make('quantity_liters')
                    ->numeric()
                    ->label('Quantity (Liters)')
                    ->suffix('L'),
                TextInput::make('cost')
                    ->numeric()
                    ->label('Cost')
                    ->prefix('₹'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('refill_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('quantity_liters')
                    ->label('Quantity')
                    ->suffix(' L')
                    ->sortable(),
                TextColumn::make('cost')
                    ->money('INR')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
