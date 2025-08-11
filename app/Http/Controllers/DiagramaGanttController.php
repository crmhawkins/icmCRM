<?php

namespace App\Http\Controllers;

use App\Models\Budgets\Budget;
use App\Models\Tasks\LogTasks;
use App\Models\Models\Produccion\Pedido;
use App\Models\Produccion\ColaTrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiagramaGanttController extends Controller
{
    private function hmsToSeconds($hms) {
        if (!$hms) return 0;
        list($h, $m, $s) = array_pad(explode(':', $hms), 3, 0);
        return ($h * 3600) + ($m * 60) + $s;
    }

    public function getDataGrantt()
    {
        // Obtener pedidos de producción con sus piezas y cola de trabajo
        $pedidos = Pedido::with(['piezas.colaTrabajo.tipoTrabajo', 'piezas.colaTrabajo.maquinaria'])
            ->where('estado', 'en_produccion')
            ->orWhere('estado', 'completado')
            ->get();
        
        $datos = [];
        $maxFechaFin = null;
        $minFechaInicio = null;

        foreach($pedidos as $pedido) {
            foreach($pedido->piezas as $pieza) {
                if ($pieza->colaTrabajo && $pieza->colaTrabajo->count() > 0) {
                    foreach($pieza->colaTrabajo as $colaTrabajo) {
                        $fechaInicio = $colaTrabajo->fecha_inicio_estimada;
                        $fechaFin = $colaTrabajo->fecha_fin_estimada;
                        $tiempoEstimado = $colaTrabajo->tiempo_estimado_horas ?? 0;
                        
                        // Calcular progreso basado en el estado
                        $progreso = 0;
                        switch($colaTrabajo->estado) {
                            case 'pendiente':
                                $progreso = 0;
                                break;
                            case 'en_proceso':
                                $progreso = 50;
                                break;
                            case 'completado':
                                $progreso = 100;
                                break;
                            default:
                                $progreso = 0;
                        }

                        $datos[] = [
                            'id_tarea' => $colaTrabajo->id,
                            'tarea' => $pieza->nombre_pieza . ' - ' . ($colaTrabajo->tipoTrabajo->nombre ?? 'Sin tipo'),
                            'estado' => $colaTrabajo->estado,
                            'proyecto' => 'Pedido: ' . $pedido->numero_pedido,
                            'id_proyecto' => $pedido->id,
                            'duracion' => $tiempoEstimado . ':00:00',
                            'progreso' => $progreso,
                            'fecha_creacion' => $pedido->created_at,
                            'fecha_inicio' => $fechaInicio,
                            'fecha_fin' => $fechaFin,
                            'cliente' => $pedido->nombre_cliente,
                            'prioridad' => $pieza->prioridad ?? 'normal',
                            'maquinaria' => $colaTrabajo->maquinaria->nombre ?? 'Sin asignar'
                        ];

                        // Actualizar fechas máximas y mínimas
                        if ($fechaInicio && (!$minFechaInicio || strtotime($fechaInicio) < strtotime($minFechaInicio))) {
                            $minFechaInicio = $fechaInicio;
                        }
                        if ($fechaFin && (!$maxFechaFin || strtotime($fechaFin) > strtotime($maxFechaFin))) {
                            $maxFechaFin = $fechaFin;
                        }
                    }
                }
            }
        }

        // Si no hay fechas, usar fechas por defecto
        if (!$minFechaInicio) {
            $minFechaInicio = now()->subDays(30)->format('Y-m-d');
        }
        if (!$maxFechaFin) {
            $maxFechaFin = now()->addDays(30)->format('Y-m-d');
        }

        return $datos;
    }

    public function mostrarDiagramaGantt()
    {
        $datos = $this->getDataGrantt();
        
        // Debug: Ensure we have data
        if (empty($datos)) {
            Log::info('No hay datos en el diagrama Gantt de producción');
        } else {
            Log::info('Datos del diagrama Gantt de producción: ' . count($datos) . ' tareas encontradas');
        }
        
        return view('diagrama.index', compact('datos'));
    }
}
