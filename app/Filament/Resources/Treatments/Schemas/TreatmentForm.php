<?php

namespace App\Filament\Resources\Treatments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TreatmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cow_id')
                    ->relationship('cow', 'tag_number')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_name)
                    ->required(),
                Select::make('veterinarian')
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
                TextInput::make('diagnosis')
                    ->required(),
                \Filament\Forms\Components\Repeater::make('medicines')
                    ->schema([
                        TextInput::make('medicine_name')
                            ->required(),
                        TextInput::make('dosage')
                            ->placeholder('e.g., 10mg'),
                        TextInput::make('days')
                            ->numeric(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
                \Filament\Forms\Components\FileUpload::make('prescription')
                    ->disk('public')
                    ->directory('treatments/prescriptions')
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->maxSize(5120)
                    ->helperText('Max 5MB - PDF, JPG, JPEG, PNG')
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->placeholder('Additional notes...')
                    ->columnSpanFull(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                TextInput::make('withdrawal_days')
                    ->required()
                    ->numeric()
                    ->default(0),
                DatePicker::make('withdrawal_end_date'),
                TextInput::make('status')
                    ->required()
                    ->default('Active'),
                TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('₹'),
            ]);
    }
}
