<?php

namespace App\Filament\Resources\Inseminations\Pages;

use App\Filament\Resources\Inseminations\InseminationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInsemination extends EditRecord
{
    protected static string $resource = InseminationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
