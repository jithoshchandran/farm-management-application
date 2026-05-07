<?php

namespace App\Filament\Resources\Cryocans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CryocanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('serial_number')
                                    ->label('Cryocan Serial/ID')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                \Filament\Forms\Components\Select::make('status')
                                    ->options([
                                        \App\Models\Cryocan::STATUS_ACTIVE => 'Active',
                                        \App\Models\Cryocan::STATUS_MAINTENANCE => 'Maintenance',
                                        \App\Models\Cryocan::STATUS_EMPTY => 'Empty',
                                    ])
                                    ->required()
                                    ->default(\App\Models\Cryocan::STATUS_ACTIVE),
                                TextInput::make('tank_size_liters')
                                    ->label('Tank Size (Liters)')
                                    ->numeric(),
                            ]),
                    ]),

                Section::make('Last Refill & Level Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('last_refill_date')
                                    ->label('Refilled Date')
                                    ->readOnly(),
                                TextInput::make('refill_quantity_liters')
                                    ->label('Refilled Qty (L)')
                                    ->numeric()
                                    ->readOnly(),
                                TextInput::make('refill_price')
                                    ->label('Refill Price')
                                    ->numeric()
                                    ->prefix('₹')
                                    ->readOnly(),
                                DatePicker::make('next_scheduled_refill')
                                    ->label('Next Scheduled Refill'),
                                TextInput::make('current_level_cm')
                                    ->label('Current Level (cm)')
                                    ->numeric()
                                    ->readOnly(),
                            ]),
                    ]),

                Section::make('Supplier & Notes')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('supplier_name')
                                    ->label('Technician/Supplier'),
                                TextInput::make('technician_contact')
                                    ->label('Contact Info'),
                                Textarea::make('notes')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
