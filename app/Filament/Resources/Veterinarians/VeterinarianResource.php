<?php

namespace App\Filament\Resources\Veterinarians;

use App\Filament\Resources\Veterinarians\Pages\CreateVeterinarian;
use App\Filament\Resources\Veterinarians\Pages\EditVeterinarian;
use App\Filament\Resources\Veterinarians\Pages\ListVeterinarians;
use App\Filament\Resources\Veterinarians\Schemas\VeterinarianForm;
use App\Filament\Resources\Veterinarians\Tables\VeterinariansTable;
use App\Models\Veterinarian;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VeterinarianResource extends Resource
{
    protected static ?string $model = Veterinarian::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-plus';
    protected static string|\UnitEnum|null $navigationGroup = 'Personnel Management';




    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return VeterinarianForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VeterinariansTable::configure($table);
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
            'index' => ListVeterinarians::route('/'),
            'create' => CreateVeterinarian::route('/create'),
            'edit' => EditVeterinarian::route('/{record}/edit'),
        ];
    }
}
