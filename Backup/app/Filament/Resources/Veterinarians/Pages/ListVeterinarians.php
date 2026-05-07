<?php

namespace App\Filament\Resources\Veterinarians\Pages;

use App\Filament\Resources\Veterinarians\VeterinarianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVeterinarians extends ListRecords
{
    protected static string $resource = VeterinarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
