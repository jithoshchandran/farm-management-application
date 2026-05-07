<?php

namespace App\Filament\Resources\Cows;

use App\Filament\Resources\Cows\Pages\CreateCow;
use App\Filament\Resources\Cows\Pages\EditCow;
use App\Filament\Resources\Cows\Pages\ListCows;
use App\Filament\Resources\Cows\Pages\ViewCow;
use App\Filament\Resources\Cows\Schemas\CowForm;
use App\Filament\Resources\Cows\Schemas\CowInfolist;
use App\Filament\Resources\Cows\Tables\CowsTable;
use App\Models\Cow;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CowResource extends Resource
{
    protected static ?string $model = Cow::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Resources & Setup';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CowForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CowInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CowsTable::configure($table);
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
            'index' => ListCows::route('/'),
            'create' => CreateCow::route('/create'),
            'view' => ViewCow::route('/{record}'),
            'edit' => EditCow::route('/{record}/edit'),
        ];
    }
}
