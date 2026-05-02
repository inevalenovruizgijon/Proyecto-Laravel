<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\Admin\BarberoController;
use Illuminate\Support\Facades\Route;

/*
| ZONA PÚBLICA: Para Clientes (Sin Login)
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/citas/create', [CitaController::class, 'create'])->name('citas.create');
Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');


/*
ZONA PRIVADA: Solo para Barbero Master y Empleados (Con Login)
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [CitaController::class, 'index'])->name('dashboard');
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');

    Route::delete('/citas/{cita}', [CitaController::class, 'destroy'])->name('citas.destroy');

    // Gestión de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | SOLO ADMIN
    */
    Route::middleware(['can:admin-only'])->group(function () {
        Route::get('/admin/barberos', [BarberoController::class, 'index'])->name('admin.barberos.index');
        Route::post('/admin/barberos', [BarberoController::class, 'store'])->name('admin.barberos.store');
    });
});

require __DIR__.'/auth.php';