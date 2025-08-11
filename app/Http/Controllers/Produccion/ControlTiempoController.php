<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Models\Produccion\ColaTrabajo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ControlTiempoController extends Controller
{
    /**
     * Iniciar trabajo en una tarea
     */
    public function iniciarTrabajo(Request $request, ColaTrabajo $tarea): JsonResponse
    {
        try {
            if ($tarea->estado_tiempo !== 'no_iniciado') {
                return response()->json([
                    'success' => false,
                    'message' => 'La tarea ya ha sido iniciada'
                ], 400);
            }

            $tarea->iniciarTrabajo();

            return response()->json([
                'success' => true,
                'message' => 'Trabajo iniciado correctamente',
                'data' => [
                    'estado_tiempo' => $tarea->estado_tiempo,
                    'estado_tiempo_texto' => $tarea->estado_tiempo_texto,
                    'fecha_inicio' => $tarea->fecha_inicio_real->format('d/m/Y H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar el trabajo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Pausar trabajo en una tarea
     */
    public function pausarTrabajo(Request $request, ColaTrabajo $tarea): JsonResponse
    {
        try {
            if ($tarea->estado_tiempo !== 'en_progreso') {
                return response()->json([
                    'success' => false,
                    'message' => 'La tarea no está en progreso'
                ], 400);
            }

            $tarea->pausarTrabajo();

            return response()->json([
                'success' => true,
                'message' => 'Trabajo pausado correctamente',
                'data' => [
                    'estado_tiempo' => $tarea->estado_tiempo,
                    'estado_tiempo_texto' => $tarea->estado_tiempo_texto,
                    'tiempo_transcurrido' => $tarea->tiempo_transcurrido_formateado
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al pausar el trabajo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reanudar trabajo en una tarea
     */
    public function reanudarTrabajo(Request $request, ColaTrabajo $tarea): JsonResponse
    {
        try {
            if ($tarea->estado_tiempo !== 'pausado') {
                return response()->json([
                    'success' => false,
                    'message' => 'La tarea no está pausada'
                ], 400);
            }

            $tarea->reanudarTrabajo();

            return response()->json([
                'success' => true,
                'message' => 'Trabajo reanudado correctamente',
                'data' => [
                    'estado_tiempo' => $tarea->estado_tiempo,
                    'estado_tiempo_texto' => $tarea->estado_tiempo_texto
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al reanudar el trabajo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Finalizar trabajo en una tarea
     */
    public function finalizarTrabajo(Request $request, ColaTrabajo $tarea): JsonResponse
    {
        try {
            if (!in_array($tarea->estado_tiempo, ['en_progreso', 'pausado'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'La tarea no puede ser finalizada en su estado actual'
                ], 400);
            }

            $tarea->finalizarTrabajo();

            return response()->json([
                'success' => true,
                'message' => 'Trabajo finalizado correctamente',
                'data' => [
                    'estado_tiempo' => $tarea->estado_tiempo,
                    'estado_tiempo_texto' => $tarea->estado_tiempo_texto,
                    'tiempo_real_horas' => $tarea->tiempo_real_horas,
                    'eficiencia_porcentaje' => $tarea->eficiencia_porcentaje,
                    'fecha_fin' => $tarea->fecha_fin_real->format('d/m/Y H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al finalizar el trabajo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener información de tiempo de una tarea
     */
    public function obtenerInfoTiempo(ColaTrabajo $tarea): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'estado_tiempo' => $tarea->estado_tiempo,
                    'estado_tiempo_texto' => $tarea->estado_tiempo_texto,
                    'estado_tiempo_color' => $tarea->estado_tiempo_color,
                    'tiempo_estimado_horas' => $tarea->tiempo_estimado_horas,
                    'tiempo_real_horas' => $tarea->tiempo_real_horas,
                    'tiempo_transcurrido' => $tarea->tiempo_transcurrido_formateado,
                    'tiempo_pausado_minutos' => $tarea->tiempo_pausado_minutos,
                    'eficiencia_porcentaje' => $tarea->eficiencia_porcentaje,
                    'fecha_inicio_real' => $tarea->fecha_inicio_real ? $tarea->fecha_inicio_real->format('d/m/Y H:i:s') : null,
                    'fecha_fin_real' => $tarea->fecha_fin_real ? $tarea->fecha_fin_real->format('d/m/Y H:i:s') : null,
                    'fecha_ultima_pausa' => $tarea->fecha_ultima_pausa ? $tarea->fecha_ultima_pausa->format('d/m/Y H:i:s') : null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener información de tiempo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar notas de tiempo
     */
    public function actualizarNotasTiempo(Request $request, ColaTrabajo $tarea): JsonResponse
    {
        try {
            $request->validate([
                'notas_tiempo' => 'nullable|string|max:1000'
            ]);

            $tarea->update([
                'notas_tiempo' => $request->notas_tiempo
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notas actualizadas correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar notas: ' . $e->getMessage()
            ], 500);
        }
    }
}
