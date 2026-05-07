<?php

namespace App\Filament\Resources\FeedPurchases;

use App\Filament\Resources\FeedPurchases\Pages\CreateFeedPurchase;
use App\Filament\Resources\FeedPurchases\Pages\EditFeedPurchase;
use App\Filament\Resources\FeedPurchases\Pages\ListFeedPurchases;
use App\Filament\Resources\FeedPurchases\Schemas\FeedPurchaseForm;
use App\Filament\Resources\FeedPurchases\Tables\FeedPurchasesTable;
use App\Models\FeedPurchase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class FeedPurchaseResource extends Resource
{
    protected static ?string $model = FeedPurchase::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    protected static string|\UnitEnum|null $navigationGroup = 'Operations & Finance';




    protected static ?string $navigationLabel = 'Feed Stock/Purchase';

    protected static ?string $pluralLabel = 'Feed Stock/Purchase';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'purchase_date';

    public static function form(Schema $schema): Schema
    {
        return FeedPurchaseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FeedPurchasesTable::configure($table);
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
            'index' => ListFeedPurchases::route('/'),
            'create' => CreateFeedPurchase::route('/create'),
            'edit' => EditFeedPurchase::route('/{record}/edit'),
        ];
    }
}
