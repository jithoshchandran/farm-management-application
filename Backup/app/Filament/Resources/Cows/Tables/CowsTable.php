<?php

namespace App\Filament\Resources\Cows\Tables;

use App\Models\Cow;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class CowsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Cow Name')
                    ->description(fn (Cow $record): string => $record->tag_number ?? '-')
                    ->searchable(['name', 'tag_number'])
                    ->sortable(),
                TextColumn::make('gender')
                    ->searchable(),
                TextColumn::make('age')
                    ->label('Age'),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('breed.name')
                    ->label('Breed')
                    ->searchable(),
                TextColumn::make('milk_production_avg')
                    ->label('Avg Milk (L/day)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_heat_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('animal_classification')
                    ->label('Classification')
                    ->options([
                        'Bull' => 'Bull',
                        'Cow' => 'Cow',
                        'Heifer' => 'Heifer',
                        'Calf' => 'Calf',
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        if (! $data['value']) {
                            return $query;
                        }

                        $oneYearAgo = now()->subYear()->toDateString();

                        return match ($data['value']) {
                            'Bull' => $query->where('gender', 'Male')->where('dob', '<=', $oneYearAgo),
                            'Cow' => $query->where('gender', 'Female')->whereNotNull('last_calving_date'),
                            'Heifer' => $query->where('gender', 'Female')->where('dob', '<=', $oneYearAgo)->whereNull('last_calving_date'),
                            'Calf' => $query->where('dob', '>', $oneYearAgo),
                            default => $query,
                        };
                    })
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
