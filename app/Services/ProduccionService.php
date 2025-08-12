<?php

namespace App\Services;

use App\Models\Models\Produccion\Pedido;
use App\Models\Models\Produccion\Pieza;
use App\Models\Models\Produccion\ColaTrabajo;
use App\Models\Models\Produccion\TipoTrabajo;
use App\Models\Models\Produccion\Maquinaria;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProduccionService
{
    /**
     * Generar tareas automáticamente para un pedido
     */
    public function generarTareasParaPedido(Pedido $pedido)
    {
        $tareasGeneradas = 0;

        try {
            DB::beginTransaction();

            // Obtener todas las piezas del pedido
            $piezas = $pedido->piezas()->get();

            foreach ($piezas as $pieza) {
                // Generar tareas para cada pieza
                $tareasPieza = $this->generarTareasParaPieza($pieza);
                $tareasGeneradas += $tareasPieza;
            }

            DB::commit();

            Log::info("Se generaron {$tareasGeneradas} tareas para el pedido {$pedido->numero_pedido}");

            return $tareasGeneradas;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error generando tareas para pedido {$pedido->numero_pedido}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generar tareas para una pieza específica
     */
    private function generarTareasParaPieza(Pieza $pieza)
    {
        $tareasGeneradas = 0;

        // Obtener tipos de trabajo disponibles
        $tiposTrabajo = TipoTrabajo::all();

        // Obtener maquinaria disponible
        $maquinaria = Maquinaria::where('activo', true)->get();

        // Obtener usuarios disponibles
        $usuarios = User::all();

        // Determinar qué tipos de trabajo necesita esta pieza
        $tiposNecesarios = $this->determinarTiposTrabajoParaPieza($pieza);

        foreach ($tiposNecesarios as $tipoTrabajo) {
            // Buscar el tipo de trabajo en la base de datos
            $tipoTrabajoModel = $tiposTrabajo->firstWhere('nombre', $tipoTrabajo['nombre']);

            if (!$tipoTrabajoModel) {
                Log::warning("Tipo de trabajo '{$tipoTrabajo['nombre']}' no encontrado para pieza {$pieza->codigo_pieza}");
                continue;
            }

            // Asignar maquinaria si es necesaria
            $maquinariaAsignada = null;
            if ($tipoTrabajo['requiere_maquinaria']) {
                $maquinariaAsignada = $this->asignarMaquinaria($tipoTrabajoModel, $maquinaria);
            }

            // Asignar usuario
            $usuarioAsignado = $this->asignarUsuario($tipoTrabajoModel, $usuarios);

            // Crear la tarea en la cola de trabajo
            $tarea = ColaTrabajo::create([
                'proyecto_id' => $pieza->pedido->proyecto_id ?? null,
                'presupuesto_id' => $pieza->pedido->presupuesto_id ?? null,
                'pieza_id' => $pieza->id,
                'maquinaria_id' => $maquinariaAsignada ? $maquinariaAsignada->id : null,
                'tipo_trabajo_id' => $tipoTrabajoModel->id,
                'usuario_asignado_id' => $usuarioAsignado ? $usuarioAsignado->id : null,
                'codigo_trabajo' => $this->generarCodigoTrabajo($pieza, $tipoTrabajoModel),
                'descripcion_trabajo' => $this->generarDescripcionTrabajo($pieza, $tipoTrabajoModel),
                'especificaciones' => $pieza->especificaciones_tecnicas,
                'cantidad_piezas' => $pieza->cantidad,
                'tiempo_estimado_horas' => $tipoTrabajo['tiempo_estimado'] ?? 1.0,
                'prioridad' => $pieza->prioridad,
                'estado' => 'pendiente',
                'fecha_inicio_estimada' => now(),
                'fecha_fin_estimada' => now()->addHours($tipoTrabajo['tiempo_estimado'] ?? 1),
                'notas' => "Tarea generada automáticamente para pieza {$pieza->codigo_pieza}",
                'activo' => true
            ]);

            $tareasGeneradas++;

            Log::info("Tarea creada: {$tarea->codigo_trabajo} para pieza {$pieza->codigo_pieza}");
        }

        return $tareasGeneradas;
    }

    /**
     * Determinar qué tipos de trabajo necesita una pieza
     */
    private function determinarTiposTrabajoParaPieza(Pieza $pieza)
    {
        $tiposTrabajo = [];

        // Análisis del material para determinar procesos necesarios
        $material = strtolower($pieza->material ?? '');
        $dimensiones = $pieza->dimensiones_completas ?? '';

        // Tareas básicas que siempre se necesitan
        $tiposTrabajo[] = [
            'nombre' => 'Diseño y Planificación',
            'requiere_maquinaria' => false,
            'tiempo_estimado' => 2.0
        ];

        // Tareas según el material
        if (str_contains($material, 'acero') || str_contains($material, 'hierro')) {
            $tiposTrabajo[] = [
                'nombre' => 'Corte de Metal',
                'requiere_maquinaria' => true,
                'tiempo_estimado' => 1.5
            ];

            $tiposTrabajo[] = [
                'nombre' => 'Soldadura',
                'requiere_maquinaria' => true,
                'tiempo_estimado' => 2.0
            ];
        }

        if (str_contains($material, 'aluminio')) {
            $tiposTrabajo[] = [
                'nombre' => 'Corte de Aluminio',
                'requiere_maquinaria' => true,
                'tiempo_estimado' => 1.0
            ];
        }

        if (str_contains($material, 'madera')) {
            $tiposTrabajo[] = [
                'nombre' => 'Corte de Madera',
                'requiere_maquinaria' => true,
                'tiempo_estimado' => 1.0
            ];
        }

        // Tareas según dimensiones
        if (str_contains($dimensiones, 'grande') || str_contains($dimensiones, 'pesado')) {
            $tiposTrabajo[] = [
                'nombre' => 'Manejo de Material Pesado',
                'requiere_maquinaria' => true,
                'tiempo_estimado' => 0.5
            ];
        }

        // Tareas de acabado
        if ($pieza->acabado) {
            $tiposTrabajo[] = [
                'nombre' => 'Acabado y Pulido',
                'requiere_maquinaria' => false,
                'tiempo_estimado' => 1.0
            ];
        }

        // Tarea final de control de calidad
        $tiposTrabajo[] = [
            'nombre' => 'Control de Calidad',
            'requiere_maquinaria' => false,
            'tiempo_estimado' => 0.5
        ];

        return $tiposTrabajo;
    }

    /**
     * Asignar maquinaria según el tipo de trabajo
     */
    private function asignarMaquinaria($tipoTrabajo, $maquinariaDisponible)
    {
        // Lógica simple: buscar maquinaria que coincida con el tipo de trabajo
        $maquinariaAdecuada = $maquinariaDisponible->filter(function ($maq) use ($tipoTrabajo) {
            return str_contains(strtolower($maq->nombre), strtolower($tipoTrabajo->nombre)) ||
                   str_contains(strtolower($tipoTrabajo->nombre), strtolower($maq->tipo ?? ''));
        })->first();

        return $maquinariaAdecuada ?: $maquinariaDisponible->first();
    }

    /**
     * Asignar usuario según el tipo de trabajo
     */
    private function asignarUsuario($tipoTrabajo, $usuariosDisponibles)
    {
        // Lógica simple: asignar al primer usuario disponible
        // En un sistema real, aquí habría lógica más compleja de asignación
        return $usuariosDisponibles->first();
    }

    /**
     * Generar código único para la tarea
     */
    private function generarCodigoTrabajo(Pieza $pieza, $tipoTrabajo)
    {
        $timestamp = now()->format('YmdHis');
        $piezaCode = substr($pieza->codigo_pieza, 0, 5);
        $tipoCode = substr($tipoTrabajo->nombre, 0, 3);

        return "TAR-{$piezaCode}-{$tipoCode}-{$timestamp}";
    }

    /**
     * Generar descripción de la tarea
     */
    private function generarDescripcionTrabajo(Pieza $pieza, $tipoTrabajo)
    {
        return "{$tipoTrabajo->nombre} para pieza {$pieza->codigo_pieza} - {$pieza->nombre_pieza}";
    }
}
