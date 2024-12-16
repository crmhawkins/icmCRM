@extends('layouts.app')

@section('titulo', 'Diario de Caja')

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
    .custom-tooltip {
        --bs-tooltip-bg: var(--bd-violet-bg);
        --bs-tooltip-color: var(--bs-white);
    }
</style>
@endsection

@section('content')
<div class="page-heading card" style="box-shadow: none !important">
    <div class="page-title card-body">
        <div class="row justify-content-between">
            <div class="col-sm-12 col-md-4 order-md-1 order-last">
                <h3><i class="bi bi-globe-americas"></i> Diario de Caja</h3>
                <p class="text-subtitle text-muted">Gestión de movimientos de caja</p>
            </div>
            <div class="col-sm-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Diario de Caja</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn bg-color-quinto" data-toggle="modal" data-target="#modalDiarioCaja">
                    Añadir al diario de caja
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalDiarioCaja" tabindex="-1" role="dialog" aria-labelledby="modalDiarioCajaLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDiarioCajaLabel">Añadir al Diario de Caja</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <a href="{{ route('diarioCaja.ingreso') }}" class="btn btn-primary">Añadir Ingreso</a>
                                <a href="{{ route('diarioCaja.gasto') }}" class="btn btn-secondary">Añadir Gasto</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mb-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="jumbotron">
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table id="cuentas" class="table table-striped table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Asiento</th>
                                                    <th>Estado</th>
                                                    <th>Cuenta</th>
                                                    <th>Fecha</th>
                                                    <th>Concepto</th>
                                                    <th>Forma de Pago</th>
                                                    <th>Debe</th>
                                                    <th>Haber</th>
                                                    <th>Saldo</th>
                                                    <th>Editar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($response as $linea)
                                                <tr>
                                                    <td>{{$linea->asiento_contable}}</td>
                                                    <td>{{$linea->estado->nombre}}</td>
                                                    <td
                                                        style="cursor: pointer"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-title="{{$linea->determineCuenta()->nombre}}">
                                                        {{$linea->determineCuenta()->numero}}
                                                    </td>
                                                    <td>{{$linea->date}}</td>
                                                    <td>{{$linea->concepto}}</td>
                                                    <td>{{$linea->forma_pago}}</td>
                                                    <td>{{$linea->debe}} €</td>
                                                    <td>{{$linea->haber}} €</td>
                                                    <td></td>
                                                    <td>
                                                        <button class="btn btn-warning">Editar</button>
                                                        <button class="btn btn-danger">Eliminar</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 is not loaded');
            return;
        }
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

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
