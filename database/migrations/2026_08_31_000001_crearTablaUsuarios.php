<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table): void {
            $table->id();
            $table->string('nombre', 150);
            $table->string('correoElectronico', 190)->unique();
            $table->string('clave');
            $table->boolean('cambiarClave')->default(true);
            $table->boolean('dobleFactorHabilitado')->default(false);
            $table->text('dobleFactorSecreto')->nullable();
            $table->timestamp('creadoEn')->nullable();
            $table->timestamp('actualizadoEn')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
