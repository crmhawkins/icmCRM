<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Models\Produccion\ColaTrabajo;
use App\Models\Models\Produccion\Pieza;
use App\Models\Models\Produccion\TipoTrabajo;
use App\Models\Models\Produccion\Maquinaria;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ColaTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colaTrabajo = ColaTrabajo::with(['pieza.pedido', 'tipoTrabajo', 'maquinaria', 'usuarioAsignado'])
            ->orderBy('prioridad', 'desc')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        $tiposTrabajo = TipoTrabajo::where('activo', true)->orderBy('nombre')->get();
        $maquinaria = Maquinaria::where('estado', 'activa')->orderBy('nombre')->get();

        return view('produccion.cola-trabajo.index', compact('colaTrabajo', 'tiposTrabajo', 'maquinaria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $piezas = Pieza::activo()->with('pedido')->orderBy('created_at', 'desc')->get();
        $tiposTrabajo = TipoTrabajo::activo()->ordenado()->get();
        $maquinaria = Maquinaria::activo()->orderBy('nombre')->get();
        $usuarios = User::activo()->orderBy('name')->get();

        return view('produccion.cola-trabajo.create', compact('piezas', 'tiposTrabajo', 'maquinaria', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pieza_id' => 'required|exists:piezas,id',
            'tipo_trabajo_id' => 'nullable|exists:tipos_trabajo,id',
            'maquinaria_id' => 'nullable|exists:maquinaria,id',
            'descripcion' => 'required|string|max:500',
            'cantidad' => 'required|integer|min:1',
            'prioridad' => 'required|integer|min:1|max:10',
            'tiempo_estimado_horas' => 'nullable|numeric|min:0',
            'fecha_inicio_estimada' => 'nullable|date',
            'fecha_fin_estimada' => 'nullable|date|after_or_equal:fecha_inicio_estimada',
            'usuario_asignado_id' => 'nullable|exists:admin_user,id',
            'notas' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $colaTrabajo = ColaTrabajo::create($request->all());

            return redirect()->route('cola-trabajo.index')
                ->with('success', 'Orden de trabajo creada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la orden de trabajo: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ColaTrabajo $colaTrabajo)
    {
        $colaTrabajo->load(['pieza.pedido', 'pieza.archivos', 'tipoTrabajo', 'maquinaria', 'usuarioAsignado']);

        return view('produccion.cola-trabajo.show', compact('colaTrabajo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ColaTrabajo $colaTrabajo)
    {
        $piezas = Pieza::where('estado', 'activa')->with('pedido')->orderBy('created_at', 'desc')->get();
        $tiposTrabajo = TipoTrabajo::where('activo', true)->orderBy('nombre')->get();
        $maquinaria = Maquinaria::where('estado', 'activa')->orderBy('nombre')->get();
        $usuarios = User::orderBy('name')->get();

        return view('produccion.cola-trabajo.edit', compact('colaTrabajo', 'piezas', 'tiposTrabajo', 'maquinaria', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ColaTrabajo $colaTrabajo)
    {
        $validator = Validator::make($request->all(), [
            'pieza_id' => 'required|exists:piezas,id',
            'tipo_trabajo_id' => 'nullable|exists:tipos_trabajo,id',
            'maquinaria_id' => 'nullable|exists:maquinaria,id',
            'descripcion' => 'required|string|max:500',
            'cantidad' => 'required|integer|min:1',
            'prioridad' => 'required|integer|min:1|max:10',
            'tiempo_estimado_horas' => 'nullable|numeric|min:0',
            'fecha_inicio_estimada' => 'nullable|date',
            'fecha_fin_estimada' => 'nullable|date|after_or_equal:fecha_inicio_estimada',
            'usuario_asignado_id' => 'nullable|exists:admin_user,id',
            'notas' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $colaTrabajo->update($request->all());

            return redirect()->route('cola-trabajo.index')
                ->with('success', 'Orden de trabajo actualizada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la orden de trabajo: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ColaTrabajo $colaTrabajo)
    {
        try {
            $colaTrabajo->delete();

            return redirect()->route('cola-trabajo.index')
                ->with('success', 'Orden de trabajo eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la orden de trabajo: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar estado de la orden de trabajo
     */
    public function cambiarEstado(Request $request, ColaTrabajo $colaTrabajo)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_cola,en_proceso,completado,cancelado'
        ]);

        $estado = $request->estado;
        $colaTrabajo->update(['estado' => $estado]);

        // Si se marca como en proceso, registrar fecha de inicio real
        if ($estado === 'en_proceso' && !$colaTrabajo->fecha_inicio_real) {
            $colaTrabajo->update(['fecha_inicio_real' => now()]);
        }

        // Si se marca como completado, registrar fecha de fin real
        if ($estado === 'completado' && !$colaTrabajo->fecha_fin_real) {
            $colaTrabajo->update(['fecha_fin_real' => now()]);
        }

        return redirect()->back()
            ->with('success', 'Estado de la orden de trabajo actualizado exitosamente.');
    }

    /**
     * Asignar maquinaria a la orden de trabajo
     */
    public function asignarMaquinaria(Request $request, ColaTrabajo $colaTrabajo)
    {
        $request->validate([
            'maquinaria_id' => 'required|exists:maquinaria,id'
        ]);

        $colaTrabajo->update(['maquinaria_id' => $request->maquinaria_id]);

        return redirect()->back()
            ->with('success', 'Maquinaria asignada exitosamente.');
    }

    /**
     * Asignar usuario a la orden de trabajo
     */
    public function asignarUsuario(Request $request, ColaTrabajo $colaTrabajo)
    {
        $request->validate([
            'usuario_id' => 'required|exists:admin_user,id'
        ]);

        $colaTrabajo->update(['usuario_asignado_id' => $request->usuario_id]);

        return redirect()->back()
            ->with('success', 'Usuario asignado exitosamente.');
    }

    /**
     * Descargar PDF de producción para la orden de trabajo
     */
    public function downloadPdf(ColaTrabajo $colaTrabajo)
    {
        try {
            // Cargar relaciones necesarias
            $colaTrabajo->load(['pieza.pedido.cliente', 'tipoTrabajo', 'maquinaria', 'usuarioAsignado']);
            
            // Generar el PDF
            $pdf = Pdf::loadView('produccion.pdf.hoja-produccion', compact('colaTrabajo'));
            
            // Configurar el PDF
            $pdf->setPaper('a4', 'portrait');
            
            // Nombre del archivo
            $filename = 'Hoja_Produccion_' . $colaTrabajo->codigo_trabajo . '_' . date('Y-m-d') . '.pdf';
            
            // Descargar el PDF
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
