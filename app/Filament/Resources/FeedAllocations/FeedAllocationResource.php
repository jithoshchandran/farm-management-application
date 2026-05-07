<?php

namespace App\Filament\Resources\FeedAllocations;

use App\Filament\Resources\FeedAllocations\Pages\CreateFeedAllocation;
use App\Filament\Resources\FeedAllocations\Pages\EditFeedAllocation;
use App\Filament\Resources\FeedAllocations\Pages\ListFeedAllocations;
use App\Filament\Resources\FeedAllocations\Schemas\FeedAllocationForm;
use App\Filament\Resources\FeedAllocations\Tables\FeedAllocationsTable;
use App\Models\FeedAllocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FeedAllocationResource extends Resource
{
    protected static ?string $model = FeedAllocation::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static string|\UnitEnum|null $navigationGroup = 'Operations & Finance';




    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'date';

    public static function form(Schema $schema): Schema
    {
        return FeedAllocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FeedAllocationsTable::configure($table);
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
            'index' => ListFeedAllocations::route('/'),
            'create' => CreateFeedAllocation::route('/create'),
            'edit' => EditFeedAllocation::route('/{record}/edit'),
        ];
    }
}
