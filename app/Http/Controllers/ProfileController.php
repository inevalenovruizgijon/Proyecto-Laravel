<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon; // IMPORTANTE: Para manejar fechas y horas

class CitaController extends Controller
{
    /**
     * Muestra la lista de todas las citas (Solo para Barberos/Admin).
     */
    public function index()
    {
        $citas = Cita::with('servicio')->orderBy('fecha_cita', 'asc')->get();
        return view('citas.index', compact('citas'));
    }

    /**
     * Muestra el formulario para crear una nueva cita (Público).
     */
    public function create()
    {
        $servicios = Servicio::all();
        return view('citas.create', compact('servicios'));
    }

    /**
     * Guarda la cita con todas las validaciones de negocio.
     */
    public function store(Request $request)
    {
        // 1. Validación básica de campos
        $request->validate([
            'cliente' => 'required|string|max:255',
            'servicio_id' => 'required|exists:servicios,id',
            'fecha_cita' => 'required',
        ]);

        $fechaCita = Carbon::parse($request->fecha_cita);
        $hora = $fechaCita->format('H:i');

        // 2. Validación: No permitir fechas pasadas
        if ($fechaCita->isPast()) {
            return back()->withErrors(['fecha_cita' => 'No puedes pedir una cita en una fecha o hora que ya ha pasado.'])->withInput();
        }

        // 3. Validación: Máximo un año de antelación
        if ($fechaCita->gt(now()->addYear())) {
            return back()->withErrors(['fecha_cita' => 'Solo puedes reservar con un máximo de un año de antelación.'])->withInput();
        }

        // 4. Validación: Horario comercial (9:30-13:30 y 17:30-20:00)
        $esHorarioMañana = ($hora >= '09:30' && $hora <= '13:30');
        $esHorarioTarde = ($hora >= '17:30' && $hora <= '20:00');

        if (!$esHorarioMañana && !$esHorarioTarde) {
            return back()->withErrors(['fecha_cita' => 'La hora seleccionada está fuera del horario: 9:30-13:30 o 17:30-20:00.'])->withInput();
        }

        // 5. Opcional: Bloquear Fines de Semana (Sábado y Domingo)
        if ($fechaCita->isWeekend()) {
            return back()->withErrors(['fecha_cita' => 'Lo sentimos, la barbería está cerrada los fines de semana.'])->withInput();
        }

        // Guardar en la base de datos
        Cita::create([
            'cliente' => $request->cliente,
            'servicio_id' => $request->servicio_id,
            'fecha_cita' => $fechaCita,
        ]);

        // Redirigir de vuelta al formulario con mensaje de éxito (para que no le pida login)
        return redirect()->route('citas.create')->with('success', '¡Tu cita ha sido reservada con éxito!');
    }

    /**
     * Elimina una cita específica.
     */
    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente.');
    }
}