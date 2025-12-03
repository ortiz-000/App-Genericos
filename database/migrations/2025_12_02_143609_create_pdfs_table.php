<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // nombre del archivo o descripción
            $table->string('ruta'); // path del PDF en storage
            $table->unsignedBigInteger('empleado_id'); // asignado al usuario
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pdfs');
    }
};
