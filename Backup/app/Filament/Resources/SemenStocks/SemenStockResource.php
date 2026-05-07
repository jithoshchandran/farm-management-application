<?php

namespace App\Filament\Resources\SemenStocks;

use App\Filament\Resources\SemenStocks\Pages\CreateSemenStock;
use App\Filament\Resources\SemenStocks\Pages\EditSemenStock;
use App\Filament\Resources\SemenStocks\Pages\ListSemenStocks;
use App\Filament\Resources\SemenStocks\Pages\ViewSemenStock;
use App\Filament\Resources\SemenStocks\Schemas\SemenStockForm;
use App\Filament\Resources\SemenStocks\Schemas\SemenStockInfolist;
use App\Filament\Resources\SemenStocks\Tables\SemenStocksTable;
use App\Models\SemenStock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SemenStockResource extends Resource
{
    protected static ?string $model = SemenStock::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Health & Breeding';

    protected static ?int $navigationSort = 4;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Schema $schema): Schema
    {
        return SemenStockForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SemenStockInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SemenStocksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSemenStocks::route('/'),
            'create' => CreateSemenStock::route('/create'),
            'view' => ViewSemenStock::route('/{record}'),
            'edit' => EditSemenStock::route('/{record}/edit'),
        ];
    }
}
