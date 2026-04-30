<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Creamos al Jefe Supremo
    \App\Models\User::create([
        'name' => 'Admin Maestro',
        'email' => 'admin@barberia.com',
        'password' => bcrypt('admin123'), // Tu contraseña para el vídeo
        'role' => 'admin', 
    ]);
}
}
