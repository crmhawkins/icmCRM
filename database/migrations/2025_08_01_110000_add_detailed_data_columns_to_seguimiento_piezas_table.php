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
        Schema::table('seguimiento_piezas', function (Blueprint $table) {
            // Agregar columnas JSON para almacenar datos detallados de las tablas dinámicas
            $table->json('datos_produccion')->nullable()->after('precio_subasta_unitario');
            $table->json('datos_laser')->nullable()->after('datos_produccion');
            $table->json('datos_servicios')->nullable()->after('datos_laser');
            $table->json('datos_materiales')->nullable()->after('datos_servicios');
            $table->json('datos_calculo_materiales')->nullable()->after('datos_materiales');
            $table->json('datos_laser_tubo')->nullable()->after('datos_calculo_materiales');
            $table->json('datos_chapas')->nullable()->after('datos_laser_tubo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seguimiento_piezas', function (Blueprint $table) {
            $table->dropColumn([
                'datos_produccion',
                'datos_laser',
                'datos_servicios',
                'datos_materiales',
                'datos_calculo_materiales',
                'datos_laser_tubo',
                'datos_chapas'
            ]);
        });
    }
};
