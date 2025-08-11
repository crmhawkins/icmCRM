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
        Schema::create('maquinaria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('codigo', 50)->unique();
            $table->string('modelo', 100)->nullable();
            $table->string('fabricante', 100)->nullable();
            $table->integer('ano_fabricacion')->nullable();
            $table->string('numero_serie', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('ubicacion', 100)->nullable();
            $table->enum('estado', ['operativa', 'mantenimiento', 'reparacion', 'inactiva'])->default('operativa');
            $table->decimal('capacidad_maxima', 10, 2)->nullable();
            $table->string('unidad_capacidad', 20)->nullable();
            $table->decimal('velocidad_operacion', 10, 2)->nullable();
            $table->string('unidad_velocidad', 20)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinaria');
    }
};
