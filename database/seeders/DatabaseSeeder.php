<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin principal
        User::updateOrCreate(
            ['email' => 'sofia.floristeria.25@gmail.com'], 
            [
                'name' => 'Administrador',
                'password' => Hash::make('fray$sury$admin2026'),
                'role' => 'Admin',
            ]
        );

        // Usuario guest
        User::updateOrCreate(
            ['email' => 'guest@gmail.com'], 
            [
                'name' => 'Guest',
                'password' => Hash::make('guest12345678'),
                'role' => 'Guest',
            ]
        );

        // Llamar otros seeders
        $this->call([
            CategorySeeder::class,
        ]);

        $this->command->info('Usuarios y categorías creados exitosamente!');
    }
}
