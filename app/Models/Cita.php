<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // <--- ESTA LÍNEA ES IMPORTANTE

class Cita extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden llenar masivamente.
     * Hemos añadido 'user_id' para vincular la cita con un barbero.
     */
    protected $fillable = [
        'cliente', 
        'servicio_id', 
        'user_id', 
        'fecha_cita'
    ];

    /**
     * Relación: Una cita pertenece a un Barbero (Usuario).
     * Esto soluciona el error "undefined method user".
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