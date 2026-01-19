<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recorridos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);

            $table->date('fecha');
            $table->time('hora');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recorridos');
    }
};

