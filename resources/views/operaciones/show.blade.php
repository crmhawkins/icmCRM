@extends('layouts.app')

@section('titulo', 'Detalle de Operación')

@section('content')

<div class="page-heading card" style="box-shadow: none !important" >

    {{-- Titulos --}}
    <div class="page-title card-body">
        <div class="row justify-content-between">
            <div class="col-sm-12 col-md-4 order-md-1 order-last">
                <h3><i class="bi bi-globe-americas"></i> Operaciones</h3>
                <p class="text-subtitle text-muted">Detalle de la operación</p>
            </div>
            <div class="col-sm-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detalle de la Operación</li>
                    </ol>
                </nav>

            </div>
        </div>
    </div>


    <section class="section pt-4">
        <div class="card">

            <div class="card-body">
                {{-- Formulario para crear una nueva operación --}}
                {{-- Detalles de la operación --}}
                <table class="table table-bordered">
                    <tr>
                        <th>Número</th>
                        <td>{{ $operacion->numero }}</td>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <td>{{ $operacion->nombre }}</td>
                    </tr>
                </table>
                {{-- Botones de acción --}}
                <a href="{{ route('operaciones.edit', $operacion) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('operaciones.destroy', $operacion) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
                <a href="{{ route('operaciones.index') }}" class="btn btn-secondary">Volver a la lista</a>
            </div>
        </div>

    </section>

</div>
@endsection
