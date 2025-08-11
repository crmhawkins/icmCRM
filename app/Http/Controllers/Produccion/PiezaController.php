<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Models\Produccion\Pieza;
use App\Models\Models\Produccion\Pedido;
use App\Models\Models\Produccion\TipoTrabajo;
use App\Models\Models\Produccion\Maquinaria;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PiezaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $piezas = Pieza::with(['pedido', 'tipoTrabajo', 'maquinariaAsignada', 'usuarioAsignado'])
            ->activo()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('produccion.piezas.index', compact('piezas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pedidos = Pedido::activo()->orderBy('numero_pedido')->get();
        $tiposTrabajo = TipoTrabajo::activo()->ordenado()->get();
        $maquinaria = Maquinaria::activo()->orderBy('nombre')->get();
        $usuarios = User::activo()->orderBy('name')->get();

        return view('produccion.piezas.create', compact('pedidos', 'tiposTrabajo', 'maquinaria', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pedido_id' => 'required|exists:pedidos,id',
            'codigo_pieza' => 'required|string|max:50',
            'nombre_pieza' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer|min:1',
            'material' => 'nullable|string|max:100',
            'acabado' => 'nullable|string|max:100',
            'dimensiones_largo' => 'nullable|numeric|min:0',
            'dimensiones_ancho' => 'nullable|numeric|min:0',
            'dimensiones_alto' => 'nullable|numeric|min:0',
            'unidad_medida' => 'required|string|max:10',
            'peso_unitario' => 'nullable|numeric|min:0',
            'unidad_peso' => 'required|string|max:10',
            'precio_unitario' => 'nullable|numeric|min:0',
            'especificaciones_tecnicas' => 'nullable|string',
            'notas_fabricacion' => 'nullable|string',
            'tipo_trabajo_id' => 'nullable|exists:tipos_trabajo,id',
            'maquinaria_asignada_id' => 'nullable|exists:maquinaria,id',
            'usuario_asignado_id' => 'nullable|exists:admin_user,id',
            'prioridad' => 'required|integer|min:1|max:10',
            'fecha_inicio_estimada' => 'nullable|date',
            'fecha_fin_estimada' => 'nullable|date|after_or_equal:fecha_inicio_estimada',
            'tiempo_estimado_horas' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pieza = Pieza::create($request->all());

            // Calcular precio total
            if ($pieza->precio_unitario) {
                $pieza->calcularPrecioTotal();
            }

            return redirect()->route('piezas.show', $pieza->id)
                ->with('success', 'Pieza creada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la pieza: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pieza $pieza)
    {
        $pieza->load(['pedido', 'tipoTrabajo', 'maquinariaAsignada', 'usuarioAsignado', 'archivos']);

        return view('produccion.piezas.show', compact('pieza'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pieza $pieza)
    {
        $pedidos = Pedido::activo()->orderBy('numero_pedido')->get();
        $tiposTrabajo = TipoTrabajo::activo()->ordenado()->get();
        $maquinaria = Maquinaria::activo()->orderBy('nombre')->get();
        $usuarios = User::activo()->orderBy('name')->get();

        return view('produccion.piezas.edit', compact('pieza', 'pedidos', 'tiposTrabajo', 'maquinaria', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pieza $pieza)
    {
        $validator = Validator::make($request->all(), [
            'pedido_id' => 'required|exists:pedidos,id',
            'codigo_pieza' => 'required|string|max:50',
            'nombre_pieza' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer|min:1',
            'material' => 'nullable|string|max:100',
            'acabado' => 'nullable|string|max:100',
            'dimensiones_largo' => 'nullable|numeric|min:0',
            'dimensiones_ancho' => 'nullable|numeric|min:0',
            'dimensiones_alto' => 'nullable|numeric|min:0',
            'unidad_medida' => 'required|string|max:10',
            'peso_unitario' => 'nullable|numeric|min:0',
            'unidad_peso' => 'required|string|max:10',
            'precio_unitario' => 'nullable|numeric|min:0',
            'especificaciones_tecnicas' => 'nullable|string',
            'notas_fabricacion' => 'nullable|string',
            'tipo_trabajo_id' => 'nullable|exists:tipos_trabajo,id',
            'maquinaria_asignada_id' => 'nullable|exists:maquinaria,id',
            'usuario_asignado_id' => 'nullable|exists:admin_user,id',
            'prioridad' => 'required|integer|min:1|max:10',
            'fecha_inicio_estimada' => 'nullable|date',
            'fecha_fin_estimada' => 'nullable|date|after_or_equal:fecha_inicio_estimada',
            'tiempo_estimado_horas' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pieza->update($request->all());

            // Calcular precio total
            if ($pieza->precio_unitario) {
                $pieza->calcularPrecioTotal();
            }

            return redirect()->route('piezas.show', $pieza->id)
                ->with('success', 'Pieza actualizada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la pieza: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pieza $pieza)
    {
        try {
            // Eliminar archivos asociados
            foreach ($pieza->archivos as $archivo) {
                if (Storage::disk('public')->exists($archivo->ruta_archivo)) {
                    Storage::disk('public')->delete($archivo->ruta_archivo);
                }
            }

            $pieza->delete();

            return redirect()->route('piezas.index')
                ->with('success', 'Pieza eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la pieza: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar estado de la pieza
     */
    public function cambiarEstado(Request $request, Pieza $pieza)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_diseno,en_fabricacion,en_control_calidad,completada,cancelada'
        ]);

        $estado = $request->estado;
        $pieza->update(['estado' => $estado]);

        // Si se marca como en fabricación, registrar fecha de inicio real
        if ($estado === 'en_fabricacion' && !$pieza->fecha_inicio_real) {
            $pieza->update(['fecha_inicio_real' => now()]);
        }

        // Si se marca como completada, registrar fecha de fin real
        if ($estado === 'completada' && !$pieza->fecha_fin_real) {
            $pieza->update(['fecha_fin_real' => now()]);
        }

        return redirect()->back()
            ->with('success', 'Estado de la pieza actualizado exitosamente.');
    }

    /**
     * Asignar maquinaria a la pieza
     */
    public function asignarMaquinaria(Request $request, Pieza $pieza)
    {
        $request->validate([
            'maquinaria_id' => 'required|exists:maquinaria,id'
        ]);

        $pieza->update(['maquinaria_asignada_id' => $request->maquinaria_id]);

        return redirect()->back()
            ->with('success', 'Maquinaria asignada exitosamente.');
    }

    /**
     * Asignar usuario a la pieza
     */
    public function asignarUsuario(Request $request, Pieza $pieza)
    {
        $request->validate([
            'usuario_id' => 'required|exists:admin_user,id'
        ]);

        $pieza->update(['usuario_asignado_id' => $request->usuario_id]);

        return redirect()->back()
            ->with('success', 'Usuario asignado exitosamente.');
    }
}
