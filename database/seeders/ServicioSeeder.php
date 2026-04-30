<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Servicio::create(['nombre' => 'Corte Degradado', 'precio' => 15.00]);
    \App\Models\Servicio::create(['nombre' => 'Arreglo de Barba', 'precio' => 10.00]);
    \App\Models\Servicio::create(['nombre' => 'Corte + Barba', 'precio' => 22.00]);
}
}
