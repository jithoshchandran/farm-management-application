<?php

namespace App\Filament\Resources\SemenStocks\Pages;

use App\Filament\Resources\SemenStocks\SemenStockResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSemenStock extends EditRecord
{
    protected static string $resource = SemenStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
