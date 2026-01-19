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
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // Relación con usuarios
            $table->string('vehiculo'); // moto | carro
            $table->date('fecha_inspeccion');
            $table->time('hora_inspeccion');
            $table->string('arranque_realizado');
            $table->string('mensajero');
            $table->string('email')->nullable();
            $table->string('ruta');
            $table->string('ruta_otro')->nullable();
            $table->string('condiciones_conductor');
            $table->string('placa');
            $table->string('placa_otro')->nullable();
            $table->date('vencimiento_soat');
            $table->date('vencimiento_tecnomecanica')->nullable();
            $table->date('vencimiento_licencia');
            $table->integer('kilometraje');
            
            // Equipo de protección personal
            $table->string('uniforme')->nullable();
            $table->string('casco')->nullable();
            $table->string('chaleco')->nullable();
            $table->string('botas')->nullable();
            $table->string('impermeable')->nullable();
            $table->string('cinturon')->nullable();

            // Documentos (array, se guarda como JSON)
            $table->json('documentos')->nullable();

            $table->timestamps();

            // Opcional: llave foránea con usuarios
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecciones');
    }
};
