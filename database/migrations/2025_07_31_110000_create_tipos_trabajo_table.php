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
        Schema::create('tipos_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('codigo', 50)->unique();
            $table->text('descripcion')->nullable();
            $table->integer('orden')->default(0);
            $table->decimal('tiempo_estimado_horas', 8, 2)->default(1.0);
            $table->boolean('requiere_maquinaria')->default(false);
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
        Schema::dropIfExists('tipos_trabajo');
    }
};
