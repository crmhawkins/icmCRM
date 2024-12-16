@extends('layouts.app')

@section('titulo', 'Sub Cuenta Hija Contable')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
<link rel="stylesheet" href="{{ asset('assets/vendors/choices.js/choices.min.css') }}">
<style>
    .inactive-sort {
        color: #0F1739;
        text-decoration: none;
    }
    .active-sort {
        color: #757191;
    }
</style>
@endsection

@section('content')
<div class="page-heading card" style="box-shadow: none !important">
    <div class="page-title card-body">
        <div class="row justify-content-between">
            <div class="col-sm-12 col-md-4 order-md-1 order-last">
                <h3><i class="bi bi-globe-americas"></i> Sub Cuenta Hija Contable</h3>
                <p class="text-subtitle text-muted">Gestión de sub cuentas hijas contables</p>
            </div>
            <div class="col-sm-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sub Cuenta Hija Contable</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                {{-- <a href="{{ route('subCuentasHijaContables.create') }}" class="btn bg-color-quinto">Añadir sub cuenta hija contable</a> --}}
                <hr class="mb-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="mb-3">
                            <form action="{{ route('subCuentasHijaContables.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                                    <select name="subGrupo" class="form-control">
                                        <option value="">Selecciona Cuenta Contable</option>
                                        @foreach ($subCuentas as $subCuenta)
                                            <option value="{{ $subCuenta->id }}" {{ request('subGrupo') == $subCuenta->id ? 'selected' : '' }}>{{ $subCuenta->numero }} - {{ $subCuenta->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    {{-- <th>Editar</th> --}}
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($response as $item)
                                    <tr>
                                        <td>{{ $item->numero }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->descripcion }}</td>
                                        {{-- <td>
                                            <a href="{{ route('subCuentasHijaContables.edit', $item->id) }}" class="btn btn-secundario">Editar</a>
                                        </td> --}}
                                        <td>
                                            <form action="{{ route('subCuentasHijaContables.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="button" class="btn btn-danger delete-btn">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $response->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
@include('partials.toast')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
