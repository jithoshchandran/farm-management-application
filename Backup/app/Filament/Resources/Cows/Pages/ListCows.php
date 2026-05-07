<?php

namespace App\Filament\Resources\Cows\Pages;

use App\Filament\Resources\Cows\CowResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCows extends ListRecords
{
    protected static string $resource = CowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
