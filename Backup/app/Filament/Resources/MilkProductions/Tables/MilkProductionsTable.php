<?php

namespace App\Filament\Resources\MilkProductions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use App\Filament\Resources\MilkProductions\MilkProductionResource;

class MilkProductionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cow_name_display')
                    ->label('Cow Name')
                    ->getStateUsing(fn ($record) => $record->cow_name ?? $record->cow?->name ?? 'Unknown')
                    ->searchable(['cows.name', 'cows.tag_number'])
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->visible(fn ($livewire) => !empty($livewire->tableFilters['cow']['value']) || request()->filled('tableFilters.cow')),
                TextColumn::make('morning_yield')
                    ->numeric()
                    ->sortable()
                    ->visible(fn ($livewire) => !empty($livewire->tableFilters['cow']['value']) || request()->filled('tableFilters.cow')),
                TextColumn::make('evening_yield')
                    ->numeric()
                    ->sortable()
                    ->visible(fn ($livewire) => !empty($livewire->tableFilters['cow']['value']) || request()->filled('tableFilters.cow')),
                TextColumn::make('total_yield')
                    ->label(fn ($livewire) => (!empty($livewire->tableFilters['cow']['value']) || request()->filled('tableFilters.cow')) ? 'Total Yield (L)' : 'Aggregated Yield (L)')
                    ->numeric()
                    ->sortable()
                    ->summarize(\Filament\Tables\Columns\Summarizers\Sum::make()
                        ->label('Grand Total')),
                TextColumn::make('record_count')
                    ->label('Logs')
                    ->getStateUsing(fn ($record) => $record->record_count ?? 1)
                    ->badge()
                    ->color('gray')
                    ->visible(fn ($livewire) => empty($livewire->tableFilters['cow']['value']) && !request()->filled('tableFilters.cow')),
            ])
            ->filters([
                SelectFilter::make('cow')
                    ->relationship('cow', 'tag_number')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_name)
                    ->searchable()
                    ->preload(),
                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')
                            ->default(Carbon::now()->startOfMonth()),
                        DatePicker::make('to')
                            ->default(Carbon::now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        // Skip if in Summary Mode (handled in getEloquentQuery via LeftJoin)
                        if (empty(request()->input('tableFilters.cow.value')) && !request()->filled('tableFilters.cow')) {
                            return $query;
                        }

                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['to'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators['from'] = 'From ' . Carbon::parse($data['from'])->toFormattedDateString();
                        }
                        if ($data['to'] ?? null) {
                            $indicators['to'] = 'To ' . Carbon::parse($data['to'])->toFormattedDateString();
                        }
                        return $indicators;
                    })
            ])
            ->actions([
                Action::make('view_details')
                    ->label('View Records')
                    ->icon('heroicon-o-list-bullet')
                    ->url(fn ($record, $livewire) => MilkProductionResource::getUrl('index', [
                        'tableFilters' => [
                            'cow' => [
                                'value' => $record->cow_id ?? $record->id,
                            ],
                            'date_range' => [
                                'from' => $livewire->tableFilters['date_range']['from'] ?? null,
                                'to' => $livewire->tableFilters['date_range']['to'] ?? null,
                            ],
                        ],
                    ]))
                    ->hidden(fn ($livewire) => !empty($livewire->tableFilters['cow']['value']) || request()->filled('tableFilters.cow')),
                EditAction::make()
                    ->visible(fn ($livewire) => !empty($livewire->tableFilters['cow']['value']) || request()->filled('tableFilters.cow')),
            ])
            ->bulkActions([]);
    }
}
