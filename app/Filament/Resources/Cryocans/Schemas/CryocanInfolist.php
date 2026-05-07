<?php

namespace App\Filament\Resources\Cryocans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CryocanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tank Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('serial_number')->label('Serial/ID'),
                                TextEntry::make('tank_size_liters')->label('Tank Size (L)')->numeric(),
                                TextEntry::make('status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Active' => 'success',
                                        'Maintenance' => 'warning',
                                        'Empty' => 'danger',
                                        default => 'gray',
                                    }),
                            ]),
                    ]),
                Section::make('Nitrogen & Level Tracking')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('current_level_cm')
                                    ->label('Current Level (cm)')
                                    ->numeric()
                                    ->suffix(' cm'),
                                TextEntry::make('last_refill_date')->label('Last Refilled')->date(),
                                TextEntry::make('next_scheduled_refill')->label('Next Refill')->date(),
                                TextEntry::make('refill_quantity_liters')->label('Refill Quantity (L)'),
                                TextEntry::make('refill_price')->label('Refill Price')->money('INR'),
                            ]),
                    ]),
                Section::make('Support & Notes')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('supplier_name')->label('Supplier/Company'),
                                TextEntry::make('technician_contact')->label('Technician Contact'),
                                TextEntry::make('notes')->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
