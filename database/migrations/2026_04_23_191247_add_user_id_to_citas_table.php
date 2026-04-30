<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            // Creamos la columna user_id que conecta con la tabla users
            // La ponemos después de servicio_id para que esté ordenada
            $table->foreignId('user_id')
                  ->after('servicio_id')
                  ->nullable() // Permite que citas antiguas no tengan barbero de momento
                  ->constrained('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            // Eliminamos la relación y la columna si hacemos rollback
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};