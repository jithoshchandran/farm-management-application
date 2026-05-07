<?php

namespace App\Filament\Resources\FeedPurchases\Schemas;

use App\Models\Feed;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class FeedPurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        DatePicker::make('purchase_date')
                            ->required()
                            ->default(now()),
                        Select::make('category')
                            ->options(Feed::CATEGORY_OPTIONS)
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($set): void {
                                $set('feed_id', null);
                                $set('unit', 'kg');
                                $set('unit_price', 0);
                                $set('total', 0);
                            }),
                        Select::make('feed_id')
                            ->label('Feed')
                            ->options(function ($get) {
                                return Feed::query()
                                    ->when($get('category'), fn ($query, $category) => $query->where('category', $category))
                                    ->orderBy('name')
                                    ->pluck('name', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get): void {
                                $feed = Feed::find($state);

                                if ($feed) {
                                    $set('category', $feed->category);
                                    $set('unit', $feed->unit ?: 'kg');
                                    $set('unit_price', $feed->cost_per_kg ?: 0);
                                }

                                self::updateTotal($set, $get);
                            }),
                        Select::make('unit')
                            ->options(Feed::UNIT_OPTIONS)
                            ->default('kg')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('unit_price')
                            ->label('Unit Price')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->prefix('Rs')
                            ->live()
                            ->afterStateUpdated(fn ($state, $set, $get) => self::updateTotal($set, $get)),
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->live()
                            ->afterStateUpdated(fn ($state, $set, $get) => self::updateTotal($set, $get)),
                        TextInput::make('total')
                            ->label('Total')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rs')
                            ->readOnly()
                            ->dehydrated(),
                    ]),
            ]);
    }

    private static function updateTotal($set, $get): void
    {
        $set('total', round((float) ($get('unit_price') ?? 0) * (float) ($get('quantity') ?? 0), 2));
    }
}
