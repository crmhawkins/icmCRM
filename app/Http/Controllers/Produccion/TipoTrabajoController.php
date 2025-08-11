<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Models\Produccion\TipoTrabajo;
use Illuminate\Support\Facades\Log;

class TipoTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tiposTrabajo = TipoTrabajo::orderBy('orden', 'asc')
                                      ->orderBy('nombre', 'asc')
                                      ->get();

            return view('produccion.tipos-trabajo.index', compact('tiposTrabajo'));
        } catch (\Exception $e) {
            Log::error('Error en TipoTrabajoController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar los tipos de trabajo');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('produccion.tipos-trabajo.create');
        } catch (\Exception $e) {
            Log::error('Error en TipoTrabajoController@create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al mostrar el formulario de creación');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'codigo' => 'required|string|max:50|unique:tipos_trabajo',
                'descripcion' => 'nullable|string',
                'tiempo_estimado_horas' => 'nullable|numeric|min:0',
                'requiere_maquinaria' => 'boolean',
                'orden' => 'nullable|integer|min:0',
                'activo' => 'boolean'
            ]);

            TipoTrabajo::create($request->all());

            return redirect()->route('tipos-trabajo.index')
                           ->with('success', 'Tipo de trabajo creado correctamente');
        } catch (\Exception $e) {
            Log::error('Error en TipoTrabajoController@store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear el tipo de trabajo');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $tipoTrabajo = TipoTrabajo::findOrFail($id);
            return view('produccion.tipos-trabajo.show', compact('tipoTrabajo'));
        } catch (\Exception $e) {
            Log::error('Error en TipoTrabajoController@show: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tipo de trabajo no encontrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $tipoTrabajo = TipoTrabajo::findOrFail($id);
            return view('produccion.tipos-trabajo.edit', compact('tipoTrabajo'));
        } catch (\Exception $e) {
            Log::error('Error en TipoTrabajoController@edit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tipo de trabajo no encontrado');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $tipoTrabajo = TipoTrabajo::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255',
                'codigo' => 'required|string|max:50|unique:tipos_trabajo,codigo,' . $id,
                'descripcion' => 'nullable|string',
                'tiempo_estimado_horas' => 'nullable|numeric|min:0',
                'requiere_maquinaria' => 'boolean',
                'orden' => 'nullable|integer|min:0',
                'activo' => 'boolean'
            ]);

            $tipoTrabajo->update($request->all());

            return redirect()->route('tipos-trabajo.index')
                           ->with('success', 'Tipo de trabajo actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error en TipoTrabajoController@update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el tipo de trabajo');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tipoTrabajo = TipoTrabajo::findOrFail($id);
            $tipoTrabajo->delete();

            return redirect()->route('tipos-trabajo.index')
                           ->with('success', 'Tipo de trabajo eliminado correctamente');
        } catch (\Exception $e) {
            Log::error('Error en TipoTrabajoController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar el tipo de trabajo');
        }
    }

    /**
     * Cambiar estado activo/inactivo
     */
    public function cambiarEstado(Request $request, string $id)
    {
        try {
            $tipoTrabajo = TipoTrabajo::findOrFail($id);
            $tipoTrabajo->update(['activo' => $request->activo]);

            $estado = $request->activo ? 'activado' : 'desactivado';
            return redirect()->route('tipos-trabajo.index')
                           ->with('success', "Tipo de trabajo {$estado} correctamente");
        } catch (\Exception $e) {
            Log::error('Error en TipoTrabajoController@cambiarEstado: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cambiar el estado');
        }
    }
}
