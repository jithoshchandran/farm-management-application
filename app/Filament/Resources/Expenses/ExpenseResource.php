<?php

namespace App\Filament\Resources\Expenses;

use App\Filament\Resources\Expenses\Pages\CreateExpense;
use App\Filament\Resources\Expenses\Pages\EditExpense;
use App\Filament\Resources\Expenses\Pages\ListExpenses;
use App\Models\Expense;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static string|\UnitEnum|null $navigationGroup = 'Operations & Finance';




    protected static ?string $navigationLabel = 'Other Expenses';

    protected static ?string $pluralLabel = 'Other Expenses';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('expense_category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Select $component) {
                        $component->getContainer()->getComponent('expense_item_id')->state(null); // Clear item on category change
                    })
                    ->required(),
                Select::make('expense_item_id')
                    ->key('expense_item_id') // IMPORTANT for getComponent to find it
                    ->relationship('item', 'name')
                    ->options(fn ($get): Collection => \App\Models\ExpenseItem::query()
                        ->where('expense_category_id', $get('expense_category_id'))
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->visible(fn ($get) => filled($get('expense_category_id'))), // Only show if category is selected
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('amount')
                    ->numeric()
                    ->prefix('₹') 
                    ->required(),
                Select::make('payment_status')
                    ->options([
                        'Paid' => 'Paid',
                        'Pending' => 'Pending',
                        'Partial' => 'Partial',
                    ])
                    ->required(),
                DatePicker::make('date')
                    ->required()
                    ->default(now()),
                DatePicker::make('expiry_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label('Category'),
                TextColumn::make('item.name')
                    ->searchable()
                    ->sortable()
                    ->label('Item'),
                TextColumn::make('amount')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Paid' => 'success',
                        'Pending' => 'danger',
                        'Partial' => 'warning',
                    })
                    ->searchable(),
                TextColumn::make('expiry_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ]);
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
            'index' => ListExpenses::route('/'),
            'create' => CreateExpense::route('/create'),
            'edit' => EditExpense::route('/{record}/edit'),
        ];
    }
}
