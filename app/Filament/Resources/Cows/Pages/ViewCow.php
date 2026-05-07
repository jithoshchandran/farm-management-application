<?php

namespace App\Filament\Resources\Cows\Pages;

use App\Filament\Resources\Cows\CowResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCow extends ViewRecord
{
    protected static string $resource = CowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->name ?: parent::getTitle();
    }
}
