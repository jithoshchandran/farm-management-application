<?php

namespace App\Filament\Resources\FeedAllocations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FeedAllocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('feed_category')
                    ->label('Feed Category')
                    ->options([
                        'Green Fodder' => 'Green Fodder',
                        'Dry Fodder' => 'Dry Fodder',
                        'Concentrates' => 'Concentrates',
                        'Food Supplements & Vitamins' => 'Food Supplements & Vitamins',
                        'Mineral Licks' => 'Mineral Licks',
                    ])
                    ->live()
                    ->searchable()
                    ->preload()
                    ->dehydrated(false)
                    ->afterStateUpdated(fn ($set) => $set('feed_id', null))
                    ->afterStateHydrated(function ($set, $record) {
                        if ($record && $record->feed_id) {
                            $feed = \App\Models\Feed::find($record->feed_id);
                            if ($feed) {
                                $set('feed_category', $feed->category);
                            }
                        }
                    }),

                Select::make('feed_id')
                    ->label('Select Feed')
                    ->searchable()
                    ->preload()
                    ->options(function ($get) {
                        $category = $get('feed_category');
                        if (! $category) {
                            return \App\Models\Feed::all()->pluck('name', 'id');
                        }
                        return \App\Models\Feed::where('category', $category)->pluck('name', 'id');
                    })
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $quantity = $get('quantity');
                        if ($state) {
                            $feed = \App\Models\Feed::find($state);
                            if ($feed && $quantity) {
                                $set('cost', $feed->cost_per_kg * $quantity);
                            }
                        }
                    }),
                Select::make('target_group')
                    ->label('Target Group')
                    ->options([
                        'None' => 'None',
                        'Large Cows' => 'Large Cows',
                        'Heifers' => 'Heifers',
                        'Pregnant Cows' => 'Pregnant Cows',
                        'Large Bulls' => 'Large Bulls',
                        'Small Bulls' => 'Small Bulls',
                        'Lactating Cows' => 'Lactating Cows',
                        'Dry cows' => 'Dry cows',
                    ])
                    ->default('None'),
                Select::make('cow_id')
                    ->label('Individual Cow (Optional)')
                    ->relationship('cow', 'tag_number')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_name)
                    ->searchable()
                    ->preload()
                    ->placeholder('Select a cow for individual allocation'),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $feedId = $get('feed_id');
                        if ($feedId && $state) {
                            $feed = \App\Models\Feed::find($feedId);
                            if ($feed) {
                                $set('cost', $feed->cost_per_kg * $state);
                            }
                        }
                    }),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('₹'),
            ]);
    }
}
