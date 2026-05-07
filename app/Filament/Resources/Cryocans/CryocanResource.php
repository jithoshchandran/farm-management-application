<?php

namespace App\Filament\Resources\Cryocans;

use App\Filament\Resources\Cryocans\Pages\CreateCryocan;
use App\Filament\Resources\Cryocans\Pages\EditCryocan;
use App\Filament\Resources\Cryocans\Pages\ListCryocans;
use App\Filament\Resources\Cryocans\Pages\ViewCryocan;
use App\Filament\Resources\Cryocans\Schemas\CryocanForm;
use App\Filament\Resources\Cryocans\Schemas\CryocanInfolist;
use App\Filament\Resources\Cryocans\Tables\CryocansTable;
use App\Models\Cryocan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\Cryocans\RelationManagers;

class CryocanResource extends Resource
{
    protected static ?string $model = Cryocan::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-battery-100';
    protected static string|\UnitEnum|null $navigationGroup = 'Health & Breeding';




    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'serial_number';

    public static function form(Schema $schema): Schema
    {
        return CryocanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CryocanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CryocansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\InspectionsRelationManager::class,
            RelationManagers\RefillsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCryocans::route('/'),
            'create' => CreateCryocan::route('/create'),
            'view' => ViewCryocan::route('/{record}'),
            'edit' => EditCryocan::route('/{record}/edit'),
        ];
    }
}
