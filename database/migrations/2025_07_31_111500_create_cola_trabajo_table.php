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
        Schema::create('cola_trabajo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('pieza_id')->nullable();
            $table->unsignedBigInteger('tipo_trabajo_id')->nullable();
            $table->unsignedBigInteger('maquinaria_id')->nullable();
            $table->unsignedBigInteger('usuario_asignado_id')->nullable();
            $table->string('estado', 50)->default('pendiente');
            $table->integer('prioridad')->default(5);
            $table->decimal('tiempo_estimado_horas', 8, 2)->nullable();
            $table->decimal('tiempo_real_horas', 8, 2)->nullable();
            $table->datetime('fecha_inicio_estimada')->nullable();
            $table->datetime('fecha_fin_estimada')->nullable();
            $table->datetime('fecha_inicio_real')->nullable();
            $table->datetime('fecha_fin_real')->nullable();
            $table->text('descripcion_trabajo')->nullable();
            $table->text('especificaciones')->nullable();
            $table->integer('cantidad_piezas')->default(1);
            $table->string('codigo_trabajo', 50)->nullable();
            $table->text('notas')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('pieza_id')->references('id')->on('piezas')->onDelete('cascade');
            $table->foreign('tipo_trabajo_id')->references('id')->on('tipos_trabajo')->onDelete('set null');
            $table->foreign('maquinaria_id')->references('id')->on('maquinaria')->onDelete('set null');
            $table->foreign('usuario_asignado_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cola_trabajo');
    }
};
