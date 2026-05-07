<?php

namespace App\Filament\Resources\Veterinarians\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VeterinarianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('location'),
                TextInput::make('contact_number')
                    ->tel(),
                TextInput::make('whatsapp_number')
                    ->tel()
                    ->label('WhatsApp Number'),
            ]);
    }
}
