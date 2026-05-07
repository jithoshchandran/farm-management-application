<?php

namespace App\Filament\Resources\Cows\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CowInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Details')
                    ->tabs([
                        Tabs\Tab::make('General Details')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('tag_number'),
                                        TextEntry::make('name')
                                            ->placeholder('-'),
                                        TextEntry::make('dob')
                                            ->date(),
                                        TextEntry::make('gender'),
                                        TextEntry::make('status'),
                                        TextEntry::make('breed.name')
                                            ->label('Breed')
                                            ->placeholder('-'),
                                        TextEntry::make('weight')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('milk_production_avg')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('last_calving_date')
                                            ->date()
                                            ->placeholder('-'),
                                        TextEntry::make('breeding_cycle')
                                            ->numeric(),
                                        TextEntry::make('last_heat_date')
                                            ->date()
                                            ->placeholder('-'),
                                        TextEntry::make('next_expected_heat')
                                            ->date()
                                            ->placeholder('-'),
                                        TextEntry::make('created_at')
                                            ->dateTime()
                                            ->placeholder('-'),
                                        TextEntry::make('updated_at')
                                            ->dateTime()
                                            ->placeholder('-'),
                                    ]),
                            ]),
                        Tabs\Tab::make('Acquisition')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('acquisition_type')
                                            ->badge()
                                            ->color('gray'),
                                        TextEntry::make('purchase_date')
                                            ->date()
                                            ->visible(fn ($record) => $record->acquisition_type === 'Purchased'),
                                        TextEntry::make('purchase_from')
                                            ->label('Purchased From')
                                            ->visible(fn ($record) => $record->acquisition_type === 'Purchased'),
                                        TextEntry::make('purchase_age')
                                            ->label('Age at Purchase')
                                            ->visible(fn ($record) => $record->acquisition_type === 'Purchased'),
                                        TextEntry::make('purchase_status')
                                            ->label('Status at Purchase')
                                            ->visible(fn ($record) => $record->acquisition_type === 'Purchased'),
                                        TextEntry::make('purchase_cost')
                                            ->label('Purchase Cost')
                                            ->money('INR')
                                            ->visible(fn ($record) => $record->acquisition_type === 'Purchased'),
                                        TextEntry::make('purchase_pregnancy_type')
                                            ->label('Pregnancy Type')
                                            ->visible(fn ($record) => $record->acquisition_type === 'Purchased' && $record->purchase_status === 'Pregnant'),
                                        TextEntry::make('purchase_pregnancy_date')
                                            ->label('Pregnancy Date')
                                            ->date()
                                            ->visible(fn ($record) => $record->acquisition_type === 'Purchased' && $record->purchase_status === 'Pregnant'),
                                        TextEntry::make('purchase_notes')
                                            ->label('Additional Notes')
                                            ->columnSpanFull()
                                            ->visible(fn ($record) => $record->acquisition_type === 'Purchased'),
                                    ]),
                            ]),
                        Tabs\Tab::make('Lineage')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Father (Sire)')
                                            ->schema([
                                                TextEntry::make('sire_source')
                                                    ->label('Source')
                                                    ->badge()
                                                    ->visible(fn ($record) => $record->sire_source === 'Local Bull' || $record->sire_source === 'Insemination'),
                                                
                                                Grid::make(3)
                                                    ->schema([
                                                        ImageEntry::make('sire.thumbnail')
                                                            ->hiddenLabel()
                                                            ->disk('public')
                                                            ->circular()
                                                            ->height(100)
                                                            ->columnStart(3)
                                                            ->visible(fn ($record) => $record->sire_source === 'Local Bull'),
                                                        TextEntry::make('sire.full_name')
                                                            ->label('Local Sire')
                                                            ->visible(fn ($record) => $record->sire_source === 'Local Bull')
                                                            ->placeholder('-')
                                                            ->columnSpan(2),
                                                    ])
                                                    ->visible(fn ($record) => $record->sire_source === 'Local Bull'),

                                                TextEntry::make('sireSemenStock.full_display_name')
                                                    ->label('Semen Stock')
                                                    ->visible(fn ($record) => $record->sire_source === 'Insemination')
                                                    ->placeholder('-'),
                                                
                                                ...self::getOutsideAncestorInfolistFields('sire', 'Father'),
                                            ])->columnSpan(1),

                                        Section::make('Grand Father (P. Sire)')
                                            ->schema([
                                                TextEntry::make('p_grand_sire_source')
                                                    ->label('Source')
                                                    ->badge()
                                                    ->visible(fn ($record) => $record->p_grand_sire_source === 'Local Bull'),

                                                Grid::make(3)
                                                    ->schema([
                                                        ImageEntry::make('pGrandSire.thumbnail')
                                                            ->hiddenLabel()
                                                            ->disk('public')
                                                            ->circular()
                                                            ->height(100)
                                                            ->columnStart(3)
                                                              ->visible(fn ($record) => $record->p_grand_sire_source === 'Local Bull'),
                                                        TextEntry::make('pGrandSire.full_name')
                                                            ->label('Local Grand Father')
                                                            ->visible(fn ($record) => $record->p_grand_sire_source === 'Local Bull')
                                                            ->placeholder('-')
                                                            ->columnSpan(2),
                                                    ])
                                                    ->visible(fn ($record) => $record->p_grand_sire_source === 'Local Bull'),

                                                ...self::getOutsideAncestorInfolistFields('p_grand_sire', 'Grand Father'),
                                            ])->columnSpan(1),

                                        Section::make('Mother (Dam)')
                                            ->schema([
                                                TextEntry::make('dam_source')
                                                    ->label('Source')
                                                    ->badge()
                                                    ->visible(fn ($record) => $record->dam_source === 'Local'),

                                                Grid::make(3)
                                                    ->schema([
                                                        ImageEntry::make('dam.thumbnail')
                                                            ->hiddenLabel()
                                                            ->disk('public')
                                                            ->circular()
                                                            ->height(100)
                                                            ->columnStart(3)
                                                            ->visible(fn ($record) => $record->dam_source === 'Local'),
                                                        TextEntry::make('dam.full_name')
                                                            ->label('Local Mother')
                                                            ->visible(fn ($record) => $record->dam_source === 'Local')
                                                            ->placeholder('-')
                                                            ->columnSpan(2),
                                                    ])
                                                    ->visible(fn ($record) => $record->dam_source === 'Local'),

                                                ...self::getOutsideAncestorInfolistFields('dam', 'Mother'),
                                            ])->columnSpan(1),

                                        Section::make('Grand Mother (M. Dam)')
                                            ->schema([
                                                TextEntry::make('m_grand_mother_source')
                                                    ->label('Source')
                                                    ->badge()
                                                    ->visible(fn ($record) => $record->m_grand_mother_source === 'Local'),

                                                Grid::make(3)
                                                    ->schema([
                                                        ImageEntry::make('mGrandMother.thumbnail')
                                                            ->hiddenLabel()
                                                            ->disk('public')
                                                            ->circular()
                                                            ->height(100)
                                                            ->columnStart(3)
                                                            ->visible(fn ($record) => $record->m_grand_mother_source === 'Local'),
                                                        TextEntry::make('mGrandMother.full_name')
                                                            ->label('Local Grand Mother')
                                                            ->visible(fn ($record) => $record->m_grand_mother_source === 'Local')
                                                            ->placeholder('-')
                                                            ->columnSpan(2),
                                                    ])
                                                    ->visible(fn ($record) => $record->m_grand_mother_source === 'Local'),

                                                ...self::getOutsideAncestorInfolistFields('m_grand_mother', 'Grand Mother'),
                                            ])->columnSpan(1),
                                    ]),
                            ]),
                        Tabs\Tab::make('Media')
                            ->schema([
                                Section::make('Thumbnail')
                                    ->schema([
                                        ImageEntry::make('thumbnail')
                                            ->disk('public')
                                            ->circular()
                                            ->height(200),
                                    ]),
                                Section::make('Additional Images')
                                    ->schema([
                                        ImageEntry::make('images')
                                            ->disk('public'),
                                    ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    private static function getOutsideAncestorInfolistFields(string $key, string $label): array
    {
        return [
            Grid::make(3)
                ->schema([
                    // First Column
                    Section::make()
                        ->schema([
                            TextEntry::make("{$key}_source")
                                ->label('Source')
                                ->badge(),
                            TextEntry::make("external_lineage.{$key}.name")
                                ->label("Name"),
                        ])
                        ->columnSpan(1),

                    // Second Column
                    Section::make()
                        ->schema([
                            TextEntry::make("external_lineage.{$key}.breed")
                                ->label("Breed"),
                            TextEntry::make("external_lineage.{$key}.age")
                                ->label("Age"),
                        ])
                        ->columnSpan(1),

                    // Third Column (Photo)
                    ImageEntry::make("external_lineage.{$key}.photo")
                        ->hiddenLabel()
                        ->disk('public')
                        ->circular()
                        ->height(120)
                        ->columnSpan(1)
                        ->alignRight(),

                    // Description (Full width of text columns)
                    TextEntry::make("external_lineage.{$key}.description")
                        ->label("Description")
                        ->columnSpan(2),
                ])
                ->visible(fn($record) => in_array($record->{"{$key}_source"}, ['Outside', 'Insemination'])),
        ];
    }
}
