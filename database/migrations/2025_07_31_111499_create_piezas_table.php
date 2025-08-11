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
        Schema::create('piezas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->string('codigo_pieza', 50);
            $table->string('nombre_pieza', 100);
            $table->text('descripcion')->nullable();
            $table->integer('cantidad')->default(1);
            $table->string('material', 100)->nullable();
            $table->string('acabado', 100)->nullable();
            $table->decimal('dimensiones_largo', 10, 2)->nullable();
            $table->decimal('dimensiones_ancho', 10, 2)->nullable();
            $table->decimal('dimensiones_alto', 10, 2)->nullable();
            $table->string('unidad_medida', 10)->default('mm');
            $table->decimal('peso_unitario', 8, 2)->nullable();
            $table->string('unidad_peso', 10)->default('kg');
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->decimal('precio_total', 12, 2)->nullable();
            $table->text('especificaciones_tecnicas')->nullable();
            $table->text('notas_fabricacion')->nullable();
            $table->enum('estado', [
                'pendiente',
                'en_diseno',
                'en_fabricacion',
                'en_control_calidad',
                'completada',
                'cancelada'
            ])->default('pendiente');
            $table->unsignedBigInteger('tipo_trabajo_id')->nullable();
            $table->unsignedBigInteger('maquinaria_asignada_id')->nullable();
            $table->unsignedBigInteger('usuario_asignado_id')->nullable();
            $table->integer('prioridad')->default(5); // 1-10, donde 10 es máxima prioridad
            $table->datetime('fecha_inicio_estimada')->nullable();
            $table->datetime('fecha_fin_estimada')->nullable();
            $table->datetime('fecha_inicio_real')->nullable();
            $table->datetime('fecha_fin_real')->nullable();
            $table->decimal('tiempo_estimado_horas', 8, 2)->nullable();
            $table->decimal('tiempo_real_horas', 8, 2)->nullable();
            $table->boolean('tiene_plano')->default(false);
            $table->boolean('tiene_daw')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('tipo_trabajo_id')->references('id')->on('tipos_trabajo')->onDelete('set null');
            $table->foreign('maquinaria_asignada_id')->references('id')->on('maquinaria')->onDelete('set null');
            $table->foreign('usuario_asignado_id')->references('id')->on('admin_user')->onDelete('set null');

            // Índices para mejorar el rendimiento
            $table->index(['pedido_id', 'estado']);
            $table->index(['estado', 'prioridad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piezas');
    }
};
