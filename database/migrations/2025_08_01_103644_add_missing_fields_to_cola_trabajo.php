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
            // Agregar campos que faltan
            if (!Schema::hasColumn('cola_trabajo', 'descripcion_trabajo')) {
                $table->string('descripcion_trabajo', 255)->nullable();
            }
            if (!Schema::hasColumn('cola_trabajo', 'especificaciones')) {
                $table->text('especificaciones')->nullable();
            }
            if (!Schema::hasColumn('cola_trabajo', 'cantidad_piezas')) {
                $table->integer('cantidad_piezas')->default(1);
            }
            if (!Schema::hasColumn('cola_trabajo', 'tiempo_real_horas')) {
                $table->decimal('tiempo_real_horas', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('cola_trabajo', 'fecha_inicio_real')) {
                $table->datetime('fecha_inicio_real')->nullable();
            }
            if (!Schema::hasColumn('cola_trabajo', 'fecha_fin_real')) {
                $table->datetime('fecha_fin_real')->nullable();
            }
            if (!Schema::hasColumn('cola_trabajo', 'codigo_trabajo')) {
                $table->string('codigo_trabajo', 50)->nullable();
            }
            if (!Schema::hasColumn('cola_trabajo', 'pieza_id')) {
                $table->unsignedBigInteger('pieza_id')->nullable();
                $table->foreign('pieza_id')->references('id')->on('piezas')->onDelete('cascade');
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
                'descripcion_trabajo',
                'especificaciones',
                'cantidad_piezas',
                'tiempo_real_horas',
                'fecha_inicio_real',
                'fecha_fin_real',
                'codigo_trabajo',
                'pieza_id'
            ]);
        });
    }
};
