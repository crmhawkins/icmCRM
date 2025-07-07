@extends('layouts.app')

@section('titulo', 'Editar Tarea')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendors/choices.js/choices.min.css') }}" />
@endsection

@section('content')
<div class="page-heading card" style="box-shadow: none !important">
    <div class="page-title card-body">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Editar Tarea</h3>
                <p class="text-subtitle text-muted">Formulario para editar una tarea</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tareas.index') }}">Tareas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar tarea</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section mt-4">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('tarea.update', $task->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="title">Título:</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $task->title) }}" readonly>
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="description">Descripción:</label>
                                    <textarea class="form-control" id="description" name="description" readonly>{{ old('description', $task->description) }}</textarea>
                                </div>

                                @if($isMaster && count($departamentos) > 0)
                                    @foreach ($departamentos as $departamento)
                                        <div class="col-12 mb-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">Departamento: {{ $departamento->name }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <button type="button" class="btn btn-info text-black btn-sm addEmployeeBtn" data-depto="{{ $departamento->id }}">
                                                        <i class="fas fa-plus"></i> Agregar Empleado
                                                    </button>
                                                    <table class="table-employees table table-striped table-bordered mt-3">
                                                        <thead>
                                                            <tr>
                                                                <th>Trabajador</th>
                                                                <th>H. Estimadas</th>
                                                                <th>H. Reales</th>
                                                                <th>Estado</th>
                                                                <th>Borrar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="employeeTable_{{ $departamento->id }}">
                                                            @foreach ($data as $row)
                                                                @if (isset($row['department_id']) && $row['department_id'] == $departamento->id)
                                                                    <tr>
                                                                        <td>{{ $row['trabajador'] }}</td>
                                                                        <td>{{ $row['horas_estimadas'] }}</td>
                                                                        <td>{{ $row['horas_reales'] }}</td>
                                                                        <td>{{ $status->where('id', $row['status'])->first()->name ?? 'Desconocido' }}</td>
                                                                        <td>
                                                                            <a class="btn btn-warning" href="{{ route('tarea.edit', $row['task_id']) }}" target="_blank"><i class="fa-solid fa-eye"></i></a>
                                                                            <button type="button" class="btn btn-danger removeEmployeeBtn"><i class="fa-solid fa-trash-can"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- SI NO ES MAESTRA, MOSTRAR INFORMACIÓN BÁSICA -->
                                    <div class="col-12 mb-3">
                                        <div class="alert alert-info" role="alert">
                                            Esta tarea no es maestra.
                                            <br>
                                            <strong>Tarea Maestra:</strong>
                                            <a href="{{ route('tarea.edit', $masterTask->id) }}">Ir a la Tarea Maestra</a>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Información de la Tarea - <strong>{{ $task->presupuestoConcepto->servicio->departamentos->first()->name ?? 'Sin Departamento' }}</strong> </h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Trabajador</th>
                                                            <th>H. Estimadas</th>
                                                            <th>H. Reales</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $row)
                                                            <tr>
                                                                <td>{{ $row['trabajador'] }}</td>
                                                                <td>{{ $row['horas_estimadas'] }}</td>
                                                                <td>{{ $row['horas_reales'] }}</td>
                                                                <td>{{ $status->where('id', $row['status'])->first()->name ?? 'Desconocido' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <div class="col-6 mb-3">
                                    <label for="priority">Prioridad:</label>
                                    <select name="priority" class="form-control" @if(!$isMaster) disabled @endif>
                                        @foreach($prioritys as $p)
                                        <option value="{{ $p->id }}" @if($p->id == $task->priority_id) selected @endif>{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="estimatedTimeFinal">Tiempo Estimado:</label>
                                    <input type="text" name="estimatedTimeFinal" class="form-control" value="{{ $task->estimated_time }}" @if(!$isMaster) readonly @endif>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="status">Estado:</label>
                                    <select name="status" class="form-control" @if(!$isMaster) disabled @endif>
                                        @foreach($status as $s)
                                        <option value="{{ $s->id }}" @if($s->id == $task->task_status_id) selected @endif>{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="taskId" value="{{ $task->id }}">
                            </div>

                            <div class="form-group mt-5">
                                @if($isMaster)

                                @else
                                    <button type="button" class="btn btn-secondary w-100 text-uppercase" disabled>
                                        {{ __('Actualizar (Sólo Tarea Maestra)') }}
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-body">
                    <h4 class="title-accion">Acciones<strong></strong></h4>
                    <hr>
                    <button type="submit" class="btn btn-secondary w-100 text-uppercase">
                        {{ __('Actualizar') }}
                    </button>
                    <a href="" class="btn btn-primary w-100 mt-3 text-uppercase">Ver Presupuesto</a>
                    <a href="" class="btn btn-success w-100 mt-3 text-uppercase">Finalizar Tareas</a>
                    <a href="" class="btn btn-warning w-100 mt-3 text-uppercase">Cambiar prioridad de todas las tareas</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


@section('scripts')
@include('partials.toast')
<script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // Al hacer clic en Actualizar
        $('#actualizarTarea').click(function(e) {
            e.preventDefault();
            $('form').submit();
        });

        // Botón para agregar empleado en un departamento (solo si es maestra)
        $('.addEmployeeBtn').click(function() {
            var deptoId = $(this).data('depto');
            var empleados = @json($employees);
            var employeeOptions = '';

            // Filtrar empleados del departamento actual
            empleados.map(function(empleado) {
                if (empleado.admin_user_department_id == deptoId) {
                    employeeOptions += '<option value="' + empleado.id + '">' + empleado.name + '</option>';
                }
            });

            var employeeRow = `
                <tr>
                    <td>
                        <select class="choices form-select" name="employeeId[]" class="form-control">
                            <option value="">Seleccione un empleado</option>
                            ${employeeOptions}
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="estimatedTime[]" value="00:00:00"></td>
                    <td><input type="text" class="form-control" name="realTime[]" value="00:00:00"></td>
                    <td>
                        <select class="choices form-select" name="status[]" class="form-control">
                            @foreach($status as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><button type="button" class="btn btn-danger removeEmployeeBtn">X</button></td>
                </tr>
            `;


            $('#employeeTable_' + deptoId).append(employeeRow);
        });
        console.log("Employee IDs:", $('select[name="employeeId[]"]').map(function(){ return $(this).val(); }).get());
console.log("Estimated Time:", $('input[name="estimatedTime[]"]').map(function(){ return $(this).val(); }).get());
console.log("Real Time:", $('input[name="realTime[]"]').map(function(){ return $(this).val(); }).get());
console.log("Status:", $('select[name="status[]"]').map(function(){ return $(this).val(); }).get());

        // Eliminar fila de empleado
        $(document).on('click', '.removeEmployeeBtn', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
@endsection
