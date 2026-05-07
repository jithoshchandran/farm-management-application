<?php

namespace App\Filament\Resources\MilkProductions\Pages;

use App\Filament\Resources\MilkProductions\MilkProductionResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class ViewCowProduction extends Page
{
    use InteractsWithRecord;

    protected static string $resource = MilkProductionResource::class;

    protected string $view = 'filament.resources.milk-productions.pages.view-cow-production';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
