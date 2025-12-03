<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();

            // Datos automáticos del usuario
            $table->string('accesor_comercial');
            $table->string('usuario');

            // Datos del establecimiento
            $table->string('nombre_establecimiento');
            $table->string('ciudad_establecimiento');

            // Ubicación (link de Google Maps)
            $table->text('ubicacion')->nullable();

            // Motivo y campo "otro"
            $table->string('motivo');  
            $table->string('otro')->nullable(); // Solo aplica si motivo = "Otro"

            // Foto del establecimiento
            $table->string('foto_establecimiento')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};
