<?php

namespace App\Filament\Resources\MilkProductions;

use App\Filament\Resources\MilkProductions\Pages\CreateMilkProduction;
use App\Filament\Resources\MilkProductions\Pages\EditMilkProduction;
use App\Filament\Resources\MilkProductions\Pages\ListMilkProductions;
use App\Filament\Resources\MilkProductions\Schemas\MilkProductionForm;
use App\Filament\Resources\MilkProductions\Tables\MilkProductionsTable;
use App\Models\MilkProduction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class MilkProductionResource extends Resource
{
    protected static ?string $model = MilkProduction::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    protected static string|\UnitEnum|null $navigationGroup = 'Operations & Finance';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'date';

    public static function form(Schema $schema): Schema
    {
        return MilkProductionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MilkProductionsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $cowFilter = request()->input('tableFilters.cow.value') ?? request()->input('tableFilters.cow');

        if (!$cowFilter) {
            // Summary Mode: Show all female cows
            $from = request()->input('tableFilters.date_range.from');
            $to = request()->input('tableFilters.date_range.to');

            return MilkProduction::query()
                ->from('cows')
                ->leftJoin('milk_productions', function ($join) use ($from, $to) {
                    $join->on('cows.id', '=', 'milk_productions.cow_id');
                    if ($from) {
                        $join->whereDate('milk_productions.date', '>=', $from);
                    }
                    if ($to) {
                        $join->whereDate('milk_productions.date', '<=', $to);
                    }
                })
                ->where('cows.gender', 'Female')
                ->where('cows.status', 'Lactating')
                ->selectRaw('
                    cows.id as id,
                    cows.id as cow_id,
                    cows.name as cow_name,
                    cows.tag_number as cow_tag,
                    SUM(COALESCE(morning_yield, 0)) as morning_yield,
                    SUM(COALESCE(evening_yield, 0)) as evening_yield,
                    SUM(COALESCE(total_yield, 0)) as total_yield,
                    COUNT(milk_productions.id) as record_count
                ')
                ->groupBy('cows.id', 'cows.name', 'cows.tag_number');
        } else {
            // Detailed Mode: Standard MilkProduction filtering
            return parent::getEloquentQuery()
                ->whereHas('cow', fn($q) => $q->where('gender', 'Female'))
                ->where('cow_id', $cowFilter);
        }
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
            'index' => ListMilkProductions::route('/'),
            'create' => CreateMilkProduction::route('/create'),
            'edit' => EditMilkProduction::route('/{record}/edit'),
        ];
    }
}
