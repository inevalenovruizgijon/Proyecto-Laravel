<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BarberoController extends Controller
{
    //Muestra la lista de barberos y el formulario.
    public function index()
    {
        // Obtenemos todos los usuarios que tienen el rol de barbero
        $barberos = User::where('role', 'barbero')->get();

        return view('admin.barberos.index', compact('barberos'));
    }

    //Guarda un nuevo barbero.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'barbero',
        ]);

        return back()->with('success', '¡Barbero añadido correctamente!');
    }
}