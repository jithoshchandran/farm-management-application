<?php

namespace App\Filament\Resources\Cryocans\Pages;

use App\Filament\Resources\Cryocans\CryocanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCryocan extends EditRecord
{
    protected static string $resource = CryocanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
