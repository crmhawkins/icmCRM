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
        Schema::create('seguimiento_piezas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pieza_id')->constrained('piezas')->onDelete('cascade');
            
            // Información básica de la pieza
            $table->string('codigo_pieza');
            $table->string('nombre_pieza');
            $table->text('descripcion')->nullable();
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            
            // TRABAJOS DE PRODUCCIÓN
            $table->decimal('tiempo_produccion_min', 8, 2)->default(0);
            $table->decimal('coste_produccion_unitario', 10, 2)->default(0);
            $table->decimal('coste_produccion_total', 10, 2)->default(0);
            $table->decimal('precio_venta_produccion_unitario', 10, 2)->default(0);
            $table->decimal('beneficio_produccion', 10, 2)->default(0);
            $table->decimal('total_venta_produccion', 10, 2)->default(0);
            
            // TRABAJOS DE CORTE POR LASER - AGUA
            $table->decimal('tiempo_corte_laser_min', 8, 2)->default(0);
            $table->decimal('coste_corte_laser_unitario', 10, 2)->default(0);
            $table->decimal('coste_corte_laser_total', 10, 2)->default(0);
            $table->decimal('precio_venta_corte_laser_unitario', 10, 2)->default(0);
            $table->decimal('beneficio_corte_laser', 10, 2)->default(0);
            $table->decimal('total_venta_corte_laser', 10, 2)->default(0);
            
            // OTROS SERVICIOS
            $table->decimal('cantidad_otros_servicios', 8, 2)->default(0);
            $table->decimal('coste_otros_servicios_unitario', 10, 2)->default(0);
            $table->decimal('coste_otros_servicios_total', 10, 2)->default(0);
            $table->decimal('precio_venta_otros_servicios_unitario', 10, 2)->default(0);
            $table->decimal('beneficio_otros_servicios', 10, 2)->default(0);
            $table->decimal('total_venta_otros_servicios', 10, 2)->default(0);
            $table->string('tipo_otros_servicios')->nullable(); // CHORREADO, ELECTRICIDAD, etc.
            
            // MATERIALES
            $table->decimal('cantidad_materiales', 8, 2)->default(0);
            $table->decimal('coste_materiales_unitario', 10, 2)->default(0);
            $table->decimal('coste_materiales_total', 10, 2)->default(0);
            $table->decimal('precio_venta_materiales_unitario', 10, 2)->default(0);
            $table->decimal('beneficio_materiales', 10, 2)->default(0);
            $table->decimal('total_venta_materiales', 10, 2)->default(0);
            $table->decimal('porcentaje_beneficio_materiales', 5, 2)->default(10);
            
            // CÁLCULO DE MATERIALES
            $table->decimal('cantidad_material_empleado', 8, 2)->default(0);
            $table->string('descripcion_material')->nullable();
            $table->decimal('precio_unitario_material', 10, 2)->default(0);
            $table->decimal('coste_partida_material', 10, 2)->default(0);
            
            // CÁLCULO DE MATERIAL PARA LASER-TUBO
            $table->decimal('metros_tubos', 8, 2)->default(0);
            $table->string('descripcion_tubos')->nullable();
            $table->decimal('precio_metro_tubos', 10, 2)->default(0);
            $table->decimal('coste_partida_tubos', 10, 2)->default(0);
            $table->decimal('total_tubos_empleados', 10, 2)->default(0);
            
            // CÁLCULO DE PRECIOS DE CHAPAS
            $table->decimal('cantidad_chapas', 8, 2)->default(0);
            $table->string('tipo_chapa')->nullable(); // A/C, AISI 304, etc.
            $table->decimal('largo_chapa_mm', 8, 2)->default(0);
            $table->decimal('ancho_chapa_mm', 8, 2)->default(0);
            $table->decimal('espesor_chapa_mm', 8, 2)->default(0);
            $table->string('material_chapa')->nullable();
            $table->decimal('coste_chapa', 10, 2)->default(0);
            $table->decimal('peso_chapa_kg', 8, 3)->default(0);
            $table->decimal('total_chapas_empleadas', 10, 2)->default(0);
            $table->decimal('peso_total_kg', 8, 3)->default(0);
            
            // RESUMEN VENTA
            $table->decimal('coste_produccion_total_resumen', 10, 2)->default(0);
            $table->decimal('precio_venta_total_produccion', 10, 2)->default(0);
            $table->decimal('total_horas_produccion', 8, 2)->default(0);
            $table->decimal('coste_corte_laser_total_resumen', 10, 2)->default(0);
            $table->decimal('precio_venta_total_corte_laser', 10, 2)->default(0);
            $table->decimal('coste_otros_servicios_total_resumen', 10, 2)->default(0);
            $table->decimal('precio_venta_total_otros_servicios', 10, 2)->default(0);
            $table->decimal('coste_materiales_total_resumen', 10, 2)->default(0);
            $table->decimal('precio_venta_total_materiales', 10, 2)->default(0);
            
            // BENEFICIOS
            $table->decimal('beneficio_produccion_porcentaje', 5, 2)->default(0);
            $table->decimal('beneficio_produccion_valor', 10, 2)->default(0);
            $table->decimal('beneficio_corte_porcentaje', 5, 2)->default(0);
            $table->decimal('beneficio_corte_valor', 10, 2)->default(0);
            $table->decimal('beneficio_otros_servicios_porcentaje', 5, 2)->default(0);
            $table->decimal('beneficio_otros_servicios_valor', 10, 2)->default(0);
            $table->decimal('beneficio_materiales_porcentaje', 5, 2)->default(0);
            $table->decimal('beneficio_materiales_valor', 10, 2)->default(0);
            $table->decimal('gastos_financieros_porcentaje', 5, 2)->default(4);
            $table->decimal('gastos_financieros_valor', 10, 2)->default(0);
            $table->decimal('beneficio_teorico_total_porcentaje', 5, 2)->default(0);
            $table->decimal('beneficio_teorico_total_valor', 10, 2)->default(0);
            
            // PRECIOS FINALES
            $table->decimal('precio_venta_teorico_total', 10, 2)->default(0);
            $table->decimal('precio_venta_teorico_unitario', 10, 2)->default(0);
            $table->integer('unidades_valoradas_tabla')->default(0);
            $table->decimal('precio_final_total', 10, 2)->default(0);
            $table->decimal('precio_final_unitario', 10, 2)->default(0);
            $table->decimal('porcentaje_beneficio_facturacion', 5, 2)->default(0);
            $table->decimal('beneficio_tras_facturacion', 10, 2)->default(0);
            $table->decimal('porcentaje_deseado_facturacion', 5, 2)->default(20);
            $table->decimal('precio_aprox_facturar', 10, 2)->default(0);
            
            // Estado y control
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'cancelado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->string('comercial_tecnico')->nullable();
            
            $table->timestamps();
            
            // Índices para búsquedas eficientes
            $table->index('codigo_pieza');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento_piezas');
    }
}; 