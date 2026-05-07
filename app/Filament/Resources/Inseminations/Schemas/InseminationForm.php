<?php

namespace App\Filament\Resources\Inseminations\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Grid;

class InseminationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cow_id')
                    ->relationship('cow', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_name)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Cow (Tag Number)'),
                
                DatePicker::make('date')
                    ->default(now())
                    ->required()
                    ->maxDate(now())
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $date = \Carbon\Carbon::parse($state);
                            $set('expected_calving_date', $date->addDays(283)->format('Y-m-d'));
                        }
                    }),

                DatePicker::make('expected_calving_date')
                    ->label('Expected Calving Date')
                    ->helperText('Standard gestation is 283 days from insemination.')
                    ->required(),

                Grid::make(3)
                    ->schema([
                         Select::make('type')
                            ->options([
                                'Artificial Insemination' => 'Artificial Insemination', 
                                'Natural' => 'Natural'
                            ])
                            ->required()
                            ->default('Artificial Insemination')
                            ->live(),

                        Select::make('semen_stock_id')
                            ->label('Semen Stock')
                            ->relationship('semenStock', 'bull_name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_display_name)
                            ->searchable()
                            ->preload()
                            ->visible(fn ($get) => $get('type') === 'Artificial Insemination')
                            ->required(fn ($get) => $get('type') === 'Artificial Insemination'),

                        TextInput::make('straws_used')
                            ->label('Number of Straws Used')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->visible(fn ($get) => $get('type') === 'Artificial Insemination')
                            ->required(fn ($get) => $get('type') === 'Artificial Insemination'),

                        TextInput::make('semen_batch_code')
                            ->label('Manual Batch Code')
                            ->visible(fn ($get) => $get('type') === 'Artificial Insemination'),

                        TextInput::make('bull_tag')
                            ->label('Bull Tag / Name')
                            ->visible(fn ($get) => $get('type') === 'Natural'),

                        Select::make('technician_name')
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
                            })
                            ->default('Farm Technician'),
                            
                        TextInput::make('cost')
                            ->numeric()
                            ->prefix('₹')
                            ->default(0),

                        Select::make('is_successful')
                            ->label('Result / Status')
                            ->options([
                                null => 'Pending / Unknown',
                                true => 'Success (Pregnant)',
                                false => 'Failed (Open)',
                            ])
                            ->placeholder('Select result if known')
                            ->native(false),
                    ]),

                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
