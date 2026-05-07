<?php

namespace App\Filament\Resources\Cows\Pages;

use App\Filament\Resources\Cows\CowResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCow extends EditRecord
{
    protected static string $resource = CowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->name ?: parent::getTitle();
    }
}
