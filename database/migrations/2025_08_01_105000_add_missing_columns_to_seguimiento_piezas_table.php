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
            // Agregar solo las columnas que faltan para precios de subasta
            $table->decimal('precio_subasta_total', 10, 2)->default(0)->after('precio_aprox_facturar');
            $table->decimal('precio_subasta_unitario', 10, 2)->default(0)->after('precio_subasta_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seguimiento_piezas', function (Blueprint $table) {
            $table->dropColumn([
                'precio_subasta_total',
                'precio_subasta_unitario'
            ]);
        });
    }
};
