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
        Schema::create('maquinaria_tipos_trabajo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maquinaria_id');
            $table->unsignedBigInteger('tipo_trabajo_id');
            $table->decimal('eficiencia', 5, 2)->default(100.00);
            $table->integer('tiempo_setup_minutos')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('maquinaria_id')->references('id')->on('maquinaria')->onDelete('cascade');
            $table->foreign('tipo_trabajo_id')->references('id')->on('tipos_trabajo')->onDelete('cascade');
            
            $table->unique(['maquinaria_id', 'tipo_trabajo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinaria_tipos_trabajo');
    }
};
