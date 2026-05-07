<?php

namespace App\Filament\Resources\Cryocans\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InspectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'inspections';

    protected static ?string $recordTitleAttribute = 'inspection_date';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('inspection_date')
                    ->required()
                    ->default(now())
                    ->label('Inspection Date'),
                TextInput::make('liquid_level_cm')
                    ->numeric()
                    ->label('Liquid Nitrogen Level (cm)')
                    ->suffix('cm'),
                Select::make('vacuum_status')
                    ->options([
                        'Excellent' => 'Excellent',
                        'Good' => 'Good',
                        'Poor' => 'Poor',
                        'Warning' => 'Warning',
                    ])
                    ->label('Vacuum Status'),
                Select::make('physical_condition')
                    ->options([
                        'No Damage' => 'No Damage',
                        'Scratches' => 'Scratches',
                        'Dents' => 'Dents',
                        'Heavy Frost' => 'Heavy Frost',
                    ])
                    ->label('Physical Condition'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inspection_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('liquid_level_cm')
                    ->label('Level')
                    ->suffix(' cm')
                    ->sortable(),
                TextColumn::make('vacuum_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Excellent', 'Good' => 'success',
                        'Poor' => 'warning',
                        'Warning' => 'danger',
                    }),
                TextColumn::make('physical_condition'),
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
