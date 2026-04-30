<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Muestra la lista de servicios disponibles (opcional).
     */
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicios.index', compact('servicios'));
    }

    // Los demás métodos los puedes dejar vacíos por ahora si no vas 
    // a crear una pantalla para añadir servicios nuevos desde la web.
}