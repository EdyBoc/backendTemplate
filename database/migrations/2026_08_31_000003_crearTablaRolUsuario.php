<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rolUsuario', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('usuarioId');
            $table->unsignedBigInteger('rolId');
            $table->unique(['usuarioId', 'rolId']);

            $table->foreign('usuarioId')->references('id')->on('usuarios')->cascadeOnDelete();
            $table->foreign('rolId')->references('id')->on('roles')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rolUsuario');
    }
};
