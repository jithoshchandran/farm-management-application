<?php

namespace App\Filament\Resources\MilkProductions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MilkProductionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cow_id')
                    ->relationship('cow', 'tag_number', fn ($query) => $query->where('gender', 'Female')->where('status', 'Lactating'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_name)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // Check for active treatment withdrawal
                        if (!$state) return;
                        
                        $isWithholding = \App\Models\Treatment::where('cow_id', $state)
                             ->whereDate('withdrawal_end_date', '>=', $get('date') ?? now())
                             ->exists();
                        
                        if ($isWithholding) {
                            \Filament\Notifications\Notification::make()
                                ->title('Warning: Cow in Withdrawal Period')
                                ->body('The milk from this cow must be discarded!')
                                ->danger()
                                ->persistent()
                                ->send();
                        }
                    }),
                DatePicker::make('date')
                    ->required()
                    ->default(now())
                    ->maxDate(now()),
                TextInput::make('morning_yield')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($get, $set) => $set('total_yield', $get('morning_yield') + $get('evening_yield'))),
                TextInput::make('evening_yield')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($get, $set) => $set('total_yield', $get('morning_yield') + $get('evening_yield'))),
                TextInput::make('total_yield')
                    ->required()
                    ->numeric()
                    ->readOnly()
                    ->default(0),
            ]);
    }
}
