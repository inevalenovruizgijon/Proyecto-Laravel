<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\User; 
use Illuminate\Http\Request;
use Carbon\Carbon; // <--- Esto quita el error de la primera imagen

class CitaController extends Controller
{
    /**
     * Muestra la lista de citas filtrada por rol.
     */
    public function index(Request $request)
    {
        // Usar $request->user() evita el error visual de la segunda imagen
        $usuarioLogueado = $request->user();

        if ($usuarioLogueado->role === 'admin') {
            $citas = Cita::with(['servicio', 'user'])->orderBy('fecha_cita', 'asc')->get();
        } else {
            $citas = Cita::where('user_id', $usuarioLogueado->id)
                         ->with('servicio')
                         ->orderBy('fecha_cita', 'asc')
                         ->get();
        }
        
        return view('citas.index', compact('citas'));
    }

    /**
     * Muestra el formulario con los barberos (Público).
     */
    public function create()
    {
        $servicios = Servicio::all();
        $barberos = User::where('role', 'barbero')->get();
        
        return view('citas.create', compact('servicios', 'barberos'));
    }

    /**
     * Guarda la cita con todas las validaciones de horario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'servicio_id' => 'required|exists:servicios,id',
            'user_id' => 'required|exists:users,id',
            'fecha_cita' => 'required',
        ]);

        $fechaCita = Carbon::parse($request->fecha_cita);
        $hora = $fechaCita->format('H:i');

        // --- VALIDACIONES DE HORARIO ---
        if ($fechaCita->isPast()) {
            return back()->withErrors(['fecha_cita' => 'No puedes elegir una fecha pasada.'])->withInput();
        }

        $esHorarioMañana = ($hora >= '09:30' && $hora <= '13:30');
        $esHorarioTarde = ($hora >= '17:30' && $hora <= '20:00');

        if (!$esHorarioMañana && !$esHorarioTarde) {
            return back()->withErrors(['fecha_cita' => "Horario: 9:30-13:30 o 17:30-20:00."])->withInput();
        }

        if ($fechaCita->isWeekend()) {
            return back()->withErrors(['fecha_cita' => 'Cerramos los fines de semana.'])->withInput();
        }

        // --- GUARDADO ---
        Cita::create([
            'cliente' => $request->cliente,
            'servicio_id' => $request->servicio_id,
            'user_id' => $request->user_id,
            'fecha_cita' => $fechaCita,
        ]);

        return redirect()->route('citas.create')->with('success', "¡Cita reservada con éxito!");
    }

    /**
     * Elimina una cita.
     */
    public function destroy(Request $request, Cita $cita)
    {
        $user = $request->user();

        // Seguridad: Solo admin o el barbero dueño de la cita pueden borrarla
        if ($user->role !== 'admin' && $cita->user_id !== $user->id) {
            abort(403, 'No tienes permiso para borrar esta cita.');
        }

        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente.');
    }
}