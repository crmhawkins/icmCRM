@extends('layouts.app')

@section('title', 'Dashboard de Producción')

@section('css')
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
/* Estilos personalizados para dashboard de producción */
.page-heading {
    margin-bottom: 0 !important;
}

.section {
    padding-top: 1.5rem !important;
}

.card {
    border: 1px solid rgba(0,0,0,.125) !important;
    transition: all 0.3s ease !important;
    background-color: #ffffff !important;
    margin-bottom: 1rem !important;
}

.card:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}

.card.h-100 {
    height: 100% !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075) !important;
}

.btn {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.btn-sm {
    padding: 0.25rem 0.5rem !important;
    font-size: 0.875rem !important;
    border-radius: 0.375rem !important;
}

.badge {
    display: inline-block !important;
    padding: 0.35em 0.65em !important;
    font-size: 0.75em !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    text-align: center !important;
    white-space: nowrap !important;
    vertical-align: baseline !important;
    border-radius: 0.375rem !important;
}

/* Colores de badges */
.bg-success { background-color: #198754 !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-danger { background-color: #dc3545 !important; }
.bg-info { background-color: #0dcaf0 !important; }
.bg-primary { background-color: #0d6efd !important; }
.bg-secondary { background-color: #6c757d !important; }

/* Asegurar que los iconos sean visibles */
.fas, .fa {
    display: inline-block !important;
    font-style: normal !important;
    font-variant: normal !important;
    text-rendering: auto !important;
    -webkit-font-smoothing: antialiased !important;
}

/* Avatar y estadísticas */
.avatar-sm {
    width: 3rem !important;
    height: 3rem !important;
}

.avatar-title {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
    border-radius: 0.375rem !important;
}

.bg-soft-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.font-20 {
    font-size: 1.25rem !important;
}

.text-primary {
    color: #0d6efd !important;
}

/* Tabla de tareas */
.table th,
.table td {
    padding: 0.75rem !important;
    border-top: 1px solid #dee2e6 !important;
}

/* Estados de tiempo */
.estado-tiempo {
    font-size: 0.875rem !important;
    font-weight: 500 !important;
}

.estado-pendiente { color: #6c757d !important; }
.estado-en-progreso { color: #0d6efd !important; }
.estado-pausado { color: #ffc107 !important; }
.estado-completado { color: #198754 !important; }

/* Botones de control de tiempo */
.btn-tiempo {
    padding: 0.25rem 0.5rem !important;
    font-size: 0.75rem !important;
    border-radius: 0.25rem !important;
}

/* Responsive */
@media (max-width: 768px) {
    .row.g-4 {
        margin-left: -0.5rem !important;
        margin-right: -0.5rem !important;
    }

    .col-xl-3, .col-md-6 {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-heading card" style="box-shadow: none !important">
        {{-- Titulos --}}
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="fas fa-industry"></i> Producción</h3>
                    <p class="text-subtitle text-muted">Dashboard de producción y gestión</p>
                </div>

                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Producción</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="section pt-4">
                    <!-- Estadísticas Generales -->
        <div class="row g-4 mb-4">
            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="text-muted fw-normal mt-0" title="Total de Pedidos">Total Pedidos</h5>
                                <h3 class="mt-3 mb-3">{{ $stats['total_pedidos'] }}</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2">
                                        <i class="fas fa-arrow-up"></i> {{ $stats['pedidos_este_mes'] }}
                                    </span>
                                    <span class="text-nowrap">Este mes</span>
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-soft-primary rounded">
                                    <i class="fas fa-file-alt font-20 text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="text-muted fw-normal mt-0" title="Total de Piezas">Total Piezas</h5>
                                <h3 class="mt-3 mb-3">{{ $stats['total_piezas'] }}</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2">
                                        <i class="fas fa-arrow-up"></i> {{ $stats['piezas_completadas'] }}
                                    </span>
                                    <span class="text-nowrap">Completadas</span>
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-soft-primary rounded">
                                    <i class="fas fa-cube font-20 text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="text-muted fw-normal mt-0" title="Total de Órdenes">Total Órdenes</h5>
                                <h3 class="mt-3 mb-3">{{ $stats['total_ordenes'] }}</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2">
                                        <i class="fas fa-arrow-up"></i> {{ $stats['ordenes_completadas'] }}
                                    </span>
                                    <span class="text-nowrap">Completadas</span>
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-soft-primary rounded">
                                    <i class="fas fa-clipboard-list font-20 text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="text-muted fw-normal mt-0" title="Eficiencia">Eficiencia</h5>
                                <h3 class="mt-3 mb-3">{{ $stats['eficiencia_promedio'] }}%</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2">
                                        <i class="fas fa-arrow-up"></i> +2.5%
                                    </span>
                                    <span class="text-nowrap">vs mes anterior</span>
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-soft-primary rounded">
                                    <i class="fas fa-chart-line font-20 text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Acciones Rápidas -->
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <a href="{{ route('pedidos.create') }}" class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-plus me-2"></i>Nuevo Pedido
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('cola-trabajo.create') }}" class="btn btn-success w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-tasks me-2"></i>Nueva Orden
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('maquinaria.create') }}" class="btn btn-info w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-cog me-2"></i>Nueva Maquinaria
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('tipos-trabajo.create') }}" class="btn btn-warning w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-tools me-2"></i>Nuevo Tipo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mis Tareas de Producción -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-clipboard-list me-2"></i>Mis Tareas de Producción
                                </h5>
                                <a href="{{ route('cola-trabajo.index') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Ver Todas
                                </a>
                            </div>

                            @if($tareasProduccion && $tareasProduccion->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Descripción</th>
                                                <th>Prioridad</th>
                                                <th>Estado</th>
                                                <th>Tiempo Estimado</th>
                                                <th>Control Tiempo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tareasProduccion->take(5) as $tarea)
                                            <tr data-tarea-id="{{ $tarea->id }}">
                                                <td>
                                                    <span class="badge bg-secondary">#{{ $tarea->id }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ Str::limit($tarea->descripcion_trabajo, 40) }}</strong>
                                                    @if($tarea->pieza)
                                                        <br><small class="text-muted">Pieza: {{ $tarea->pieza->codigo_pieza ?? 'N/A' }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $tarea->prioridad >= 8 ? 'danger' : ($tarea->prioridad >= 6 ? 'warning' : 'success') }}">
                                                        {{ $tarea->prioridad }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $tarea->estado_color }}">
                                                        {{ $tarea->estado_texto }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($tarea->tiempo_estimado_horas)
                                                        <span class="text-muted">{{ number_format($tarea->tiempo_estimado_horas, 1) }}h</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="control-tiempo" data-tarea-id="{{ $tarea->id }}">
                                                        @if($tarea->estado_tiempo == 'pendiente')
                                                            <button class="btn btn-success btn-sm btn-tiempo" onclick="iniciarTrabajo({{ $tarea->id }})">
                                                                <i class="fas fa-play"></i>
                                                            </button>
                                                        @elseif($tarea->estado_tiempo == 'en_progreso')
                                                            <div class="btn-group btn-group-sm">
                                                                <button class="btn btn-warning btn-tiempo" onclick="pausarTrabajo({{ $tarea->id }})">
                                                                    <i class="fas fa-pause"></i>
                                                                </button>
                                                                <button class="btn btn-success btn-tiempo" onclick="finalizarTrabajo({{ $tarea->id }})">
                                                                    <i class="fas fa-stop"></i>
                                                                </button>
                                                            </div>
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <i class="fas fa-clock"></i>
                                                                    <span class="tiempo-transcurrido" data-tarea-id="{{ $tarea->id }}">Calculando...</span>
                                                                </small>
                                                            </div>
                                                        @elseif($tarea->estado_tiempo == 'pausado')
                                                            <button class="btn btn-info btn-sm btn-tiempo" onclick="reanudarTrabajo({{ $tarea->id }})">
                                                                <i class="fas fa-play"></i>
                                                            </button>
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <i class="fas fa-pause"></i> Pausado
                                                                </small>
                                                            </div>
                                                        @elseif($tarea->estado_tiempo == 'completado')
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check"></i> Completado
                                                            </span>
                                                            @if($tarea->eficiencia_porcentaje)
                                                                <div class="mt-1">
                                                                    <small class="text-muted">
                                                                        Eficiencia: {{ number_format($tarea->eficiencia_porcentaje, 1) }}%
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('cola-trabajo.show', $tarea->id) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-clipboard-list text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-2">No tienes tareas de producción asignadas</p>
                                    <a href="{{ route('cola-trabajo.index') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Ver Órdenes Disponibles
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trabajos por Estado y Prioridad en la misma fila -->
            <div class="row g-4 mb-4">
                <!-- Trabajos por Estado -->
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-pie me-2"></i>Trabajos por Estado
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($trabajosPorEstado as $estado => $total)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <span class="badge bg-{{ $estado == 'pendiente' ? 'warning' : ($estado == 'en_proceso' ? 'info' : ($estado == 'completado' ? 'success' : 'secondary')) }} fs-6">
                                                {{ ucfirst(str_replace('_', ' ', $estado)) }}
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="mb-0">{{ $total }}</h4>
                                            <small class="text-muted">Trabajos</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trabajos por Prioridad -->
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>Trabajos por Prioridad
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($trabajosPorPrioridad as $prioridad => $total)
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <div class="badge bg-{{ $prioridad >= 8 ? 'danger' : ($prioridad >= 6 ? 'warning' : 'success') }} fs-5 mb-2">
                                            {{ $prioridad }}
                                        </div>
                                        <div class="h5 mb-0">{{ $total }}</div>
                                        <small class="text-muted">Trabajos</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Trabajos Urgentes -->
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-fire me-2"></i>Trabajos Urgentes
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($trabajosUrgentes && $trabajosUrgentes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Descripción</th>
                                                <th>Prioridad</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($trabajosUrgentes->take(3) as $trabajo)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-danger">#{{ $trabajo->id }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ Str::limit($trabajo->descripcion_trabajo, 30) }}</strong>
                                                    @if($trabajo->pieza)
                                                        <br><small class="text-muted">Pieza: {{ $trabajo->pieza->codigo_pieza ?? 'N/A' }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger">{{ $trabajo->prioridad }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $trabajo->estado_color }}">
                                                        {{ $trabajo->estado_texto }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('cola-trabajo.show', $trabajo->id) }}" class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($trabajosUrgentes->count() > 3)
                                        <div class="text-center mt-2">
                                            <a href="{{ route('cola-trabajo.index') }}" class="btn btn-outline-danger btn-sm">
                                                Ver todos ({{ $trabajosUrgentes->count() }})
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-fire text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-2">No hay trabajos urgentes</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
    
                <!-- Trabajos en Proceso -->
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cogs me-2"></i>Trabajos en Proceso
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($trabajosEnProcesoList && $trabajosEnProcesoList->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Descripción</th>
                                                <th>Tiempo</th>
                                                <th>Usuario</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($trabajosEnProcesoList->take(3) as $trabajo)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-info">#{{ $trabajo->id }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ Str::limit($trabajo->descripcion_trabajo, 30) }}</strong>
                                                    @if($trabajo->pieza)
                                                        <br><small class="text-muted">Pieza: {{ $trabajo->pieza->codigo_pieza ?? 'N/A' }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($trabajo->fecha_inicio_real)
                                                        <span class="text-info">
                                                            <i class="fas fa-clock"></i>
                                                            {{ \Carbon\Carbon::now()->diffForHumans($trabajo->fecha_inicio_real, true) }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($trabajo->usuarioAsignado)
                                                        <span class="badge bg-secondary">{{ $trabajo->usuarioAsignado->name }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('cola-trabajo.show', $trabajo->id) }}" class="btn btn-outline-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($trabajosEnProcesoList->count() > 3)
                                        <div class="text-center mt-2">
                                            <a href="{{ route('cola-trabajo.index') }}" class="btn btn-outline-info btn-sm">
                                                Ver todos ({{ $trabajosEnProcesoList->count() }})
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-cogs text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-2">No hay trabajos en proceso</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trabajos Urgentes y en Proceso en la misma fila -->
            <div class="row g-4 mb-4">
            </div>

            <!-- Maquinaria y Pedidos en la misma fila -->
            <div class="row g-4 mb-4">
                <!-- Maquinaria con Más Trabajo -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-industry me-2"></i>Maquinaria con Más Trabajo
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($maquinariaMasOcupada && $maquinariaMasOcupada->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>Maquinaria</th>
                                                <th>Trabajos</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($maquinariaMasOcupada->take(3) as $maquina)
                                            <tr>
                                                <td>
                                                    <strong>{{ $maquina->nombre }}</strong>
                                                    <br><small class="text-muted">{{ $maquina->tipo }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $maquina->trabajos_pendientes > 5 ? 'danger' : ($maquina->trabajos_pendientes > 2 ? 'warning' : 'success') }}">
                                                        {{ $maquina->trabajos_pendientes }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $maquina->estado == 'operativa' ? 'success' : ($maquina->estado == 'mantenimiento' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($maquina->estado) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('maquinaria.show', $maquina->id) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($maquinariaMasOcupada->count() > 3)
                                        <div class="text-center mt-2">
                                            <a href="{{ route('maquinaria.index') }}" class="btn btn-outline-primary btn-sm">
                                                Ver todas ({{ $maquinariaMasOcupada->count() }})
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-industry text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-2">No hay maquinaria con trabajos pendientes</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pedidos Recientes -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-shopping-cart me-2"></i>Pedidos Recientes
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($pedidosRecientes && $pedidosRecientes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Cliente</th>
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pedidosRecientes->take(3) as $pedido)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary">#{{ $pedido->id }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ Str::limit($pedido->nombre_cliente ?? 'N/A', 20) }}</strong>
                                                </td>
                                                <td>
                                                    {{ Str::limit($pedido->descripcion ?? 'Sin descripción', 40) }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $pedido->estado == 'completado' ? 'success' : ($pedido->estado == 'en_proceso' ? 'info' : 'warning') }}">
                                                        {{ ucfirst($pedido->estado ?? 'pendiente') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($pedidosRecientes->count() > 3)
                                        <div class="text-center mt-2">
                                            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-primary btn-sm">
                                                Ver todos ({{ $pedidosRecientes->count() }})
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-cart text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-2">No hay pedidos recientes</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Órdenes de Trabajo y Estado de Maquinaria en la misma fila -->
            <div class="row g-4 mb-4">
                <!-- Órdenes de Trabajo Recientes -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clipboard-check me-2"></i>Órdenes de Trabajo Recientes
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($ordenesRecientes && $ordenesRecientes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Pieza</th>
                                                <th>Tipo</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ordenesRecientes->take(3) as $orden)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-secondary">#{{ $orden->id }}</span>
                                                </td>
                                                <td>
                                                    @if($orden->pieza)
                                                        <strong>{{ Str::limit($orden->pieza->codigo_pieza ?? 'N/A', 20) }}</strong>
                                                        @if($orden->pieza->pedido)
                                                            <br><small class="text-muted">Pedido: {{ $orden->pieza->pedido->id }}</small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($orden->tipoTrabajo)
                                                        <span class="badge bg-info">{{ Str::limit($orden->tipoTrabajo->nombre, 15) }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $orden->estado_color }}">
                                                        {{ $orden->estado_texto }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('cola-trabajo.show', $orden->id) }}" class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($ordenesRecientes->count() > 3)
                                        <div class="text-center mt-2">
                                            <a href="{{ route('cola-trabajo.index') }}" class="btn btn-outline-secondary btn-sm">
                                                Ver todas ({{ $ordenesRecientes->count() }})
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-clipboard-check text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-2">No hay órdenes de trabajo recientes</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Estado de Maquinaria -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cogs me-2"></i>Estado de Maquinaria
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($estadoMaquinaria && $estadoMaquinaria->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>Maquinaria</th>
                                                <th>Estado</th>
                                                <th>Órdenes</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($estadoMaquinaria->take(3) as $maquina)
                                            <tr>
                                                <td>
                                                    <strong>{{ Str::limit($maquina->nombre, 20) }}</strong>
                                                    <br><small class="text-muted">{{ Str::limit($maquina->tipo, 15) }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $maquina->estado == 'operativa' ? 'success' : ($maquina->estado == 'mantenimiento' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($maquina->estado) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $maquina->ordenes_count > 5 ? 'danger' : ($maquina->ordenes_count > 2 ? 'warning' : 'success') }}">
                                                        {{ $maquina->ordenes_count }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('maquinaria.show', $maquina->id) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($estadoMaquinaria->count() > 3)
                                        <div class="text-center mt-2">
                                            <a href="{{ route('maquinaria.index') }}" class="btn btn-outline-primary btn-sm">
                                                Ver todas ({{ $estadoMaquinaria->count() }})
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-cogs text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-2">No hay maquinaria disponible</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Dashboard de Producción inicializado con Bootstrap CDN');

    // Verificar que Bootstrap esté cargado
    if (typeof bootstrap !== 'undefined') {
        console.log('✅ Bootstrap cargado correctamente');

        // Inicializar tooltips y popovers
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.forEach(function (popoverTriggerEl) {
            new bootstrap.Popover(popoverTriggerEl);
        });

        console.log(`✅ ${tooltipTriggerList.length} tooltips y ${popoverTriggerList.length} popovers inicializados`);
    } else {
        console.error('❌ Bootstrap no está cargado');
    }

    // Verificar iconos de Font Awesome
    const iconos = document.querySelectorAll('.fas, .fa');
    console.log(`✅ ${iconos.length} iconos de Font Awesome encontrados`);

    // Verificar botones
    const botones = document.querySelectorAll('.btn');
    console.log(`✅ ${botones.length} botones encontrados`);

    console.log('✅ Dashboard de Producción inicializado correctamente');
});

// Funciones para control de tiempo
function iniciarTrabajo(tareaId) {
    fetch(`/produccion/control-tiempo/${tareaId}/iniciar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al iniciar el trabajo: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al iniciar el trabajo');
    });
}

function pausarTrabajo(tareaId) {
    fetch(`/produccion/control-tiempo/${tareaId}/pausar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al pausar el trabajo: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al pausar el trabajo');
    });
}

function reanudarTrabajo(tareaId) {
    fetch(`/produccion/control-tiempo/${tareaId}/reanudar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al reanudar el trabajo: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al reanudar el trabajo');
    });
}

function finalizarTrabajo(tareaId) {
    fetch(`/produccion/control-tiempo/${tareaId}/finalizar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al finalizar el trabajo: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al finalizar el trabajo');
    });
}
</script>
@endpush
