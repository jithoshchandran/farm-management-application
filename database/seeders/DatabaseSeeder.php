<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bovine.com'],
            [
                'name' => 'Admin',
                'password' => 'password', // The User model 'hashed' cast will handle this
                'role' => 'Admin'
            ]
        );

        $this->call(CowSeeder::class);
    }
}
