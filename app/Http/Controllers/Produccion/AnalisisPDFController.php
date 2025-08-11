<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Services\PedidoIAService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnalisisPDFController extends Controller
{
    protected $pedidoIAService;

    public function __construct(PedidoIAService $pedidoIAService)
    {
        $this->pedidoIAService = $pedidoIAService;
    }

    /**
     * Mostrar formulario para subir PDF
     */
    public function create()
    {
        return view('produccion.analisis-pdf.create');
    }

    /**
     * Analizar PDF con IA
     */
    public function analizar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'archivo_pdf' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Guardar el archivo PDF de forma permanente
            $archivoPath = $request->file('archivo_pdf')->store('pdfs/pedidos', 'public');

            // Analizar con IA
            $respuestaIA = $this->pedidoIAService->analizarPDF($archivoPath);

            // Guardar respuesta en sesión para mostrarla
            session([
                'pdf_analizado' => $archivoPath,
                'respuesta_ia' => $respuestaIA,
                'nombre_archivo' => $request->file('archivo_pdf')->getClientOriginalName()
            ]);

            return redirect()->route('analisis-pdf.resultado')
                ->with('success', 'PDF analizado exitosamente. Revisa los datos extraídos.');

        } catch (\Exception $e) {
            // Si hay error, eliminar el archivo subido
            if (isset($archivoPath) && Storage::disk('public')->exists($archivoPath)) {
                Storage::disk('public')->delete($archivoPath);
            }

            return redirect()->back()
                ->with('error', 'Error al analizar el PDF: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Previsualizar PDF
     */
    public function previsualizarPDF()
    {
        $archivoPath = session('pdf_analizado');

        if (!$archivoPath || !Storage::disk('public')->exists($archivoPath)) {
            return redirect()->back()
                ->with('error', 'PDF no encontrado.');
        }

        $rutaCompleta = storage_path('app/public/' . $archivoPath);
        
        return response()->file($rutaCompleta, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . session('nombre_archivo') . '"'
        ]);
    }

    /**
     * Mostrar resultado del análisis
     */
    public function resultado()
    {
        if (!session('respuesta_ia')) {
            return redirect()->route('analisis-pdf.create')
                ->with('error', 'No hay análisis de PDF para mostrar.');
        }

        $respuestaIA = session('respuesta_ia');
        $nombreArchivo = session('nombre_archivo');

        // Decodificar JSON para mostrar en formato legible
        $datos = json_decode($respuestaIA, true);

        return view('produccion.analisis-pdf.resultado', compact('respuestaIA', 'datos', 'nombreArchivo'));
    }

    /**
     * Crear pedido basado en el análisis
     */
    public function crearPedido(Request $request)
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
            'notas_manuales' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $respuestaIA = session('respuesta_ia');
            $archivoPath = session('pdf_analizado');

            if (!$respuestaIA || !$archivoPath) {
                return redirect()->back()
                    ->with('error', 'Datos de análisis no encontrados.');
            }

            // Preparar datos del pedido
            $datosPedido = [
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
            ];

            // Crear pedido con piezas
            $pedido = $this->pedidoIAService->procesarResultadoIA($respuestaIA, $datosPedido);

            // Limpiar sesión
            session()->forget(['pdf_analizado', 'respuesta_ia', 'nombre_archivo']);

            return redirect()->route('pedidos.show', $pedido->id)
                ->with('success', 'Pedido creado exitosamente con todas las piezas extraídas del PDF.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el pedido: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Reprocesar PDF con IA
     */
    public function reprocesar()
    {
        $archivoPath = session('pdf_analizado');

        if (!$archivoPath) {
            return redirect()->route('analisis-pdf.create')
                ->with('error', 'No hay PDF para reprocesar.');
        }

        try {
            // Analizar con IA nuevamente
            $respuestaIA = $this->pedidoIAService->analizarPDF($archivoPath);

            // Actualizar respuesta en sesión
            session(['respuesta_ia' => $respuestaIA]);

            return redirect()->route('analisis-pdf.resultado')
                ->with('success', 'PDF reprocesado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al reprocesar el PDF: ' . $e->getMessage());
        }
    }
} 