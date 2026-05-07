<?php

namespace App\Filament\Resources\Vaccinations\Pages;

use App\Filament\Resources\Vaccinations\VaccinationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVaccination extends CreateRecord
{
    protected static string $resource = VaccinationResource::class;
}
