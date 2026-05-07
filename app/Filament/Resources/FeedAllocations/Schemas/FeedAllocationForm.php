<?php

namespace App\Filament\Resources\FeedAllocations\Schemas;

use App\Models\Feed;
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
                    ->options(Feed::CATEGORY_OPTIONS)
                    ->live()
                    ->searchable()
                    ->preload()
                    ->dehydrated(false)
                    ->afterStateUpdated(fn ($set) => $set('feed_id', null))
                    ->afterStateHydrated(function ($set, $record): void {
                        if ($record && $record->feed_id) {
                            $feed = Feed::find($record->feed_id);

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
                            return Feed::query()->orderBy('name')->pluck('name', 'id');
                        }

                        return Feed::query()
                            ->where('category', $category)
                            ->orderBy('name')
                            ->pluck('name', 'id');
                    })
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $get): void {
                        $quantity = $get('quantity');

                        if ($state) {
                            $feed = Feed::find($state);

                            if ($feed && $quantity) {
                                $set('cost', round((float) $feed->cost_per_kg * (float) $quantity, 2));
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
                    ->afterStateUpdated(function ($state, $set, $get): void {
                        $feedId = $get('feed_id');

                        if ($feedId && $state) {
                            $feed = Feed::find($feedId);

                            if ($feed) {
                                $set('cost', round((float) $feed->cost_per_kg * (float) $state, 2));
                            }
                        }
                    }),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('cost')
                    ->label('Total Cost')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('Rs'),
            ]);
    }
}
