<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servicio extends Model
{
    use HasFactory;

    // IMPORTANTE: Esto permite que Laravel guarde datos en estas columnas
    protected $fillable = ['nombre', 'precio'];

    // RELACIÓN: Un servicio tiene muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}