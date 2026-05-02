<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente', 
        'servicio_id', 
        'user_id', 
        'fecha_cita'
    ];

    /**
     * Relación: Una cita pertenece a un Barbero (Usuario).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Una cita pertenece a un Servicio.
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}