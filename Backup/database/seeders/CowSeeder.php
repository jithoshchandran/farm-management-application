<?php

namespace Database\Seeders;

use App\Models\Cow;
use Illuminate\Database\Seeder;

class CowSeeder extends Seeder
{
    public function run()
    {
        // Generation 1 (Grandparents) - 4 records
        $gpSire1 = Cow::create([
            'tag_number' => 'GP-B01', 
            'name' => 'Zeus', 
            'gender' => 'Male', 
            'status' => 'Reference', 
            'dob' => '2015-01-01',
            'breed' => 'Holstein'
        ]);
        
        $gpDam1 = Cow::create([
            'tag_number' => 'GP-C01', 
            'name' => 'Hera', 
            'gender' => 'Female', 
            'status' => 'Reference', 
            'dob' => '2015-02-15',
            'breed' => 'Holstein'
        ]);

        $gpSire2 = Cow::create([
            'tag_number' => 'GP-B02', 
            'name' => 'Thor', 
            'gender' => 'Male', 
            'status' => 'Reference', 
            'dob' => '2015-03-10',
            'breed' => 'Jersey'
        ]);

        $gpDam2 = Cow::create([
            'tag_number' => 'GP-C02', 
            'name' => 'Freya', 
            'gender' => 'Female', 
            'status' => 'Reference', 
            'dob' => '2015-04-20',
            'breed' => 'Jersey'
        ]);

        // Generation 2 (Parents) - 4 records
        $sire1 = Cow::create([
            'tag_number' => 'P-B01', 
            'name' => 'Hercules', 
            'gender' => 'Male', 
            'status' => 'Active', 
            'dob' => '2018-01-01',
            'breed' => 'Holstein',
            'sire_id' => $gpSire1->id,
            'dam_id' => $gpDam1->id
        ]);

        $dam1 = Cow::create([
            'tag_number' => 'P-C01', 
            'name' => 'Athena', 
            'gender' => 'Female', 
            'status' => 'Active', 
            'dob' => '2018-02-15',
            'breed' => 'Holstein',
            'sire_id' => $gpSire1->id,
            'dam_id' => $gpDam1->id
        ]);

        $sire2 = Cow::create([
            'tag_number' => 'P-B02', 
            'name' => 'Odin', 
            'gender' => 'Male', 
            'status' => 'Active', 
            'dob' => '2018-06-01',
            'breed' => 'Jersey',
            'sire_id' => $gpSire2->id,
            'dam_id' => $gpDam2->id
        ]);

        $dam2 = Cow::create([
            'tag_number' => 'P-C02', 
            'name' => 'Frigg', 
            'gender' => 'Female', 
            'status' => 'Active', 
            'dob' => '2018-07-20',
            'breed' => 'Jersey',
            'sire_id' => $gpSire2->id,
            'dam_id' => $gpDam2->id
        ]);

        // Generation 3 (Children/Active Herd) - 2 records + 2 more independent = 12 total to ensure robust data
        // Child 1 (Full Lineage)
        Cow::create([
            'tag_number' => 'HERD-001', 
            'name' => 'Bella', 
            'gender' => 'Female', 
            'status' => 'Active', 
            'dob' => '2021-03-15',
            'breed' => 'Holstein',
            'weight' => 450,
            'milk_production_avg' => 28.5,
            'sire_id' => $sire1->id,
            'dam_id' => $dam2->id // Crossbreed
        ]);

        // Child 2 (Full Lineage)
        Cow::create([
            'tag_number' => 'HERD-002', 
            'name' => 'Luna', 
            'gender' => 'Female', 
            'status' => 'Active', 
            'dob' => '2022-01-10',
            'breed' => 'Jersey',
            'weight' => 380,
            'milk_production_avg' => 22.0,
            'sire_id' => $sire2->id,
            'dam_id' => $dam1->id
        ]);
    }
}
