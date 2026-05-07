<?php

namespace App\Filament\Resources\SemenStocks\Schemas;

use Filament\Schemas\Schema;

class SemenStockForm
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
                                        \Filament\Forms\Components\TextInput::make('bull_name')
                                            ->label('Animal Name')
                                            ->required(),
                                        \Filament\Forms\Components\TextInput::make('bull_tag')
                                            ->label('Tag/Number')
                                            ->required(),
                                        \Filament\Forms\Components\TextInput::make('breed')
                                            ->label('Breed'),
                                        \Filament\Forms\Components\DatePicker::make('batch_date')
                                            ->label('Straw/Batch Date'),
                                        \Filament\Forms\Components\DatePicker::make('collection_date')
                                            ->label('Collection Date'),
                                        \Filament\Forms\Components\TextInput::make('initial_quantity')
                                            ->numeric()
                                            ->label('Total Straws Purchased'),
                                        \Filament\Forms\Components\TextInput::make('remaining_quantity')
                                            ->numeric()
                                            ->label('Straws Remaining'),
                                    ]),
                                \Filament\Forms\Components\Textarea::make('notes')
                                    ->label('Notes')
                                    ->columnSpanFull(),
                            ]),
                        \Filament\Schemas\Components\Tabs\Tab::make('Purchase & Pedigree')
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Forms\Components\DatePicker::make('purchase_date')
                                            ->label('Purchase Date'),
                                        \Filament\Forms\Components\TextInput::make('contact_name')
                                            ->label('Contact Name'),
                                        \Filament\Forms\Components\TextInput::make('contact_location')
                                            ->label('Location'),
                                        \Filament\Forms\Components\TextInput::make('contact_phone_1')
                                            ->label('Phone 1')
                                            ->tel(),
                                        \Filament\Forms\Components\TextInput::make('contact_phone_2')
                                            ->label('Phone 2')
                                            ->tel(),
                                        \Filament\Forms\Components\TextInput::make('purchase_cost')
                                            ->label('Purchase Cost')
                                            ->numeric()
                                            ->prefix('₹'),
                                        \Filament\Forms\Components\Select::make('cryocan_id')
                                            ->label('Storage Cryocan')
                                            ->relationship('cryocan', 'serial_number')
                                            ->searchable()
                                            ->preload(),
                                        \Filament\Forms\Components\TextInput::make('sire_name')
                                            ->label('Sire (Father)'),
                                        \Filament\Forms\Components\TextInput::make('dam_name')
                                            ->label('Dam (Mother)'),
                                    ]),
                            ]),
                        \Filament\Schemas\Components\Tabs\Tab::make('Media')
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(3)
                                    ->schema([
                                        \Filament\Forms\Components\FileUpload::make('bull_image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('semen-stocks/bulls')
                                            ->label('Bull Image'),
                                        \Filament\Forms\Components\FileUpload::make('sire_image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('semen-stocks/sires')
                                            ->label('Sire Image'),
                                        \Filament\Forms\Components\FileUpload::make('dam_image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('semen-stocks/dams')
                                            ->label('Dam Image'),
                                    ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
