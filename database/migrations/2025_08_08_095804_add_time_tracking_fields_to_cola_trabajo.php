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
        Schema::table('cola_trabajo', function (Blueprint $table) {
            // Campos para control de tiempos
            if (!Schema::hasColumn('cola_trabajo', 'tiempo_pausado_minutos')) {
                $table->integer('tiempo_pausado_minutos')->default(0)->comment('Tiempo total pausado en minutos');
            }
            if (!Schema::hasColumn('cola_trabajo', 'fecha_ultima_pausa')) {
                $table->datetime('fecha_ultima_pausa')->nullable()->comment('Fecha de la última pausa');
            }
            if (!Schema::hasColumn('cola_trabajo', 'tiempo_acumulado_minutos')) {
                $table->integer('tiempo_acumulado_minutos')->default(0)->comment('Tiempo acumulado trabajado en minutos');
            }
            if (!Schema::hasColumn('cola_trabajo', 'estado_tiempo')) {
                $table->enum('estado_tiempo', ['no_iniciado', 'en_progreso', 'pausado', 'completado'])->default('no_iniciado');
            }
            if (!Schema::hasColumn('cola_trabajo', 'notas_tiempo')) {
                $table->text('notas_tiempo')->nullable()->comment('Notas sobre el tiempo de trabajo');
            }
            if (!Schema::hasColumn('cola_trabajo', 'eficiencia_porcentaje')) {
                $table->decimal('eficiencia_porcentaje', 5, 2)->nullable()->comment('Porcentaje de eficiencia (tiempo estimado vs real)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cola_trabajo', function (Blueprint $table) {
            $table->dropColumn([
                'tiempo_pausado_minutos',
                'fecha_ultima_pausa',
                'tiempo_acumulado_minutos',
                'estado_tiempo',
                'notas_tiempo',
                'eficiencia_porcentaje'
            ]);
        });
    }
};
