<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Models\Produccion\ColaTrabajo;
use App\Models\Models\Produccion\Maquinaria;
use App\Models\Models\Produccion\TipoTrabajo;
use App\Models\Models\Produccion\Pedido;
use App\Models\Models\Produccion\Pieza;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProduccionController extends Controller
{
    /**
     * Dashboard principal de producción
     */
    public function dashboard()
    {
        // Estadísticas de pedidos
        $totalPedidos = Pedido::count();
        $pedidosEsteMes = Pedido::whereMonth('created_at', Carbon::now()->month)->count();
        $pedidosPendientes = Pedido::where('estado', 'pendiente_analisis')->count();
        $pedidosProcesadosIA = Pedido::where('procesado_ia', true)->count();

        // Estadísticas de piezas
        $totalPiezas = Pieza::count();
        $piezasEsteMes = Pieza::whereMonth('created_at', Carbon::now()->month)->count();
        $piezasPendientes = Pieza::where('estado', 'pendiente')->count();
        $piezasCompletadas = Pieza::where('estado', 'completada')->count();

        // Estadísticas de órdenes de trabajo
        $totalOrdenesTrabajo = ColaTrabajo::activo()->count();
        $ordenesEsteMes = ColaTrabajo::whereMonth('created_at', Carbon::now()->month)->count();
        $ordenesPendientes = ColaTrabajo::pendiente()->count();
        $ordenesEnProceso = ColaTrabajo::enProceso()->count();

        // Estadísticas generales
        $totalMaquinaria = Maquinaria::activo()->count();
        $maquinariaOperativa = Maquinaria::operativa()->count();
        $maquinariaMantenimiento = Maquinaria::porEstado('mantenimiento')->count();

        $totalTrabajos = ColaTrabajo::activo()->count();
        $trabajosPendientes = ColaTrabajo::pendiente()->count();
        $trabajosEnProceso = ColaTrabajo::enProceso()->count();
        $trabajosCompletados = ColaTrabajo::completado()->count();

        // Agrupar estadísticas
        $stats = [
            'total_pedidos' => $totalPedidos,
            'pedidos_este_mes' => $pedidosEsteMes,
            'pedidos_pendientes' => $pedidosPendientes,
            'pedidos_procesados_ia' => $pedidosProcesadosIA,
            'total_piezas' => $totalPiezas,
            'piezas_este_mes' => $piezasEsteMes,
            'piezas_pendientes' => $piezasPendientes,
            'piezas_completadas' => $piezasCompletadas,
            'total_ordenes' => $totalOrdenesTrabajo,
            'ordenes_este_mes' => $ordenesEsteMes,
            'ordenes_pendientes' => $ordenesPendientes,
            'ordenes_en_proceso' => $ordenesEnProceso,
            'ordenes_completadas' => $trabajosCompletados,
            'eficiencia_promedio' => ColaTrabajo::where('estado', 'completado')
                ->whereNotNull('eficiencia_porcentaje')
                ->avg('eficiencia_porcentaje') ?? 0,
            'maquinaria_activa' => $maquinariaOperativa,
            'maquinaria_total' => $totalMaquinaria,
        ];

        // Trabajos por estado
        $trabajosPorEstado = ColaTrabajo::activo()
            ->selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        // Trabajos por prioridad
        $trabajosPorPrioridad = ColaTrabajo::activo()
            ->selectRaw('prioridad, COUNT(*) as total')
            ->groupBy('prioridad')
            ->pluck('total', 'prioridad')
            ->toArray();

        // Trabajos urgentes
        $trabajosUrgentes = ColaTrabajo::urgente()
            ->with(['maquinaria', 'tipoTrabajo', 'usuarioAsignado', 'proyecto'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Trabajos en proceso
        $trabajosEnProcesoList = ColaTrabajo::enProceso()
            ->with(['maquinaria', 'tipoTrabajo', 'usuarioAsignado', 'proyecto'])
            ->orderBy('fecha_inicio_real', 'asc')
            ->limit(10)
            ->get();

        // Maquinaria con más trabajo
        $maquinariaMasOcupada = Maquinaria::withCount(['colaTrabajo as trabajos_pendientes' => function($query) {
                $query->whereIn('estado', ['pendiente', 'en_cola', 'en_proceso']);
            }])
            ->activo()
            ->orderBy('trabajos_pendientes', 'desc')
            ->limit(5)
            ->get();

        // Pedidos recientes
        $pedidosRecientes = Pedido::with('piezas')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Órdenes de trabajo recientes
        $ordenesRecientes = ColaTrabajo::with(['pieza.pedido', 'tipoTrabajo', 'maquinaria', 'usuarioAsignado'])
            ->activo()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Estado de maquinaria con conteo de órdenes
        $estadoMaquinaria = Maquinaria::withCount(['colaTrabajo as ordenes_count' => function($query) {
                $query->whereIn('estado', ['pendiente', 'en_cola', 'en_proceso']);
            }])
            ->activo()
            ->orderBy('nombre')
            ->get();

        // Obtener tareas de producción asignadas al usuario actual
        $tareasProduccion = ColaTrabajo::where('usuario_asignado_id', auth()->id())
            ->with(['pieza', 'tipoTrabajo', 'maquinaria'])
            ->orderBy('prioridad', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('produccion.dashboard', compact(
            'stats',
            'tareasProduccion',
            'totalMaquinaria',
            'maquinariaOperativa',
            'maquinariaMantenimiento',
            'totalTrabajos',
            'trabajosPendientes',
            'trabajosEnProceso',
            'trabajosCompletados',
            'trabajosPorEstado',
            'trabajosPorPrioridad',
            'trabajosUrgentes',
            'trabajosEnProcesoList',
            'maquinariaMasOcupada',
            'pedidosRecientes',
            'ordenesRecientes',
            'estadoMaquinaria'
        ));
    }
}
