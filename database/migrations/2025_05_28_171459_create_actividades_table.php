<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade'); 
            $table->foreignId('user_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->timestamp('fecha')->useCurrent();
            $table->bigInteger('tiempo_inicio');
            $table->bigInteger('tiempo_fin');
            $table->bigInteger('duracion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
