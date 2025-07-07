{{-- Edit Blade --}}

@extends('layouts.app')

@section('titulo', 'Editar Operación')

@section('content')

<div class="page-heading card" style="box-shadow: none !important" >

    {{-- Titulos --}}
    <div class="page-title card-body">
        <div class="row justify-content-between">
            <div class="col-sm-12 col-md-4 order-md-1 order-last">
                <h3><i class="bi bi-globe-americas"></i>Editar Operaciones</h3>
                <p class="text-subtitle text-muted">Editar operación</p>
            </div>
            <div class="col-sm-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar Operaciones</li>
                    </ol>
                </nav>

            </div>
        </div>
    </div>
    <section class="section pt-4">
        <div class="card">

            <div class="card-body">
                {{-- Formulario para editar la operación --}}
                <form action="{{ route('operaciones.update', $operacion) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="numero">Número:</label>
                        <input type="text" name="numero" class="form-control" value="{{ $operacion->numero }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $operacion->nombre }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
                </form>
            </div>
        </div>

    </section>
</div>
@endsection
