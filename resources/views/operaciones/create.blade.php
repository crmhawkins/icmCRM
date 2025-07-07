{{-- Create Blade --}}

@extends('layouts.app')

@section('titulo', 'Crear Operacion')

@section('content')
<div class="page-heading card" style="box-shadow: none !important" >

    {{-- Titulos --}}
    <div class="page-title card-body">
        <div class="row justify-content-between">
            <div class="col-sm-12 col-md-4 order-md-1 order-last">
                <h3><i class="bi bi-globe-americas"></i> Operaciones</h3>
                <p class="text-subtitle text-muted">Crear nueva operación</p>
            </div>
            <div class="col-sm-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Crear Operaciones</li>
                    </ol>
                </nav>

            </div>
        </div>
    </div>


    <section class="section pt-4">
        <div class="card">

            <div class="card-body">
                {{-- Formulario para crear una nueva operación --}}
                <form action="{{ route('operaciones.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="numero">Número:</label>
                        <input type="text" name="numero" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
                </form>
            </div>
        </div>

    </section>

</div>
@endsection
