<?php

namespace App\Filament\Resources\Staff;

use App\Filament\Resources\Staff\Pages\CreateStaff;
use App\Filament\Resources\Staff\Pages\EditStaff;
use App\Filament\Resources\Staff\Pages\ListStaff;
use App\Filament\Resources\Staff\Pages\ViewStaff;
use App\Filament\Resources\Staff\RelationManagers\StaffRemarksRelationManager;
use App\Filament\Resources\Staff\RelationManagers\StaffLeavesRelationManager;
use App\Models\Staff;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static string|\UnitEnum|null $navigationGroup = 'Personnel Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    // Using standard type hint now that the true cause of the crash (navigationIcon) is fixed
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('address')
                    ->columnSpanFull(),
                FileUpload::make('id_proof')
                    ->image()
                    ->disk('public')
                    ->directory('staff-ids'),
                DatePicker::make('joined_date')
                    ->required()
                    ->default(now()),
                Select::make('salary_type')
                    ->options([
                        'Daily' => 'Daily',
                        'Weekly' => 'Weekly',
                        'Monthly' => 'Monthly',
                    ])
                    ->required(),
                TextInput::make('salary_amount')
                    ->numeric()
                    ->prefix('₹')
                    ->required(),
                Toggle::make('status')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('id_proof')
                    ->label('ID Proof')
                    ->disk('public'),
                TextColumn::make('address')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('joined_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('salary_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Daily' => 'info',
                        'Weekly' => 'warning',
                        'Monthly' => 'success',
                    }),
                TextColumn::make('salary_amount')
                    ->money('INR')
                    ->sortable(),
                IconColumn::make('status')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StaffRemarksRelationManager::class,
            StaffLeavesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStaff::route('/'),
            'create' => CreateStaff::route('/create'),
            'view' => ViewStaff::route('/{record}'),
            'edit' => EditStaff::route('/{record}/edit'),
        ];
    }
}
