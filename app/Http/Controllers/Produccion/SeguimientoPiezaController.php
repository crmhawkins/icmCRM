<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Models\Produccion\Pieza;
use App\Models\Produccion\SeguimientoPieza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeguimientoPiezaController extends Controller
{
    /**
     * Mostrar el formulario de seguimiento para una pieza
     */
    public function show($piezaId)
    {
        $pieza = Pieza::with('pedido')->findOrFail($piezaId);

        // Buscar si ya existe un seguimiento para esta pieza
        $seguimiento = SeguimientoPieza::where('pieza_id', $piezaId)->first();

        if (!$seguimiento) {
            // Crear un nuevo seguimiento vacío con datos básicos de la pieza
            $seguimiento = new SeguimientoPieza();
            $seguimiento->pieza_id = $pieza->id;
            $seguimiento->codigo_pieza = $pieza->codigo_pieza;
            $seguimiento->nombre_pieza = $pieza->nombre_pieza;
            $seguimiento->descripcion = $pieza->descripcion;
            $seguimiento->cantidad = $pieza->cantidad;
            $seguimiento->precio_unitario = $pieza->precio_unitario;

            // Establecer valores mínimos por defecto solo para campos obligatorios
            $seguimiento->unidades_valoradas_tabla = 1;
            $seguimiento->gastos_financieros_porcentaje = 4.00;
            $seguimiento->porcentaje_deseado_facturacion = 15.00;
            $seguimiento->estado = 'pendiente';

            // NO establecer valores por defecto para costes y precios
            // Dejar que el usuario los introduzca desde cero
        }

        // Preparar datos para las tablas dinámicas
        $datosTablas = $this->prepararDatosTablas($seguimiento);

        return view('produccion.seguimiento-pieza.show', compact('pieza', 'seguimiento', 'datosTablas'));
    }

    /**
     * Guardar o actualizar el seguimiento de una pieza
     */
    public function store(Request $request, $piezaId)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,completado,cancelado',
            'observaciones' => 'nullable|string',
            'comercial_tecnico' => 'nullable|string|max:255',
            'gastos_financieros_porcentaje' => 'nullable|numeric|min:0|max:100',
            'porcentaje_deseado_facturacion' => 'nullable|numeric|min:0|max:100',
            'unidades_valoradas_tabla' => 'nullable|numeric|min:1',
            'precio_subasta_total' => 'nullable|numeric|min:0',
        ]);

        $pieza = Pieza::findOrFail($piezaId);

        // Buscar o crear el seguimiento
        $seguimiento = SeguimientoPieza::where('pieza_id', $piezaId)->first();

        if (!$seguimiento) {
            $seguimiento = new SeguimientoPieza();
            $seguimiento->pieza_id = $pieza->id;
            $seguimiento->codigo_pieza = $pieza->codigo_pieza;
            $seguimiento->nombre_pieza = $pieza->nombre_pieza;
            $seguimiento->descripcion = $pieza->descripcion;
            $seguimiento->cantidad = $pieza->cantidad;
            $seguimiento->precio_unitario = $pieza->precio_unitario;
        }

        // Actualizar campos básicos
        $seguimiento->estado = $request->estado;
        $seguimiento->observaciones = $request->observaciones;
        $seguimiento->comercial_tecnico = $request->comercial_tecnico;
        $seguimiento->gastos_financieros_porcentaje = $request->gastos_financieros_porcentaje ?? 4.00;
        $seguimiento->porcentaje_deseado_facturacion = $request->porcentaje_deseado_facturacion ?? 15.00;
        $seguimiento->unidades_valoradas_tabla = $request->unidades_valoradas_tabla ?? 1;
        $seguimiento->precio_subasta_total = $request->precio_subasta_total ?? 0;

        // Procesar datos de las tablas dinámicas
        $this->procesarDatosTablas($request, $seguimiento);

        // Calcular totales automáticamente
        $seguimiento->calcularTotales();

        $seguimiento->save();

        return redirect()->route('seguimiento-pieza.show', $piezaId)
            ->with('success', 'Seguimiento guardado correctamente.');
    }

    /**
     * Procesar datos de las tablas dinámicas
     */
    private function procesarDatosTablas(Request $request, SeguimientoPieza $seguimiento)
    {
        // Procesar tabla de producción
        $trabajos = $request->input('trabajo', []);
        $minutos = $request->input('minutos', []);
        $costeUnitario = $request->input('coste_unitario', []);
        $precioVenta = $request->input('precio_venta', []);

        $totalTiempoProduccion = 0;
        $totalCosteProduccion = 0;
        $totalVentaProduccion = 0;

        foreach ($trabajos as $index => $trabajo) {
            if (!empty($trabajo) && isset($minutos[$index]) && isset($costeUnitario[$index])) {
                $min = floatval($minutos[$index]);
                $coste = floatval($costeUnitario[$index]);
                $venta = floatval($precioVenta[$index] ?? $coste * 1.2);

                $totalTiempoProduccion += $min;
                $totalCosteProduccion += ($coste * $min) / 60;
                $totalVentaProduccion += ($venta * $min) / 60;
            }
        }

        $seguimiento->tiempo_produccion_min = $totalTiempoProduccion;
        $seguimiento->coste_produccion_unitario = $totalTiempoProduccion > 0 ? ($totalCosteProduccion * 60) / $totalTiempoProduccion : 0;
        $seguimiento->coste_produccion_total = $totalCosteProduccion;
        $seguimiento->total_venta_produccion = $totalVentaProduccion;

        // Guardar datos detallados de producción
        $datosProduccion = [];
        foreach ($trabajos as $index => $trabajo) {
            if (!empty($trabajo) && isset($minutos[$index]) && isset($costeUnitario[$index])) {
                $datosProduccion[] = [
                    'trabajo' => $trabajo,
                    'minutos' => floatval($minutos[$index]),
                    'coste_unitario' => floatval($costeUnitario[$index]),
                    'precio_venta' => floatval($precioVenta[$index] ?? $costeUnitario[$index] * 1.2),
                ];
            }
        }
        $seguimiento->datos_produccion = $datosProduccion;

        // Procesar tabla de láser
        $materialesLaser = $request->input('material_laser', []);
        $minutosLaser = $request->input('minutos_laser', []);
        $costeUnitarioLaser = $request->input('coste_unitario_laser', []);
        $precioVentaLaser = $request->input('precio_venta_laser', []);

        $totalTiempoLaser = 0;
        $totalCosteLaser = 0;
        $totalVentaLaser = 0;

        foreach ($materialesLaser as $index => $material) {
            if (!empty($material) && isset($minutosLaser[$index]) && isset($costeUnitarioLaser[$index])) {
                $min = floatval($minutosLaser[$index]);
                $coste = floatval($costeUnitarioLaser[$index]);
                $venta = floatval($precioVentaLaser[$index] ?? $coste * 1.33);

                $totalTiempoLaser += $min;
                $totalCosteLaser += $coste * $min;
                $totalVentaLaser += $venta * $min;
            }
        }

        $seguimiento->tiempo_corte_laser_min = $totalTiempoLaser;
        $seguimiento->coste_corte_laser_unitario = $totalTiempoLaser > 0 ? $totalCosteLaser / $totalTiempoLaser : 0;
        $seguimiento->coste_corte_laser_total = $totalCosteLaser;
        $seguimiento->total_venta_corte_laser = $totalVentaLaser;

        // Guardar datos detallados de láser
        $datosLaser = [];
        foreach ($materialesLaser as $index => $material) {
            if (!empty($material) && isset($minutosLaser[$index]) && isset($costeUnitarioLaser[$index])) {
                $datosLaser[] = [
                    'material' => $material,
                    'minutos' => floatval($minutosLaser[$index]),
                    'coste_unitario' => floatval($costeUnitarioLaser[$index]),
                    'precio_venta' => floatval($precioVentaLaser[$index] ?? $costeUnitarioLaser[$index] * 1.33),
                ];
            }
        }
        $seguimiento->datos_laser = $datosLaser;

        // Procesar tabla de otros servicios
        $servicios = $request->input('servicio', []);
        $categoriasServicio = $request->input('categoria_servicio', []);
        $cantidadesServicios = $request->input('cantidad_servicios', []);
        $costeUnitarioServicios = $request->input('coste_unitario_servicios', []);
        $precioVentaServicios = $request->input('precio_venta_servicios', []);

        $totalCosteServicios = 0;
        $totalVentaServicios = 0;

        foreach ($servicios as $index => $servicio) {
            if (!empty($servicio) && isset($cantidadesServicios[$index]) && isset($costeUnitarioServicios[$index])) {
                $cantidad = floatval($cantidadesServicios[$index]);
                $coste = floatval($costeUnitarioServicios[$index]);
                $venta = floatval($precioVentaServicios[$index] ?? $coste * 1.2);

                $totalCosteServicios += $coste * $cantidad;
                $totalVentaServicios += $venta * $cantidad;
            }
        }

        // También procesar categorías de servicio
        foreach ($categoriasServicio as $index => $categoria) {
            if (!empty($categoria) && $categoria !== 'SUBCONTRATACION' && isset($cantidadesServicios[$index]) && isset($costeUnitarioServicios[$index])) {
                $cantidad = floatval($cantidadesServicios[$index]);
                $coste = floatval($costeUnitarioServicios[$index]);
                $venta = floatval($precioVentaServicios[$index] ?? $coste * 1.2);

                $totalCosteServicios += $coste * $cantidad;
                $totalVentaServicios += $venta * $cantidad;
            }
        }

        $seguimiento->coste_otros_servicios_total = $totalCosteServicios;
        $seguimiento->total_venta_otros_servicios = $totalVentaServicios;

        // Guardar datos detallados de servicios
        $datosServicios = [];
        foreach ($servicios as $index => $servicio) {
            if (!empty($servicio) && isset($cantidadesServicios[$index]) && isset($costeUnitarioServicios[$index])) {
                $datosServicios[] = [
                    'servicio' => $servicio,
                    'cantidad' => floatval($cantidadesServicios[$index]),
                    'coste_unitario' => floatval($costeUnitarioServicios[$index]),
                    'precio_venta' => floatval($precioVentaServicios[$index] ?? $costeUnitarioServicios[$index] * 1.2),
                ];
            }
        }
        $seguimiento->datos_servicios = $datosServicios;

        // Procesar tabla de materiales
        $materiales = $request->input('material', []);
        $categoriasMaterial = $request->input('categoria_material', []);
        $cantidadesMateriales = $request->input('cantidad_materiales', []);
        $costeUnitarioMateriales = $request->input('coste_unitario_materiales', []);
        $precioVentaMateriales = $request->input('precio_venta_materiales', []);

        $totalCosteMateriales = 0;
        $totalVentaMateriales = 0;

        foreach ($materiales as $index => $material) {
            if (!empty($material) && isset($cantidadesMateriales[$index]) && isset($costeUnitarioMateriales[$index])) {
                $cantidad = floatval($cantidadesMateriales[$index]);
                $coste = floatval($costeUnitarioMateriales[$index]);
                $venta = floatval($precioVentaMateriales[$index] ?? $coste * 1.1);

                $totalCosteMateriales += $coste * $cantidad;
                $totalVentaMateriales += $venta * $cantidad;
            }
        }

        // También procesar categorías de material
        foreach ($categoriasMaterial as $index => $categoria) {
            if (!empty($categoria) && isset($cantidadesMateriales[$index]) && isset($costeUnitarioMateriales[$index])) {
                $cantidad = floatval($cantidadesMateriales[$index]);
                $coste = floatval($costeUnitarioMateriales[$index]);
                $venta = floatval($precioVentaMateriales[$index] ?? $coste * 1.1);

                $totalCosteMateriales += $coste * $cantidad;
                $totalVentaMateriales += $venta * $cantidad;
            }
        }

        $seguimiento->coste_materiales_total = $totalCosteMateriales;
        $seguimiento->total_venta_materiales = $totalVentaMateriales;

        // Guardar datos detallados de materiales
        $datosMateriales = [];
        foreach ($materiales as $index => $material) {
            if (!empty($material) && isset($cantidadesMateriales[$index]) && isset($costeUnitarioMateriales[$index])) {
                $datosMateriales[] = [
                    'material' => $material,
                    'cantidad' => floatval($cantidadesMateriales[$index]),
                    'coste_unitario' => floatval($costeUnitarioMateriales[$index]),
                    'precio_venta' => floatval($precioVentaMateriales[$index] ?? $costeUnitarioMateriales[$index] * 1.1),
                ];
            }
        }
        $seguimiento->datos_materiales = $datosMateriales;

        // Procesar tabla de cálculo de materiales
        $cantidadesMaterialEmpleado = $request->input('cantidad_material_empleado', []);
        $descripcionesMaterial = $request->input('descripcion_material', []);
        $preciosUnitarioMaterial = $request->input('precio_unitario_material', []);

        $totalCostePartidaMaterial = 0;

        foreach ($cantidadesMaterialEmpleado as $index => $cantidad) {
            if (!empty($cantidad) && isset($preciosUnitarioMaterial[$index])) {
                $cant = floatval($cantidad);
                $precio = floatval($preciosUnitarioMaterial[$index]);

                $totalCostePartidaMaterial += $cant * $precio;
            }
        }

        $seguimiento->coste_partida_material = $totalCostePartidaMaterial;

        // Guardar datos detallados de cálculo de materiales
        $datosCalculoMateriales = [];
        foreach ($cantidadesMaterialEmpleado as $index => $cantidad) {
            if (!empty($cantidad) && isset($preciosUnitarioMaterial[$index])) {
                $datosCalculoMateriales[] = [
                    'cantidad' => floatval($cantidad),
                    'descripcion' => $descripcionesMaterial[$index] ?? 'Material',
                    'precio_unitario' => floatval($preciosUnitarioMaterial[$index]),
                ];
            }
        }
        $seguimiento->datos_calculo_materiales = $datosCalculoMateriales;

        // Procesar tabla de láser-tubo
        $metrosTubos = $request->input('metros_tubos', []);
        $descripcionesTubos = $request->input('descripcion_tubos', []);
        $preciosMetroTubos = $request->input('precio_metro_tubos', []);

        $totalTubosEmpleados = 0;

        foreach ($metrosTubos as $index => $metros) {
            if (!empty($metros) && isset($preciosMetroTubos[$index])) {
                $m = floatval($metros);
                $precio = floatval($preciosMetroTubos[$index]);

                $totalTubosEmpleados += $m * $precio;
            }
        }

        $seguimiento->total_tubos_empleados = $totalTubosEmpleados;

        // Guardar datos detallados de láser-tubo
        $datosLaserTubo = [];
        foreach ($metrosTubos as $index => $metros) {
            if (!empty($metros) && isset($preciosMetroTubos[$index])) {
                $datosLaserTubo[] = [
                    'metros' => floatval($metros),
                    'descripcion' => $descripcionesTubos[$index] ?? 'Tubo',
                    'precio_metro' => floatval($preciosMetroTubos[$index]),
                ];
            }
        }
        $seguimiento->datos_laser_tubo = $datosLaserTubo;

        // Procesar tabla de chapas
        $cantidadesChapas = $request->input('cantidad_chapas', []);
        $materialesChapa = $request->input('material_chapa', []);
        $largosChapa = $request->input('largo_chapa_mm', []);
        $anchosChapa = $request->input('ancho_chapa_mm', []);
        $espesoresChapa = $request->input('espesor_chapa_mm', []);

        $totalChapasEmpleadas = 0;
        $pesoTotalKg = 0;

        foreach ($cantidadesChapas as $index => $cantidad) {
            if (!empty($cantidad) && isset($materialesChapa[$index]) && isset($largosChapa[$index]) && isset($anchosChapa[$index]) && isset($espesoresChapa[$index])) {
                $cant = floatval($cantidad);
                $material = $materialesChapa[$index];
                $largo = floatval($largosChapa[$index]);
                $ancho = floatval($anchosChapa[$index]);
                $espesor = floatval($espesoresChapa[$index]);

                // Calcular peso y coste según el material
                $peso = $this->calcularPesoChapa($material, $largo, $ancho, $espesor);
                $coste = $this->calcularCosteChapa($material, $peso);

                $totalChapasEmpleadas += $cant * $coste;
                $pesoTotalKg += $cant * $peso;
            }
        }

        $seguimiento->total_chapas_empleadas = $totalChapasEmpleadas;
        $seguimiento->peso_total_kg = $pesoTotalKg;

        // Guardar datos detallados de chapas
        $datosChapas = [];
        foreach ($cantidadesChapas as $index => $cantidad) {
            if (!empty($cantidad) && isset($materialesChapa[$index]) && isset($largosChapa[$index]) && isset($anchosChapa[$index]) && isset($espesoresChapa[$index])) {
                $material = $materialesChapa[$index];
                $largo = floatval($largosChapa[$index]);
                $ancho = floatval($anchosChapa[$index]);
                $espesor = floatval($espesoresChapa[$index]);
                
                // Calcular peso y coste
                $peso = $this->calcularPesoChapa($material, $largo, $ancho, $espesor);
                $coste = $this->calcularCosteChapa($material, $peso);
                
                $datosChapas[] = [
                    'cantidad' => floatval($cantidad),
                    'material' => $material,
                    'largo' => $largo,
                    'ancho' => $ancho,
                    'espesor' => $espesor,
                    'peso' => $peso,
                    'coste' => $coste,
                    'total' => floatval($cantidad) * $coste,
                ];
            }
        }
        $seguimiento->datos_chapas = $datosChapas;
    }

    /**
     * Preparar datos para las tablas dinámicas
     */
    private function prepararDatosTablas(SeguimientoPieza $seguimiento)
    {
        $datos = [
            'produccion' => [],
            'laser' => [],
            'servicios' => [],
            'materiales' => [],
            'calculo_materiales' => [],
            'laser_tubo' => [],
            'chapas' => [],
        ];

        // Si el seguimiento tiene datos, los preparamos para mostrar
        if ($seguimiento->id) {
            // Usar datos detallados guardados en lugar de crear representaciones simplificadas
            if (!empty($seguimiento->datos_produccion)) {
                $datos['produccion'] = $seguimiento->datos_produccion;
            }

            if (!empty($seguimiento->datos_laser)) {
                $datos['laser'] = $seguimiento->datos_laser;
            }

            if (!empty($seguimiento->datos_servicios)) {
                $datos['servicios'] = $seguimiento->datos_servicios;
            }

            if (!empty($seguimiento->datos_materiales)) {
                $datos['materiales'] = $seguimiento->datos_materiales;
            }

            if (!empty($seguimiento->datos_calculo_materiales)) {
                $datos['calculo_materiales'] = $seguimiento->datos_calculo_materiales;
            }

            if (!empty($seguimiento->datos_laser_tubo)) {
                $datos['laser_tubo'] = $seguimiento->datos_laser_tubo;
            }

            if (!empty($seguimiento->datos_chapas)) {
                $datos['chapas'] = $seguimiento->datos_chapas;
            }
        }

        // Agregar datos para filas automáticas de materiales
        $datos['filas_automaticas_materiales'] = [];
        
        // Verificar si hay datos de cálculo de materiales o láser-tubo para crear "RESTO DE MATERIA PRIMA Y TUBOS"
        if ($seguimiento->coste_partida_material > 0 || $seguimiento->total_tubos_empleados > 0) {
            $datos['filas_automaticas_materiales'][] = 'RESTO DE MATERIA PRIMA Y TUBOS';
        }
        
        // Verificar si hay datos de chapas para crear "CHAPAS (TABLA CHAPAS)"
        if ($seguimiento->total_chapas_empleadas > 0) {
            $datos['filas_automaticas_materiales'][] = 'CHAPAS (TABLA CHAPAS)';
        }
        
        return $datos;
    }

    /**
     * Calcular peso de chapa según material y dimensiones
     */
    private function calcularPesoChapa($material, $largo, $ancho, $espesor)
    {
        $densidadFactores = [
            'A/C' => 8,
            'AISI 304' => 8,
            'AISI 316' => 8,
            'ALUMINIO' => 2.7,
            'ANODIZADO' => 2.7,
            'AISI 304 BRILLO' => 8,
            'AISI 304 SATIN' => 8,
            'AISI 316 BRI SAT' => 8,
            'ALUMINIO PALILLOS' => 2.7,
            'DAMERO ITURRI (ALUMINIO)' => 2.7,
            'ALUMINIO TOP-GRIP' => 2.7,
            'GALVANIZADO' => 8
        ];

        $densidadFactor = $densidadFactores[$material] ?? 8;
        return ($largo / 1000) * ($ancho / 1000) * $espesor * $densidadFactor;
    }

    /**
     * Calcular coste de chapa según material y peso
     */
    private function calcularCosteChapa($material, $peso)
    {
        $preciosPorKg = [
            'A/C' => 1.35,
            'AISI 304' => 3.20,
            'AISI 316' => 4.75,
            'ALUMINIO' => 4.90,
            'ANODIZADO' => 7.30,
            'AISI 304 BRILLO' => 3.99,
            'AISI 304 SATIN' => 3.68,
            'AISI 316 BRI SAT' => 5.40,
            'ALUMINIO PALILLOS' => 5.78,
            'DAMERO ITURRI (ALUMINIO)' => 6.28,
            'ALUMINIO TOP-GRIP' => 6.02,
            'GALVANIZADO' => 1.45
        ];

        $precioPorKg = $preciosPorKg[$material] ?? 1.35;
        return $peso * $precioPorKg;
    }

    /**
     * Calcular totales en tiempo real (AJAX)
     */
    public function calcularTotales(Request $request)
    {
        $seguimiento = new SeguimientoPieza();
        $seguimiento->fill($request->all());
        $seguimiento->calcularTotales();

        return response()->json([
            'coste_produccion_total' => number_format($seguimiento->coste_produccion_total, 2),
            'total_venta_produccion' => number_format($seguimiento->total_venta_produccion, 2),
            'beneficio_produccion' => number_format($seguimiento->beneficio_produccion, 2),
            'coste_corte_laser_total' => number_format($seguimiento->coste_corte_laser_total, 2),
            'total_venta_corte_laser' => number_format($seguimiento->total_venta_corte_laser, 2),
            'beneficio_corte_laser' => number_format($seguimiento->beneficio_corte_laser, 2),
            'coste_otros_servicios_total' => number_format($seguimiento->coste_otros_servicios_total, 2),
            'total_venta_otros_servicios' => number_format($seguimiento->total_venta_otros_servicios, 2),
            'beneficio_otros_servicios' => number_format($seguimiento->beneficio_otros_servicios, 2),
            'coste_materiales_total' => number_format($seguimiento->coste_materiales_total, 2),
            'total_venta_materiales' => number_format($seguimiento->total_venta_materiales, 2),
            'beneficio_materiales' => number_format($seguimiento->beneficio_materiales, 2),
            'total_chapas_empleadas' => number_format($seguimiento->total_chapas_empleadas, 2),
            'peso_total_kg' => number_format($seguimiento->peso_total_kg, 3),
            'total_tubos_empleados' => number_format($seguimiento->total_tubos_empleados, 2),
            'coste_partida_material' => number_format($seguimiento->coste_partida_material, 2),
            'coste_partida_tubos' => number_format($seguimiento->coste_partida_tubos, 2),
            'beneficio_teorico_total_valor' => number_format($seguimiento->beneficio_teorico_total_valor, 2),
            'beneficio_teorico_total_porcentaje' => number_format($seguimiento->beneficio_teorico_total_porcentaje, 2),
            'precio_venta_teorico_total' => number_format($seguimiento->precio_venta_teorico_total, 2),
            'precio_venta_teorico_unitario' => number_format($seguimiento->precio_venta_teorico_unitario, 2),
            'precio_final_total' => number_format($seguimiento->precio_final_total, 2),
            'precio_final_unitario' => number_format($seguimiento->precio_final_unitario, 2),
            'beneficio_tras_facturacion' => number_format($seguimiento->beneficio_tras_facturacion, 2),
            'porcentaje_beneficio_facturacion' => number_format($seguimiento->porcentaje_beneficio_facturacion, 2),
            'precio_aprox_facturar' => number_format($seguimiento->precio_aprox_facturar, 2),
        ]);
    }

    /**
     * Buscar piezas similares para auto-relleno
     */
    public function buscarSimilares(Request $request)
    {
        $codigoPieza = $request->input('codigo_pieza');
        $nombrePieza = $request->input('nombre_pieza');

        $seguimientos = SeguimientoPieza::where('codigo_pieza', $codigoPieza)
            ->orWhere('nombre_pieza', 'LIKE', '%' . $nombrePieza . '%')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($seguimientos);
    }
}
