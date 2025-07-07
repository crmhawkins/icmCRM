{{-- Index Blade --}}

@extends('layouts.app')

@section('titulo', 'Listado Operaciones')

@section('content')
<div class="page-heading card" style="box-shadow: none !important" >

    {{-- Titulos --}}
    <div class="page-title card-body">
        <div class="row justify-content-between">
            <div class="col-sm-12 col-md-4 order-md-1 order-last">
                <h3><i class="bi bi-globe-americas"></i> Operaciones</h3>
                <p class="text-subtitle text-muted">Listado de operaciones</p>
            </div>
            <div class="col-sm-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Operaciones</li>
                    </ol>
                </nav>

            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">

            <div class="card-body">
                    {{-- Botón para crear una nueva operación --}}
                    <a href="{{ route('operaciones.create') }}" class="btn btn-primary">Nueva Operación</a>
                    {{-- Tabla con las operaciones --}}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($operaciones as $operacion)
                                <tr>
                                    <td>{{ $operacion->numero }}</td>
                                    <td>{{ $operacion->nombre }}</td>
                                    <td>
                                        {{-- Botón para ver la operación --}}
                                        <a href="{{ route('operaciones.show', $operacion) }}" class="btn btn-info">Ver</a>
                                        {{-- Botón para editar la operación --}}
                                        <a href="{{ route('operaciones.edit', $operacion) }}" class="btn btn-warning">Editar</a>
                                        {{-- Formulario para eliminar la operación --}}
                                        <form action="{{ route('operaciones.destroy', $operacion) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay operaciones disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Paginación --}}
                    {{ $operaciones->links() }}
            </div>
        </div>
    </section>
</div>
@endsection

