<?php

namespace App\Filament\Resources\Staff\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class StaffRemarksRelationManager extends RelationManager
{
    protected static string $relationship = 'remarks';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->required()
                    ->default(now()),
                Textarea::make('remark')
                    ->required()
                    ->maxLength(65535),
                FileUpload::make('file')
                    ->directory('staff-remarks')
                    ->disk('public')
                    ->openable()
                    ->downloadable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('remark')
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('remark')
                    ->limit(50),
                TextColumn::make('file')
                    ->label('Attachment')
                    ->formatStateUsing(fn ($state) => $state ? 'View File' : '-')
                    ->url(fn ($record) => $record->file ? \Illuminate\Support\Facades\Storage::url($record->file) : null)
                    ->openUrlInNewTab(),
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
                //
            ]);
    }
}
