<?php

namespace App\Filament\Resources\Inseminations;

use App\Filament\Resources\Inseminations\Pages\CreateInsemination;
use App\Filament\Resources\Inseminations\Pages\EditInsemination;
use App\Filament\Resources\Inseminations\Pages\ListInseminations;
use App\Filament\Resources\Inseminations\Schemas\InseminationForm;
use App\Filament\Resources\Inseminations\Tables\InseminationsTable;
use App\Models\Insemination;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InseminationResource extends Resource
{
    protected static ?string $model = Insemination::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-check-badge';

    protected static string|\UnitEnum|null $navigationGroup = 'Health & Breeding';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return InseminationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InseminationsTable::configure($table);
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
            'index' => ListInseminations::route('/'),
            'create' => CreateInsemination::route('/create'),
            'edit' => EditInsemination::route('/{record}/edit'),
        ];
    }
}
