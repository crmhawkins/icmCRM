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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_pedido', 50)->unique();
            $table->string('codigo_cliente', 50)->nullable();
            $table->string('nombre_cliente', 100)->nullable();
            $table->date('fecha_pedido')->nullable();
            $table->date('fecha_entrega_estimada')->nullable();
            $table->text('descripcion_general')->nullable();
            $table->integer('total_piezas')->default(0);
            $table->decimal('valor_total', 15, 2)->nullable();
            $table->string('moneda', 10)->default('EUR');
            $table->enum('estado', [
                'pendiente_analisis',
                'analizado',
                'en_proceso',
                'completado',
                'cancelado'
            ])->default('pendiente_analisis');
            $table->text('notas_ia')->nullable(); // Resultado del análisis de IA
            $table->text('notas_manuales')->nullable();
            $table->string('archivo_pdf_original')->nullable(); // Ruta del PDF original
            $table->unsignedBigInteger('usuario_procesador_id')->nullable();
            $table->unsignedBigInteger('proyecto_id')->nullable();
            $table->unsignedBigInteger('presupuesto_id')->nullable();
            $table->boolean('procesado_ia')->default(false);
            $table->datetime('fecha_procesamiento_ia')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('usuario_procesador_id')->references('id')->on('admin_user')->onDelete('set null');
            $table->foreign('proyecto_id')->references('id')->on('projects')->onDelete('set null');
            $table->foreign('presupuesto_id')->references('id')->on('budgets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
