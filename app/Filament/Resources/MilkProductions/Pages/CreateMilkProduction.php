<?php

namespace App\Filament\Resources\MilkProductions\Pages;

use App\Filament\Resources\MilkProductions\MilkProductionResource;
use App\Models\MilkProduction;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMilkProduction extends CreateRecord
{
    protected static string $resource = MilkProductionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return MilkProduction::updateOrCreate(
            [
                'cow_id' => $data['cow_id'],
                'date' => $data['date'],
            ],
            $data
        );
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateAnotherFormAction(),
            $this->getCancelFormAction(),
        ];
    }
}
