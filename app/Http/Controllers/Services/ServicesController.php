<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Services\Service;
use App\Models\Services\ServiceCategories;
use App\Models\Users\UserDepartament;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $servicios = Service::paginate(2);
        return view('services.index', compact('servicios'));
    }

    public function create() {
        $categorias = ServiceCategories::where('inactive', 0)->get();
        $departamentos = UserDepartament::all();
        return view('services.create', compact('categorias', 'departamentos'));
    }


    public function store(Request $request) {
        $data = $this->validate($request, [
            'title' => 'required|max:255',
            'services_categories_id' => 'required|integer',
            'concept' => 'required',
            'price' => 'required',
            'departamentos' => 'array|exists:admin_user_department,id'
        ]);

        $data['estado'] = 1;
        $data['order'] = 1;

        $servicioCreado = Service::create($data);

        if ($request->has('departamentos')) {
            $servicioCreado->departamentos()->sync($request->departamentos);
        }

        return redirect()->route('servicios.edit', $servicioCreado->id)->with('toast', [
            'icon' => 'success',
            'mensaje' => 'El servicio fue creado con éxito'
        ]);
    }

    public function edit(string $id){
        $servicio = Service::find($id);
        $categorias = ServiceCategories::where('inactive', 0)->get();
        $departamentos = \App\Models\Users\UserDepartament::all();
        $departamentosSeleccionados = $servicio->departamentos->pluck('id')->toArray();

        if (!$servicio) {
            session()->flash('toast', ['icon' => 'error', 'mensaje' => 'El servicio no existe']);
            return redirect()->route('servicios.index');
        }

        return view('services.edit', compact('servicio', 'categorias', 'departamentos', 'departamentosSeleccionados'));
    }

    public function update(string $id, Request $request) {
        $servicio = Service::find($id);
        $data = $this->validate($request, [
            'title' => 'required|max:255',
            'services_categories_id' => 'required|integer',
            'concept' => 'required',
            'price' => 'required',
            'inactive' => 'nullable',
            'departamentos' => 'array|exists:admin_user_department,id'
        ]);

        $servicio->update($data);

        if ($request->has('departamentos')) {
            $servicio->departamentos()->sync($request->departamentos);
        }

        return redirect()->route('servicios.index')->with('toast', [
            'icon' => 'success',
            'mensaje' => 'El servicio fue actualizado con éxito'
        ]);
    }

    public function destroy(Request $request) {
        $servicio = Service::find($request->id);

        if (!$servicio) {
            return response()->json([
                'error' => true,
                'mensaje' => "Error en el servidor, intentelo mas tarde."
            ]);
        }

        $servicio->delete();

        return response()->json([
            'error' => false,
            'mensaje' => 'El servicio fue borrado correctamente'
        ]);
    }



}
