<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('mensaje')->nullable();
            $table->string('tipo', 50)->default('info')->comment('info, warning, success, danger');
            $table->string('accion_url', 500)->nullable()->comment('URL a redirigir al hacer clic');
            $table->string('accion_texto', 100)->nullable()->comment('Texto del boton de accion');
            $table->string('destinatario', 50)->default('estudiante')->comment('estudiante, todos');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
