<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importamos el modelo User
use Illuminate\Support\Facades\Hash; // Importamos Hash para la contraseña

class BarberoController extends Controller
{
    /**
     * Muestra la lista de barberos (opcional, por si quieres verlos).
     */
    public function index()
    {
        $barberos = User::where('role', 'barbero')->get();
        return view('admin.barberos.index', compact('barberos'));
    }

    /**
     * Guarda el nuevo barbero en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 2. Creamos el usuario con el rol de 'barbero'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'barbero', // Esto es lo que permite que el cliente lo elija después
        ]);

        // 3. Volvemos atrás con un mensaje de éxito
        return back()->with('success', '¡Nuevo barbero añadido al equipo!');
    }
}