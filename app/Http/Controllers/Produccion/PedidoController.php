<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Models\Produccion\Pedido;
use App\Services\PedidoIAService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PedidoController extends Controller
{
    protected $pedidoIAService;

    public function __construct(PedidoIAService $pedidoIAService)
    {
        $this->pedidoIAService = $pedidoIAService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with(['piezas', 'usuarioProcesador'])
            ->activo()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('produccion.pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produccion.pedidos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_pedido' => 'required|string|max:50|unique:pedidos,numero_pedido',
            'codigo_cliente' => 'nullable|string|max:50',
            'nombre_cliente' => 'nullable|string|max:100',
            'fecha_pedido' => 'nullable|date',
            'fecha_entrega_estimada' => 'nullable|date|after_or_equal:fecha_pedido',
            'descripcion_general' => 'nullable|string',
            'valor_total' => 'nullable|numeric|min:0',
            'moneda' => 'required|string|max:10',
            'archivo_pdf' => 'required|file|mimes:pdf|max:10240', // 10MB max
            'notas_manuales' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Guardar el archivo PDF
            $archivoPath = $request->file('archivo_pdf')->store('pedidos/pdfs', 'public');

            $pedido = Pedido::create([
                'numero_pedido' => $request->numero_pedido,
                'codigo_cliente' => $request->codigo_cliente,
                'nombre_cliente' => $request->nombre_cliente,
                'fecha_pedido' => $request->fecha_pedido,
                'fecha_entrega_estimada' => $request->fecha_entrega_estimada,
                'descripcion_general' => $request->descripcion_general,
                'valor_total' => $request->valor_total,
                'moneda' => $request->moneda,
                'archivo_pdf_original' => $archivoPath,
                'notas_manuales' => $request->notas_manuales,
                'usuario_procesador_id' => auth()->id(),
                'estado' => 'pendiente_analisis'
            ]);

            return redirect()->route('pedidos.show', $pedido->id)
                ->with('success', 'Pedido creado exitosamente. Puedes procesarlo con IA para extraer información automáticamente.');

        } catch (\Exception $e) {
            // Si hay error, eliminar el archivo subido
            if (isset($archivoPath) && Storage::disk('public')->exists($archivoPath)) {
                Storage::disk('public')->delete($archivoPath);
            }

            return redirect()->back()
                ->with('error', 'Error al crear el pedido: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        $pedido->load(['piezas.archivos', 'piezas.tipoTrabajo', 'piezas.maquinariaAsignada', 'piezas.usuarioAsignado', 'usuarioProcesador']);

        return view('produccion.pedidos.show', compact('pedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        return view('produccion.pedidos.edit', compact('pedido'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $validator = Validator::make($request->all(), [
            'numero_pedido' => 'required|string|max:50|unique:pedidos,numero_pedido,' . $pedido->id,
            'codigo_cliente' => 'nullable|string|max:50',
            'nombre_cliente' => 'nullable|string|max:100',
            'fecha_pedido' => 'nullable|date',
            'fecha_entrega_estimada' => 'nullable|date|after_or_equal:fecha_pedido',
            'descripcion_general' => 'nullable|string',
            'valor_total' => 'nullable|numeric|min:0',
            'moneda' => 'required|string|max:10',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'notas_manuales' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->except(['archivo_pdf']);

            // Si se sube un nuevo archivo PDF
            if ($request->hasFile('archivo_pdf')) {
                // Eliminar archivo anterior
                if ($pedido->archivo_pdf_original && Storage::disk('public')->exists($pedido->archivo_pdf_original)) {
                    Storage::disk('public')->delete($pedido->archivo_pdf_original);
                }

                // Guardar nuevo archivo
                $archivoPath = $request->file('archivo_pdf')->store('pedidos/pdfs', 'public');
                $data['archivo_pdf_original'] = $archivoPath;
                $data['procesado_ia'] = false; // Resetear procesamiento IA
                $data['fecha_procesamiento_ia'] = null;
            }

            $pedido->update($data);

            return redirect()->route('pedidos.show', $pedido->id)
                ->with('success', 'Pedido actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el pedido: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        try {
            // Eliminar archivo PDF
            if ($pedido->archivo_pdf_original && Storage::disk('public')->exists($pedido->archivo_pdf_original)) {
                Storage::disk('public')->delete($pedido->archivo_pdf_original);
            }

            // Eliminar piezas y archivos asociados
            foreach ($pedido->piezas as $pieza) {
                foreach ($pieza->archivos as $archivo) {
                    if (Storage::disk('public')->exists($archivo->ruta_archivo)) {
                        Storage::disk('public')->delete($archivo->ruta_archivo);
                    }
                }
            }

            $pedido->delete();

            return redirect()->route('pedidos.index')
                ->with('success', 'Pedido eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Procesar pedido con IA
     */
    public function procesarIA(Pedido $pedido)
    {
        try {
            if ($pedido->procesado_ia) {
                return redirect()->back()
                    ->with('warning', 'Este pedido ya ha sido procesado con IA.');
            }

            if (!$pedido->archivo_pdf_original) {
                return redirect()->back()
                    ->with('error', 'No se encontró el archivo PDF para procesar.');
            }

            // Extraer texto del PDF
            $pdfContent = $this->pedidoIAService->extraerTextoPDF($pedido->archivo_pdf_original);

            if (empty($pdfContent)) {
                return redirect()->back()
                    ->with('error', 'No se pudo extraer texto del PDF.');
            }

            // Analizar con IA y obtener respuesta
            $respuestaIA = $this->pedidoIAService->analizarConIA($pdfContent, $pedido);

            // Guardar la respuesta de la IA en el pedido para mostrarla
            $pedido->update([
                'notas_ia' => $respuestaIA,
                'fecha_procesamiento_ia' => now()
            ]);

            // Mostrar la respuesta de la IA en pantalla
            return redirect()->route('pedidos.show', $pedido->id)
                ->with('success', 'Análisis de IA completado. Revisa la respuesta antes de procesar las piezas.')
                ->with('mostrar_respuesta_ia', true);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al procesar con IA: ' . $e->getMessage());
        }
    }

    /**
     * Confirmar y procesar la respuesta de la IA
     */
    public function confirmarProcesamientoIA(Pedido $pedido)
    {
        try {
            if (!$pedido->notas_ia) {
                return redirect()->back()
                    ->with('error', 'No hay respuesta de IA para procesar.');
            }

            // Procesar la respuesta de la IA y crear piezas
            $this->pedidoIAService->procesarResultadoIA($pedido->notas_ia, $pedido);

            // Marcar como procesado
            $pedido->marcarComoProcesadoIA();

            return redirect()->route('pedidos.show', $pedido->id)
                ->with('success', 'Pedido procesado exitosamente. Se han creado las piezas automáticamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al procesar la respuesta de IA: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar estado del pedido a 'en_proceso'
     */
    public function cambiarAEnProceso(Pedido $pedido)
    {
        try {
            // Verificar que el pedido esté en estado 'analizado'
            if ($pedido->estado !== 'analizado') {
                return redirect()->back()
                    ->with('error', 'Solo se pueden poner en proceso pedidos que estén analizados.');
            }

            // Verificar que todas las piezas tengan tiempos asignados
            $piezasSinTiempos = $pedido->piezas()->whereNull('tiempo_estimado_horas')->count();
            if ($piezasSinTiempos > 0) {
                return redirect()->back()
                    ->with('error', 'No se puede poner en proceso. Hay ' . $piezasSinTiempos . ' piezas sin tiempos asignados.');
            }

            // Cambiar estado a 'en_proceso'
            $pedido->update(['estado' => 'en_proceso']);

            return redirect()->back()
                ->with('success', 'Pedido puesto en proceso exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al cambiar estado del pedido: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar estado del pedido a 'completado'
     */
    public function cambiarACompletado(Pedido $pedido)
    {
        try {
            // Verificar que el pedido esté en estado 'en_proceso'
            if ($pedido->estado !== 'en_proceso') {
                return redirect()->back()
                    ->with('error', 'Solo se pueden completar pedidos que estén en proceso.');
            }

            // Verificar que todas las piezas estén completadas
            $piezasPendientes = $pedido->piezas()->whereNotIn('estado', ['completada'])->count();
            if ($piezasPendientes > 0) {
                return redirect()->back()
                    ->with('error', 'No se puede completar. Hay ' . $piezasPendientes . ' piezas pendientes.');
            }

            // Cambiar estado a 'completado'
            $pedido->update(['estado' => 'completado']);

            return redirect()->back()
                ->with('success', 'Pedido marcado como completado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al cambiar estado del pedido: ' . $e->getMessage());
        }
    }

    /**
     * Pasar pedido a producción y generar tareas automáticamente
     */
    public function pasarAProduccion(Pedido $pedido)
    {
        try {
            // Verificar que el pedido esté procesado por IA
            if (!$pedido->procesado_ia) {
                return redirect()->back()->with('error', 'El pedido debe estar procesado por IA antes de pasar a producción.');
            }

            // Verificar que el pedido no esté ya en producción
            if ($pedido->estado === 'en_produccion') {
                return redirect()->back()->with('warning', 'El pedido ya está en producción.');
            }

            // Verificar que tenga piezas
            if ($pedido->piezas->count() === 0) {
                return redirect()->back()->with('error', 'El pedido no tiene piezas para procesar en producción.');
            }

            // Crear servicio para generar tareas
            $servicioProduccion = new \App\Services\ProduccionService();

            // Generar tareas para cada pieza
            $tareasGeneradas = $servicioProduccion->generarTareasParaPedido($pedido);

            // Actualizar estado del pedido
            $pedido->update([
                'estado' => 'en_produccion'
            ]);

            return redirect()->back()->with('success', "Pedido pasado a producción exitosamente. Se generaron {$tareasGeneradas} tareas automáticamente.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al pasar el pedido a producción: ' . $e->getMessage());
        }
    }

    /**
     * Descargar PDF de producción para el pedido completo
     */
    public function downloadPdfProduccion(Pedido $pedido)
    {
        try {
            // Cargar todas las relaciones necesarias
            $pedido->load([
                'piezas.colaTrabajo.tipoTrabajo',
                'piezas.colaTrabajo.maquinaria',
                'piezas.colaTrabajo.usuarioAsignado',
                'piezas.seguimiento'
            ]);

            // Ruta del logo
            $logoPath = public_path('assets/images/logo/logo.png');

            // Generar el PDF
            $pdf = Pdf::loadView('produccion.pdf.hoja-produccion-pedido', compact('pedido', 'logoPath'));
            
            // Configurar el PDF
            $pdf->setPaper('a4', 'portrait');
            
            // Nombre del archivo
            $filename = 'Hoja_Produccion_Pedido_' . $pedido->numero_pedido . '_' . date('Y-m-d') . '.pdf';
            
            // Descargar el PDF
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
