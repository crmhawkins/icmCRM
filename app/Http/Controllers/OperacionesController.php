<?php

namespace App\Http\Controllers;

use App\Models\Operaciones;
use Illuminate\Http\Request;

class OperacionesController extends Controller
{
    public function index()
    {
        $operaciones = Operaciones::paginate(10);
        return view('operaciones.index', compact('operaciones'));
    }

    public function create()
    {
        return view('operaciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'nombre' => 'required',
        ]);

        $operacion = new Operaciones();
        $operacion->numero = $request->numero;
        $operacion->nombre = $request->nombre;
        $operacion->save();

        return redirect()->route('operaciones.index')
            ->with('success', 'Operación creada correctamente.');
    }

    public function show(Operaciones $operacion)
    {
        return view('operaciones.show', compact('operacion'));
    }

    public function edit(Operaciones $operacion)
    {
        return view('operaciones.edit', compact('operacion'));
    }

    public function update(Request $request, Operaciones $operacion)
    {
        $request->validate([
            'numero' => 'required',
            'nombre' => 'required',
        ]);

        $operacion->numero = $request->numero;
        $operacion->nombre = $request->nombre;
        $operacion->save();

        return redirect()->route('operaciones.index')
            ->with('success', 'Operación actualizada correctamente.');
    }

    public function destroy(Operaciones $operacion)
    {
        $operacion->delete();

        return redirect()->route('operaciones.index')
            ->with('success', 'Operación eliminada correctamente.');
    }

}
