<?php

namespace App\Filament\Resources\Cryocans\Pages;

use App\Filament\Resources\Cryocans\CryocanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCryocans extends ListRecords
{
    protected static string $resource = CryocanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
