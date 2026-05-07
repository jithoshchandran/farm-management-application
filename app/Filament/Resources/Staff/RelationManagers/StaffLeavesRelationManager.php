<?php

namespace App\Filament\Resources\Staff\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class StaffLeavesRelationManager extends RelationManager
{
    protected static string $relationship = 'leaves';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->required()
                    ->default(now()),
                Select::make('type')
                    ->options([
                        'priorly Informed' => 'priorly Informed',
                        'informed after' => 'informed after',
                        'not informed' => 'not informed',
                        'Off Leave' => 'Off Leave',
                    ])
                    ->required(),
                Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reason')
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'priorly Informed' => 'success',
                        'informed after' => 'warning',
                        'not informed' => 'danger',
                        'Off Leave' => 'info',
                    }),
                TextColumn::make('reason')
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                \Filament\Actions\CreateAction::make(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // REMOVED: bulkActions is where checkboxes usually live. 
                // Leaving empty removes checkboxes/bulk actions.
            ]);
    }
}
