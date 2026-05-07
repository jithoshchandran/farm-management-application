<?php

namespace App\Filament\Resources\SemenStocks\Pages;

use App\Filament\Resources\SemenStocks\SemenStockResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSemenStock extends ViewRecord
{
    protected static string $resource = SemenStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
