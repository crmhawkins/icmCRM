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
        Schema::table('tipos_trabajo', function (Blueprint $table) {
            // Agregar campos para control de tiempo
            if (!Schema::hasColumn('tipos_trabajo', 'tiempo_estimado_horas')) {
                $table->decimal('tiempo_estimado_horas', 8, 2)->default(1.0)->comment('Tiempo estimado en horas');
            }
            if (!Schema::hasColumn('tipos_trabajo', 'requiere_maquinaria')) {
                $table->boolean('requiere_maquinaria')->default(false)->comment('Si requiere maquinaria específica');
            }
            if (!Schema::hasColumn('tipos_trabajo', 'activo')) {
                $table->boolean('activo')->default(true)->comment('Si el tipo de trabajo está activo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipos_trabajo', function (Blueprint $table) {
            $table->dropColumn([
                'tiempo_estimado_horas',
                'requiere_maquinaria',
                'activo'
            ]);
        });
    }
};
