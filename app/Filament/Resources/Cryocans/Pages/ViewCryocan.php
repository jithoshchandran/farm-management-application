<?php

namespace App\Filament\Resources\Cryocans\Pages;

use App\Filament\Resources\Cryocans\CryocanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCryocan extends ViewRecord
{
    protected static string $resource = CryocanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
