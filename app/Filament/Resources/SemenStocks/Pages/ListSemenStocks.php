<?php

namespace App\Filament\Resources\SemenStocks\Pages;

use App\Filament\Resources\SemenStocks\SemenStockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSemenStocks extends ListRecords
{
    protected static string $resource = SemenStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
