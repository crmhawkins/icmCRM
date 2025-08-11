<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Añadir el valor 'en_produccion' al enum de la columna estado
        DB::statement("ALTER TABLE `pedidos` MODIFY COLUMN `estado` ENUM('pendiente_analisis', 'analizado', 'en_proceso', 'en_produccion', 'completado', 'cancelado') DEFAULT 'pendiente_analisis'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el enum a su estado original
        DB::statement("ALTER TABLE `pedidos` MODIFY COLUMN `estado` ENUM('pendiente_analisis', 'analizado', 'en_proceso', 'completado', 'cancelado') DEFAULT 'pendiente_analisis'");
    }
};
