<?php

namespace App\Filament\Resources\SemenStocks\Schemas;

use Filament\Schemas\Schema;

class SemenStockInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Tabs::make('Semen Stock Details')
                    ->tabs([
                        \Filament\Schemas\Components\Tabs\Tab::make('Bull Details')
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(3)
                                    ->schema([
                                        \Filament\Infolists\Components\TextEntry::make('full_display_name')->label('Bull / Stock ID'),
                                        \Filament\Infolists\Components\TextEntry::make('bull_tag')->label('Tag/Number'),
                                        \Filament\Infolists\Components\TextEntry::make('breed')->label('Breed'),
                                        \Filament\Infolists\Components\TextEntry::make('batch_date')->label('Straw/Batch Date')->date(),
                                        \Filament\Infolists\Components\TextEntry::make('collection_date')->label('Collection Date')->date(),
                                        \Filament\Infolists\Components\TextEntry::make('initial_quantity')->label('Total Straws Purchased'),
                                        \Filament\Infolists\Components\TextEntry::make('remaining_quantity')->label('Straws Remaining'),
                                    ]),
                                \Filament\Infolists\Components\TextEntry::make('notes')
                                    ->label('Notes')
                                    ->columnSpanFull(),
                            ]),
                        \Filament\Schemas\Components\Tabs\Tab::make('Acquisition & Pedigree')
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Infolists\Components\TextEntry::make('purchase_date')->label('Purchase Date')->date(),
                                        \Filament\Infolists\Components\TextEntry::make('contact_name')->label('Contact Name'),
                                        \Filament\Infolists\Components\TextEntry::make('contact_location')->label('Location'),
                                        \Filament\Infolists\Components\TextEntry::make('contact_phone_1')->label('Phone 1'),
                                        \Filament\Infolists\Components\TextEntry::make('contact_phone_2')->label('Phone 2'),
                                        \Filament\Infolists\Components\TextEntry::make('purchase_cost')->label('Purchase Cost')->money('INR'),
                                        \Filament\Infolists\Components\TextEntry::make('cryocan.serial_number')->label('Storage Cryocan'),
                                        \Filament\Infolists\Components\TextEntry::make('sire_name')->label('Sire (Father)'),
                                        \Filament\Infolists\Components\TextEntry::make('dam_name')->label('Dam (Mother)'),
                                    ]),
                            ]),
                        \Filament\Schemas\Components\Tabs\Tab::make('Media')
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(3)
                                    ->schema([
                                        \Filament\Infolists\Components\ImageEntry::make('bull_image')
                                            ->label('Bull Image')
                                            ->disk('public'),
                                        \Filament\Infolists\Components\ImageEntry::make('sire_image')
                                            ->label('Sire Image')
                                            ->disk('public'),
                                        \Filament\Infolists\Components\ImageEntry::make('dam_image')
                                            ->label('Dam Image')
                                            ->disk('public'),
                                    ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
