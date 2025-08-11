<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeguimientoPieza extends Model
{
    use HasFactory;

    protected $table = 'seguimiento_piezas';

    protected $fillable = [
        'pieza_id',
        'codigo_pieza',
        'nombre_pieza',
        'descripcion',
        'cantidad',
        'precio_unitario',

        // TRABAJOS DE PRODUCCIÓN
        'tiempo_produccion_min',
        'coste_produccion_unitario',
        'coste_produccion_total',
        'precio_venta_produccion_unitario',
        'beneficio_produccion',
        'total_venta_produccion',

        // TRABAJOS DE CORTE POR LASER - AGUA
        'tiempo_corte_laser_min',
        'coste_corte_laser_unitario',
        'coste_corte_laser_total',
        'precio_venta_corte_laser_unitario',
        'beneficio_corte_laser',
        'total_venta_corte_laser',

        // OTROS SERVICIOS
        'cantidad_otros_servicios',
        'coste_otros_servicios_unitario',
        'coste_otros_servicios_total',
        'precio_venta_otros_servicios_unitario',
        'beneficio_otros_servicios',
        'total_venta_otros_servicios',
        'tipo_otros_servicios',

        // MATERIALES
        'cantidad_materiales',
        'coste_materiales_unitario',
        'coste_materiales_total',
        'precio_venta_materiales_unitario',
        'beneficio_materiales',
        'total_venta_materiales',
        'porcentaje_beneficio_materiales',

        // CÁLCULO DE MATERIALES
        'cantidad_material_empleado',
        'descripcion_material',
        'precio_unitario_material',
        'coste_partida_material',

        // CÁLCULO DE MATERIAL PARA LASER-TUBO
        'metros_tubos',
        'descripcion_tubos',
        'precio_metro_tubos',
        'coste_partida_tubos',
        'total_tubos_empleados',

        // CÁLCULO DE PRECIOS DE CHAPAS
        'cantidad_chapas',
        'tipo_chapa',
        'largo_chapa_mm',
        'ancho_chapa_mm',
        'espesor_chapa_mm',
        'material_chapa',
        'coste_chapa',
        'peso_chapa_kg',
        'total_chapas_empleadas',
        'peso_total_kg',

        // RESUMEN VENTA
        'coste_produccion_total_resumen',
        'precio_venta_total_produccion',
        'total_horas_produccion',
        'coste_corte_laser_total_resumen',
        'precio_venta_total_corte_laser',
        'coste_otros_servicios_total_resumen',
        'precio_venta_total_otros_servicios',
        'coste_materiales_total_resumen',
        'precio_venta_total_materiales',

        // BENEFICIOS
        'beneficio_produccion_porcentaje',
        'beneficio_produccion_valor',
        'beneficio_corte_porcentaje',
        'beneficio_corte_valor',
        'beneficio_otros_servicios_porcentaje',
        'beneficio_otros_servicios_valor',
        'beneficio_materiales_porcentaje',
        'beneficio_materiales_valor',
        'gastos_financieros_porcentaje',
        'gastos_financieros_valor',
        'beneficio_teorico_total_porcentaje',
        'beneficio_teorico_total_valor',

        // PRECIOS FINALES
        'precio_venta_teorico_total',
        'precio_venta_teorico_unitario',
        'unidades_valoradas_tabla',
        'precio_final_total',
        'precio_final_unitario',
        'porcentaje_beneficio_facturacion',
        'beneficio_tras_facturacion',
        'porcentaje_deseado_facturacion',
        'precio_aprox_facturar',
        'precio_subasta_total',
        'precio_subasta_unitario',
        'datos_produccion',
        'datos_laser',
        'datos_servicios',
        'datos_materiales',
        'datos_calculo_materiales',
        'datos_laser_tubo',
        'datos_chapas',

        // Estado y control
        'estado',
        'observaciones',
        'comercial_tecnico',
    ];

    protected $casts = [
        'tiempo_produccion_min' => 'decimal:2',
        'coste_produccion_unitario' => 'decimal:2',
        'coste_produccion_total' => 'decimal:2',
        'precio_venta_produccion_unitario' => 'decimal:2',
        'beneficio_produccion' => 'decimal:2',
        'total_venta_produccion' => 'decimal:2',
        'tiempo_corte_laser_min' => 'decimal:2',
        'coste_corte_laser_unitario' => 'decimal:2',
        'coste_corte_laser_total' => 'decimal:2',
        'precio_venta_corte_laser_unitario' => 'decimal:2',
        'beneficio_corte_laser' => 'decimal:2',
        'total_venta_corte_laser' => 'decimal:2',
        'cantidad_otros_servicios' => 'decimal:2',
        'coste_otros_servicios_unitario' => 'decimal:2',
        'coste_otros_servicios_total' => 'decimal:2',
        'precio_venta_otros_servicios_unitario' => 'decimal:2',
        'beneficio_otros_servicios' => 'decimal:2',
        'total_venta_otros_servicios' => 'decimal:2',
        'cantidad_materiales' => 'decimal:2',
        'coste_materiales_unitario' => 'decimal:2',
        'coste_materiales_total' => 'decimal:2',
        'precio_venta_materiales_unitario' => 'decimal:2',
        'beneficio_materiales' => 'decimal:2',
        'total_venta_materiales' => 'decimal:2',
        'porcentaje_beneficio_materiales' => 'decimal:2',
        'cantidad_material_empleado' => 'decimal:2',
        'precio_unitario_material' => 'decimal:2',
        'coste_partida_material' => 'decimal:2',
        'metros_tubos' => 'decimal:2',
        'precio_metro_tubos' => 'decimal:2',
        'coste_partida_tubos' => 'decimal:2',
        'total_tubos_empleados' => 'decimal:2',
        'cantidad_chapas' => 'decimal:2',
        'largo_chapa_mm' => 'decimal:2',
        'ancho_chapa_mm' => 'decimal:2',
        'espesor_chapa_mm' => 'decimal:2',
        'coste_chapa' => 'decimal:2',
        'peso_chapa_kg' => 'decimal:3',
        'total_chapas_empleadas' => 'decimal:2',
        'peso_total_kg' => 'decimal:3',
        'coste_produccion_total_resumen' => 'decimal:2',
        'precio_venta_total_produccion' => 'decimal:2',
        'total_horas_produccion' => 'decimal:2',
        'coste_corte_laser_total_resumen' => 'decimal:2',
        'precio_venta_total_corte_laser' => 'decimal:2',
        'coste_otros_servicios_total_resumen' => 'decimal:2',
        'precio_venta_total_otros_servicios' => 'decimal:2',
        'coste_materiales_total_resumen' => 'decimal:2',
        'precio_venta_total_materiales' => 'decimal:2',
        'beneficio_produccion_porcentaje' => 'decimal:2',
        'beneficio_produccion_valor' => 'decimal:2',
        'beneficio_corte_porcentaje' => 'decimal:2',
        'beneficio_corte_valor' => 'decimal:2',
        'beneficio_otros_servicios_porcentaje' => 'decimal:2',
        'beneficio_otros_servicios_valor' => 'decimal:2',
        'beneficio_materiales_porcentaje' => 'decimal:2',
        'beneficio_materiales_valor' => 'decimal:2',
        'gastos_financieros_porcentaje' => 'decimal:2',
        'gastos_financieros_valor' => 'decimal:2',
        'beneficio_teorico_total_porcentaje' => 'decimal:2',
        'beneficio_teorico_total_valor' => 'decimal:2',
        'precio_venta_teorico_total' => 'decimal:2',
        'precio_venta_teorico_unitario' => 'decimal:2',
        'precio_final_total' => 'decimal:2',
        'precio_final_unitario' => 'decimal:2',
        'porcentaje_beneficio_facturacion' => 'decimal:2',
        'beneficio_tras_facturacion' => 'decimal:2',
        'porcentaje_deseado_facturacion' => 'decimal:2',
        'precio_aprox_facturar' => 'decimal:2',
        'precio_subasta_total' => 'decimal:2',
        'precio_subasta_unitario' => 'decimal:2',
        'datos_produccion' => 'array',
        'datos_laser' => 'array',
        'datos_servicios' => 'array',
        'datos_materiales' => 'array',
        'datos_calculo_materiales' => 'array',
        'datos_laser_tubo' => 'array',
        'datos_chapas' => 'array',
    ];

    /**
     * Relación con la pieza
     */
    public function pieza(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Models\Produccion\Pieza::class);
    }

    /**
     * Buscar seguimientos anteriores similares para auto-relleno
     */
    public static function buscarSeguimientosSimilares($codigoPieza, $nombrePieza = null)
    {
        $query = self::where('codigo_pieza', $codigoPieza);

        if ($nombrePieza) {
            $query->orWhere('nombre_pieza', 'LIKE', '%' . $nombrePieza . '%');
        }

        return $query->orderBy('created_at', 'desc')->first();
    }

    /**
     * Calcular totales automáticamente
     */
    public function calcularTotales()
    {
        // Calcular costes totales
        $this->coste_produccion_total = $this->tiempo_produccion_min * $this->coste_produccion_unitario / 60;
        $this->coste_corte_laser_total = $this->tiempo_corte_laser_min * $this->coste_corte_laser_unitario / 60;
        $this->coste_otros_servicios_total = $this->cantidad_otros_servicios * $this->coste_otros_servicios_unitario;
        $this->coste_materiales_total = $this->cantidad_materiales * $this->coste_materiales_unitario;

        // Calcular costes de partidas específicas
        $this->coste_partida_material = $this->cantidad_material_empleado * $this->precio_unitario_material;
        $this->coste_partida_tubos = $this->metros_tubos * $this->precio_metro_tubos;
        $this->total_tubos_empleados = $this->coste_partida_tubos;

        // Calcular totales de chapas
        $this->total_chapas_empleadas = $this->cantidad_chapas * $this->coste_chapa;
        $this->peso_total_kg = $this->cantidad_chapas * $this->peso_chapa_kg;

        // Calcular precios de venta (con beneficio)
        $this->precio_venta_produccion_unitario = $this->coste_produccion_unitario * 1.2; // 20% beneficio
        $this->precio_venta_corte_laser_unitario = $this->coste_corte_laser_unitario * 1.33; // 33% beneficio
        $this->precio_venta_otros_servicios_unitario = $this->coste_otros_servicios_unitario * 1.2; // 20% beneficio
        $this->precio_venta_materiales_unitario = $this->coste_materiales_unitario * (1 + $this->porcentaje_beneficio_materiales / 100);

        // Calcular totales de venta
        $this->total_venta_produccion = $this->tiempo_produccion_min * $this->precio_venta_produccion_unitario / 60;
        $this->total_venta_corte_laser = $this->tiempo_corte_laser_min * $this->precio_venta_corte_laser_unitario / 60;
        $this->total_venta_otros_servicios = $this->cantidad_otros_servicios * $this->precio_venta_otros_servicios_unitario;
        $this->total_venta_materiales = $this->cantidad_materiales * $this->precio_venta_materiales_unitario;

        // Calcular beneficios
        $this->beneficio_produccion = $this->total_venta_produccion - $this->coste_produccion_total;
        $this->beneficio_corte_laser = $this->total_venta_corte_laser - $this->coste_corte_laser_total;
        $this->beneficio_otros_servicios = $this->total_venta_otros_servicios - $this->coste_otros_servicios_total;
        $this->beneficio_materiales = $this->total_venta_materiales - $this->coste_materiales_total;

        // Calcular totales del resumen
        $this->coste_produccion_total_resumen = $this->coste_produccion_total;
        $this->precio_venta_total_produccion = $this->total_venta_produccion;
        $this->total_horas_produccion = $this->tiempo_produccion_min / 60;
        $this->coste_corte_laser_total_resumen = $this->coste_corte_laser_total;
        $this->precio_venta_total_corte_laser = $this->total_venta_corte_laser;
        $this->coste_otros_servicios_total_resumen = $this->coste_otros_servicios_total;
        $this->precio_venta_total_otros_servicios = $this->total_venta_otros_servicios;
        $this->coste_materiales_total_resumen = $this->coste_materiales_total;
        $this->precio_venta_total_materiales = $this->total_venta_materiales;

        // Calcular beneficios porcentuales
        $this->beneficio_produccion_porcentaje = $this->coste_produccion_total > 0 ? ($this->beneficio_produccion / $this->coste_produccion_total) * 100 : 0;
        $this->beneficio_corte_porcentaje = $this->coste_corte_laser_total > 0 ? ($this->beneficio_corte_laser / $this->coste_corte_laser_total) * 100 : 0;
        $this->beneficio_otros_servicios_porcentaje = $this->coste_otros_servicios_total > 0 ? ($this->beneficio_otros_servicios / $this->coste_otros_servicios_total) * 100 : 0;
        $this->beneficio_materiales_porcentaje = $this->coste_materiales_total > 0 ? ($this->beneficio_materiales / $this->coste_materiales_total) * 100 : 0;

        // Calcular gastos financieros
        $costeTotal = $this->coste_produccion_total + $this->coste_corte_laser_total + $this->coste_otros_servicios_total + $this->coste_materiales_total;
        $this->gastos_financieros_valor = $costeTotal * ($this->gastos_financieros_porcentaje / 100);

        // Calcular beneficio teórico total
        $beneficioTotal = $this->beneficio_produccion + $this->beneficio_corte_laser + $this->beneficio_otros_servicios + $this->beneficio_materiales - $this->gastos_financieros_valor;
        $this->beneficio_teorico_total_valor = $beneficioTotal;
        $this->beneficio_teorico_total_porcentaje = $costeTotal > 0 ? ($beneficioTotal / $costeTotal) * 100 : 0;

        // Calcular precios finales
        $this->precio_venta_teorico_total = $costeTotal + $beneficioTotal;
        $this->precio_venta_teorico_unitario = $this->cantidad > 0 ? $this->precio_venta_teorico_total / $this->cantidad : 0;
        $this->unidades_valoradas_tabla = $this->cantidad;

        // Calcular precio final con subasta
        $this->precio_final_total = $this->precio_venta_teorico_total * 1.55; // Factor de subasta
        $this->precio_final_unitario = $this->cantidad > 0 ? $this->precio_final_total / $this->cantidad : 0;

        // Calcular beneficio tras facturación
        $this->beneficio_tras_facturacion = $this->precio_final_total - $costeTotal;
        $this->porcentaje_beneficio_facturacion = $costeTotal > 0 ? ($this->beneficio_tras_facturacion / $costeTotal) * 100 : 0;

        // Calcular precio aproximado para facturar
        $this->precio_aprox_facturar = $costeTotal * (1 + $this->porcentaje_deseado_facturacion / 100);
    }
}
