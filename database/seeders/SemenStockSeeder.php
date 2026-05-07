<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemenStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SemenStock::create([
            'bull_name' => 'RagBAG',
            'bull_tag' => 'B-001',
            'breed' => 'Holstein',
            'batch_date' => '2023-01-15',
            'collection_date' => '2023-01-10',
            'purchase_date' => '2024-05-20',
            'contact_name' => 'John Doe',
            'contact_location' => 'Global Genetics HQ, UK',
            'contact_phone_1' => '+44 123 456 789',
            'contact_phone_2' => '+44 987 654 321',
            'purchase_cost' => 1500.00,
            'sire_name' => 'King Max',
            'dam_name' => 'Queen Bess',
            'initial_quantity' => 100,
            'remaining_quantity' => 100,
            'notes' => 'High milk production genetics.',
        ]);

        \App\Models\SemenStock::create([
            'bull_name' => 'Thunder',
            'bull_tag' => 'B-042',
            'breed' => 'Jersey',
            'batch_date' => '2023-06-22',
            'collection_date' => '2023-06-18',
            'purchase_date' => '2024-08-10',
            'contact_name' => 'Sarah Smith',
            'contact_location' => 'Sunshine Farm, USA',
            'contact_phone_1' => '+1 555 123 4567',
            'contact_phone_2' => '+1 555 765 4321',
            'purchase_cost' => 800.00,
            'sire_name' => 'Storm',
            'dam_name' => 'Mist',
            'initial_quantity' => 50,
            'remaining_quantity' => 50,
            'notes' => 'Excellent butterfat content.',
        ]);

        \App\Models\SemenStock::create([
            'bull_name' => 'Hercules',
            'bull_tag' => 'B-099',
            'breed' => 'Brahman',
            'batch_date' => '2023-11-05',
            'collection_date' => '2023-10-30',
            'purchase_date' => '2025-01-01',
            'contact_name' => 'Bruce Wayne',
            'contact_location' => 'Tropical Breeders, Australia',
            'contact_phone_1' => '+61 2 9387 1111',
            'contact_phone_2' => '+61 412 111 222',
            'purchase_cost' => 1200.00,
            'sire_name' => 'Atlas',
            'dam_name' => 'Hera',
            'initial_quantity' => 40,
            'remaining_quantity' => 40,
            'notes' => 'Heat resistant and strong growth.',
        ]);
    }
}
