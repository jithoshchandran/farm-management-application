<?php

namespace App\Filament\Resources\MilkProductions\Pages;

use App\Filament\Resources\MilkProductions\MilkProductionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMilkProduction extends EditRecord
{
    protected static string $resource = MilkProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
