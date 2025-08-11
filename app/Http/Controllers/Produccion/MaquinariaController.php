<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Models\Produccion\Maquinaria;
use App\Models\Models\Produccion\TipoTrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaquinariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maquinaria = Maquinaria::with('tiposTrabajo')
            ->activo()
            ->orderBy('nombre')
            ->get();

        return view('produccion.maquinaria.index', compact('maquinaria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposTrabajo = TipoTrabajo::where('activo', true)->orderBy('nombre')->get();
        return view('produccion.maquinaria.create', compact('tiposTrabajo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:maquinaria,codigo',
            'modelo' => 'nullable|string|max:100',
            'fabricante' => 'nullable|string|max:100',
            'ano_fabricacion' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'numero_serie' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'nullable|string|max:100',
            'estado' => 'required|in:operativa,mantenimiento,reparacion,inactiva',
            'capacidad_maxima' => 'nullable|numeric|min:0',
            'unidad_capacidad' => 'nullable|string|max:20',
            'velocidad_operacion' => 'nullable|numeric|min:0',
            'unidad_velocidad' => 'nullable|string|max:20',
            'tipos_trabajo' => 'nullable|array',
            'tipos_trabajo.*' => 'exists:tipos_trabajo,id',
            'eficiencias' => 'nullable|array',
            'eficiencias.*' => 'numeric|min:0|max:100',
            'tiempos_setup' => 'nullable|array',
            'tiempos_setup.*' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $maquinaria = Maquinaria::create($request->only([
            'nombre', 'codigo', 'modelo', 'fabricante', 'ano_fabricacion',
            'numero_serie', 'descripcion', 'ubicacion', 'estado',
            'capacidad_maxima', 'unidad_capacidad', 'velocidad_operacion', 'unidad_velocidad'
        ]));

        // Asociar tipos de trabajo
        if ($request->has('tipos_trabajo')) {
            $tiposTrabajo = [];
            foreach ($request->tipos_trabajo as $index => $tipoId) {
                $tiposTrabajo[$tipoId] = [
                    'eficiencia' => $request->eficiencias[$index] ?? 100.00,
                    'tiempo_setup_minutos' => $request->tiempos_setup[$index] ?? 0,
                    'activo' => true
                ];
            }
            $maquinaria->tiposTrabajo()->attach($tiposTrabajo);
        }

        return redirect()->route('maquinaria.index')
            ->with('success', 'Maquinaria creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maquinaria $maquinaria)
    {
        $maquinaria->load(['tiposTrabajo', 'colaTrabajo.usuarioAsignado', 'colaTrabajo.proyecto']);
        return view('produccion.maquinaria.show', compact('maquinaria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maquinaria $maquinaria)
    {
        $tiposTrabajo = TipoTrabajo::where('activo', true)->orderBy('nombre')->get();
        $maquinaria->load('tiposTrabajo');
        return view('produccion.maquinaria.edit', compact('maquinaria', 'tiposTrabajo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maquinaria $maquinaria)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:maquinaria,codigo,' . $maquinaria->id,
            'modelo' => 'nullable|string|max:100',
            'fabricante' => 'nullable|string|max:100',
            'ano_fabricacion' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'numero_serie' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'nullable|string|max:100',
            'estado' => 'required|in:operativa,mantenimiento,reparacion,inactiva',
            'capacidad_maxima' => 'nullable|numeric|min:0',
            'unidad_capacidad' => 'nullable|string|max:20',
            'velocidad_operacion' => 'nullable|numeric|min:0',
            'unidad_velocidad' => 'nullable|string|max:20',
            'tipos_trabajo' => 'nullable|array',
            'tipos_trabajo.*' => 'exists:tipos_trabajo,id',
            'eficiencias' => 'nullable|array',
            'eficiencias.*' => 'numeric|min:0|max:100',
            'tiempos_setup' => 'nullable|array',
            'tiempos_setup.*' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $maquinaria->update($request->only([
            'nombre', 'codigo', 'modelo', 'fabricante', 'ano_fabricacion',
            'numero_serie', 'descripcion', 'ubicacion', 'estado',
            'capacidad_maxima', 'unidad_capacidad', 'velocidad_operacion', 'unidad_velocidad'
        ]));

        // Actualizar tipos de trabajo
        $maquinaria->tiposTrabajo()->detach();
        if ($request->has('tipos_trabajo')) {
            $tiposTrabajo = [];
            foreach ($request->tipos_trabajo as $index => $tipoId) {
                $tiposTrabajo[$tipoId] = [
                    'eficiencia' => $request->eficiencias[$index] ?? 100.00,
                    'tiempo_setup_minutos' => $request->tiempos_setup[$index] ?? 0,
                    'activo' => true
                ];
            }
            $maquinaria->tiposTrabajo()->attach($tiposTrabajo);
        }

        return redirect()->route('maquinaria.index')
            ->with('success', 'Maquinaria actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maquinaria $maquinaria)
    {
        // Verificar si tiene trabajos en cola
        if ($maquinaria->colaTrabajo()->whereIn('estado', ['pendiente', 'en_cola', 'en_proceso'])->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la maquinaria porque tiene trabajos pendientes.');
        }

        $maquinaria->delete();

        return redirect()->route('maquinaria.index')
            ->with('success', 'Maquinaria eliminada exitosamente.');
    }

    /**
     * Cambiar estado de la maquinaria
     */
    public function cambiarEstado(Request $request, Maquinaria $maquinaria)
    {
        $request->validate([
            'estado' => 'required|in:operativa,mantenimiento,reparacion,inactiva'
        ]);

        $maquinaria->update(['estado' => $request->estado]);

        return redirect()->back()
            ->with('success', 'Estado de la maquinaria actualizado exitosamente.');
    }
}
