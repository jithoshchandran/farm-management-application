<?php

namespace App\Filament\Resources\ExpenseItems;

use App\Filament\Resources\ExpenseItems\Pages\CreateExpenseItem;
use App\Filament\Resources\ExpenseItems\Pages\EditExpenseItem;
use App\Filament\Resources\ExpenseItems\Pages\ListExpenseItems;
use App\Models\ExpenseItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use BackedEnum; // Added use statement for BackedEnum

class ExpenseItemResource extends Resource
{
    protected static ?string $model = ExpenseItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-list-bullet';
    protected static string|\UnitEnum|null $navigationGroup = 'Resources & Setup';




    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('expense_category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label('Category'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => ListExpenseItems::route('/'),
            'create' => CreateExpenseItem::route('/create'),
            'edit' => EditExpenseItem::route('/{record}/edit'),
        ];
    }
}
