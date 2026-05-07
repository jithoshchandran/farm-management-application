<?php

namespace App\Filament\Resources\Inseminations\Pages;

use App\Filament\Resources\Inseminations\InseminationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInseminations extends ListRecords
{
    protected static string $resource = InseminationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
