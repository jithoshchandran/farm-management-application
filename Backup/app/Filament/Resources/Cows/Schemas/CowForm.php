<?php

namespace App\Filament\Resources\Cows\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Details')
                    ->tabs([
                        Tabs\Tab::make('General Details')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('tag_number')->required(),
                                        TextInput::make('name'),
                                        DatePicker::make('dob')->required(),
                                        Select::make('gender')
                                            ->options(['Female' => 'Female', 'Male' => 'Male'])
                                            ->default('Female')
                                            ->required()
                                            ->live(),
                                        Select::make('status')
                                            ->options([
                                                'Active' => 'Active',
                                                'Dry' => 'Dry', 
                                                'Pregnant' => 'Pregnant',
                                                'Sick' => 'Sick',
                                                'Sold' => 'Sold',
                                                'Lactating' => 'Lactating',
                                                'Inseminated' => 'Inseminated',
                                            ])
                                            ->default('Active')
                                            ->required(),
                                        Select::make('breed_id')
                                            ->relationship('breed', 'name', fn ($query) => $query->where('is_active', true))
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('name')
                                                            ->required()
                                                            ->unique('breeds', 'name'),
                                                        Toggle::make('is_active')
                                                            ->label('Enable')
                                                            ->default(true),
                                                    ]),
                                            ])
                                            ->label('Breed'),
                                        TextInput::make('weight')->numeric()->suffix('kg'),
                                        TextInput::make('milk_production_avg')
                                            ->numeric()
                                            ->label('Avg Milk (L/day)')
                                            ->hidden(fn ($get) => $get('gender') === 'Male'),
                                        DatePicker::make('last_calving_date')
                                            ->hidden(fn ($get) => $get('gender') === 'Male'),
                                        TextInput::make('breeding_cycle')
                                            ->numeric()
                                            ->default(0)
                                            ->hidden(fn ($get) => $get('gender') === 'Male'),
                                        DatePicker::make('last_heat_date')
                                            ->hidden(fn ($get) => $get('gender') === 'Male'),
                                        DatePicker::make('next_expected_heat')
                                            ->hidden(fn ($get) => $get('gender') === 'Male'),
                                    ]),
                            ]),
                        Tabs\Tab::make('Acquisition')
                            ->schema([
                                Radio::make('acquisition_type')
                                    ->options([
                                        'Born' => 'Born',
                                        'Purchased' => 'Purchased',
                                    ])
                                    ->default('Born')
                                    ->live()
                                    ->columns(2),
                                Grid::make(2)
                                    ->schema([
                                        DatePicker::make('purchase_date')
                                            ->visible(fn ($get) => $get('acquisition_type') === 'Purchased')
                                            ->required(fn ($get) => $get('acquisition_type') === 'Purchased'),
                                        TextInput::make('purchase_from')
                                            ->visible(fn ($get) => $get('acquisition_type') === 'Purchased')
                                            ->label('Purchased From'),
                                        TextInput::make('purchase_age')
                                            ->visible(fn ($get) => $get('acquisition_type') === 'Purchased')
                                            ->label('Age at Purchase'),
                                        Select::make('purchase_status')
                                            ->visible(fn ($get) => $get('acquisition_type') === 'Purchased')
                                            ->options([
                                                'Heifer' => 'Heifer',
                                                'Cow' => 'Cow',
                                                'Pregnant' => 'Pregnant',
                                                'Calf' => 'Calf',
                                            ])
                                            ->live()
                                            ->label('Status at Purchase'),
                                        Select::make('purchase_pregnancy_type')
                                            ->visible(fn ($get) => $get('acquisition_type') === 'Purchased' && $get('purchase_status') === 'Pregnant')
                                            ->options([
                                                'Inseminated' => 'Inseminated',
                                                'Normal' => 'Normal',
                                            ])
                                            ->label('Pregnancy Type'),
                                        DatePicker::make('purchase_pregnancy_date')
                                            ->visible(fn ($get) => $get('acquisition_type') === 'Purchased' && $get('purchase_status') === 'Pregnant')
                                            ->label('Pregnancy / Insemination Date'),
                                        TextInput::make('purchase_cost')
                                            ->label('Purchase Cost')
                                            ->numeric()
                                            ->prefix('₹')
                                            ->visible(fn ($get) => $get('acquisition_type') === 'Purchased'),
                                        Textarea::make('purchase_notes')
                                            ->label('Additional Notes')
                                            ->columnSpanFull()
                                            ->visible(fn ($get) => $get('acquisition_type') === 'Purchased'),
                                    ]),
                            ]),
                        Tabs\Tab::make('Lineage')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Father (Sire)')
                                            ->schema([
                                                Radio::make('sire_source')
                                                    ->label('Source')
                                                    ->options([
                                                        'Local Bull' => 'Local',
                                                        'Outside' => 'Outside',
                                                        'Insemination' => 'Insemination',
                                                    ])
                                                    ->default('Local Bull')
                                                    ->live()
                                                    ->columns(3),
                                                Select::make('sire_id')
                                                    ->relationship('sire', 'tag_number', fn($query) => $query->where('gender', 'Male'))
                                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->tag_number} - {$record->name}")
                                                    ->searchable()
                                                    ->preload()
                                                    ->label('Select Local Bull')
                                                    ->visible(fn ($get) => $get('sire_source') === 'Local Bull'),
                                                Select::make('sire_semen_stock_id')
                                                    ->label('Select Semen Stock')
                                                    ->relationship('sireSemenStock', 'bull_name')
                                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->full_display_name)
                                                    ->searchable()
                                                    ->preload()
                                                    ->visible(fn ($get) => $get('sire_source') === 'Insemination'),
                                                ...self::getOutsideAncestorSchema('sire', 'Father'),
                                            ])->columnSpan(1),

                                        Section::make('Grand Father (P. Sire)')
                                            ->schema([
                                                Radio::make('p_grand_sire_source')
                                                    ->label('Source')
                                                    ->options([
                                                        'Local Bull' => 'Local',
                                                        'Outside' => 'Outside',
                                                        'Insemination' => 'Insemination',
                                                    ])
                                                    ->default('Local Bull')
                                                    ->live()
                                                    ->columns(3),
                                                Select::make('p_grand_sire_id')
                                                    ->relationship('pGrandSire', 'tag_number', fn($query) => $query->where('gender', 'Male'))
                                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->tag_number} - {$record->name}")
                                                    ->searchable()
                                                    ->preload()
                                                    ->label('Select Local Bull')
                                                    ->visible(fn ($get) => $get('p_grand_sire_source') === 'Local Bull'),
                                                ...self::getOutsideAncestorSchema('p_grand_sire', 'Grand Father'),
                                            ])->columnSpan(1),

                                        Section::make('Mother (Dam)')
                                            ->schema([
                                                Radio::make('dam_source')
                                                    ->label('Source')
                                                    ->options([
                                                        'Local' => 'Local',
                                                        'Outside' => 'Outside',
                                                    ])
                                                    ->default('Local')
                                                    ->live()
                                                    ->columns(2),
                                                Select::make('dam_id')
                                                    ->relationship('dam', 'tag_number', fn($query) => $query->where('gender', 'Female'))
                                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->tag_number} - {$record->name}")
                                                    ->searchable()
                                                    ->preload()
                                                    ->label('Select Local Mother')
                                                    ->visible(fn ($get) => $get('dam_source') === 'Local'),
                                                ...self::getOutsideAncestorSchema('dam', 'Mother'),
                                            ])->columnSpan(1),

                                        Section::make('Grand Mother (M. Dam)')
                                            ->schema([
                                                Radio::make('m_grand_mother_source')
                                                    ->label('Source')
                                                    ->options([
                                                        'Local' => 'Local',
                                                        'Outside' => 'Outside',
                                                    ])
                                                    ->default('Local')
                                                    ->live()
                                                    ->columns(2),
                                                Select::make('m_grand_mother_id')
                                                    ->relationship('mGrandMother', 'tag_number', fn($query) => $query->where('gender', 'Female'))
                                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->tag_number} - {$record->name}")
                                                    ->searchable()
                                                    ->preload()
                                                    ->label('Select Local Grand Mother')
                                                    ->visible(fn ($get) => $get('m_grand_mother_source') === 'Local'),
                                                ...self::getOutsideAncestorSchema('m_grand_mother', 'Grand Mother'),
                                            ])->columnSpan(1),
                                    ]),
                            ]),
                        Tabs\Tab::make('Media')
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->image()
                                    ->disk('public')
                                    ->directory('cows/thumbnails')
                                    ->label('Thumbnail Image'),
                                FileUpload::make('images')
                                    ->image()
                                    ->multiple()
                                    ->disk('public')
                                    ->directory('cows/images')
                                    ->label('Additional Images')
                                    ->reorderable()
                                    ->panelLayout('grid'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    private static function getOutsideAncestorSchema(string $key, string $label): array
    {
        return [
            Grid::make(2)
                ->schema([
                    TextInput::make("external_lineage.{$key}.name")
                        ->label("{$label} Name"),
                    TextInput::make("external_lineage.{$key}.breed")
                        ->label("{$label} Breed"),
                    TextInput::make("external_lineage.{$key}.location")
                        ->label("Location"),
                    TextInput::make("external_lineage.{$key}.age")
                        ->label("Age"),
                    FileUpload::make("external_lineage.{$key}.photo")
                        ->image()
                        ->disk('public')
                        ->directory('cows/lineage')
                        ->label("Photo"),
                    Textarea::make("external_lineage.{$key}.description")
                        ->label("Description")
                        ->columnSpanFull(),
                ])
                ->visible(fn($get) => in_array($get("{$key}_source"), ['Outside', 'Insemination'])),
        ];
    }
}
