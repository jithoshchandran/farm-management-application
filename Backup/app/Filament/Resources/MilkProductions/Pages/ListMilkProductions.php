<?php

namespace App\Filament\Resources\MilkProductions\Pages;

use App\Filament\Resources\MilkProductions\MilkProductionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMilkProductions extends ListRecords
{
    protected static string $resource = MilkProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Check both Livewire state and direct request for the cow filter
        $cowId = $this->tableFilters['cow']['value'] 
                ?? request()->input('tableFilters.cow.value') 
                ?? request()->input('tableFilters.cow');

        if (!empty($cowId)) {
            return $query;
        }

        // Otherwise, show aggregated summary grouped by cow
        return $query
            ->selectRaw('cow_id as id, cow_id, SUM(total_yield) as total_yield, COUNT(*) as record_count')
            ->groupBy('cow_id');
    }
}
