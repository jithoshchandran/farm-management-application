<?php

namespace App\Filament\Resources\Vaccinations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VaccinationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cow_id')
                    ->relationship('cow', 'tag_number')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_name)
                    ->required(),
                TextInput::make('vaccine_name')
                    ->required(),
                DatePicker::make('date_administered')
                    ->required(),
                DatePicker::make('next_due_date'),
                TextInput::make('batch_number'),
                Select::make('administered_by')
                    ->options(\App\Models\Veterinarian::all()->pluck('name', 'name'))
                    ->searchable()
                    ->createOptionForm([
                        TextInput::make('name')->required(),
                        TextInput::make('location'),
                        TextInput::make('contact_number')->tel(),
                        TextInput::make('whatsapp_number')->tel(),
                    ])
                    ->createOptionUsing(function (array $data) {
                        return \App\Models\Veterinarian::create($data)->name;
                    }),
                Toggle::make('notification_sent')
                    ->required(),
            ]);
    }
}
