@extends('layouts.app')

@section('title', 'Detalles de Orden de Trabajo')

@section('css')
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
/* Estilos personalizados para cola de trabajo */
.page-title-box {
    padding: 1rem 0 !important;
    margin-bottom: 1rem !important;
}

.card {
    border: 1px solid rgba(0,0,0,.125) !important;
    transition: all 0.3s ease !important;
    background-color: #ffffff !important;
    margin-bottom: 1rem !important;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075) !important;
}

.card:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15) !important;
}

.card-header {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid rgba(0,0,0,.125) !important;
    padding: 0.75rem 1rem !important;
}

.card-header.bg-light {
    background-color: #e9ecef !important;
    border-bottom: 1px solid #dee2e6 !important;
}

.card-header h6 {
    color: #495057 !important;
    font-weight: 600 !important;
    margin: 0 !important;
}

.card-body {
    padding: 1rem !important;
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

.bg-success { background-color: #198754 !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-danger { background-color: #dc3545 !important; }
.bg-info { background-color: #0dcaf0 !important; }
.bg-secondary { background-color: #6c757d !important; }
.bg-primary { background-color: #0d6efd !important; }

/* Mejorar espaciado y organización */
.row {
    margin-left: -0.5rem !important;
    margin-right: -0.5rem !important;
}

.col-md-8, .col-md-4 {
    padding-left: 0.5rem !important;
    padding-right: 0.5rem !important;
}

/* Reducir scroll en panel lateral */
.col-md-4 .card {
    margin-bottom: 0.75rem !important;
}

.col-md-4 .card:last-child {
    margin-bottom: 0 !important;
}

/* Mejorar espaciado del contenido */
.text-muted {
    color: #6c757d !important;
    margin-bottom: 0.5rem !important;
}

strong {
    color: #495057 !important;
    font-weight: 600 !important;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .col-md-8, .col-md-4 {
        margin-bottom: 1rem !important;
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
                    <h3><i class="fas fa-clipboard-list"></i> Detalles de Orden de Trabajo</h3>
                    <p class="text-subtitle text-muted">Orden #{{ $colaTrabajo->codigo_trabajo ?? $colaTrabajo->id }}</p>
                </div>

                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('produccion.dashboard') }}">Producción</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('cola-trabajo.index') }}">Cola de Trabajo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detalles</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Orden #{{ $colaTrabajo->codigo_trabajo ?? $colaTrabajo->id }}
                        </h5>
                        <div>
                            <a href="{{ route('cola-trabajo.edit', $colaTrabajo) }}" class="btn btn-light btn-sm">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <a href="{{ route('cola-trabajo.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Información Principal -->
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información General</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Descripción:</strong></p>
                                            <p class="text-muted">{{ $colaTrabajo->descripcion_trabajo }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Especificaciones:</strong></p>
                                            <p class="text-muted">{{ $colaTrabajo->especificaciones ?: 'No especificadas' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <p><strong>Cantidad de Piezas:</strong></p>
                                            <p class="text-muted">{{ $colaTrabajo->cantidad_piezas }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Tiempo Estimado:</strong></p>
                                            <p class="text-muted">{{ $colaTrabajo->tiempo_estimado_horas ? $colaTrabajo->tiempo_estimado_horas . ' horas' : 'No especificado' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Tiempo Real:</strong></p>
                                            <p class="text-muted">{{ $colaTrabajo->tiempo_real_horas ? $colaTrabajo->tiempo_real_horas . ' horas' : 'No registrado' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de la Pieza -->
                            @if($colaTrabajo->pieza)
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-puzzle-piece me-2"></i>Información de la Pieza</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Código de Pieza:</strong></p>
                                            <p class="text-muted">{{ $colaTrabajo->pieza->codigo_pieza }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Nombre de Pieza:</strong></p>
                                            <p class="text-muted">{{ $colaTrabajo->pieza->nombre_pieza }}</p>
                                        </div>
                                    </div>

                                    @if($colaTrabajo->pieza->pedido)
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p><strong>Pedido:</strong></p>
                                            <p class="text-muted">{{ $colaTrabajo->pieza->pedido->codigo_pedido ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Cliente:</strong></p>
                                            <p class="text-muted">{{ $colaTrabajo->pieza->pedido->cliente->nombre ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Notas -->
                            @if($colaTrabajo->notas)
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Notas</h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">{{ $colaTrabajo->notas }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Panel Lateral -->
                        <div class="col-md-4">
                            <!-- Estado y Prioridad -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-flag me-2"></i>Estado y Prioridad</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <p><strong>Estado:</strong></p>
                                        <span class="badge bg-{{ $colaTrabajo->estado_color }}">{{ $colaTrabajo->estado_texto }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Prioridad:</strong></p>
                                        <span class="badge bg-{{ $colaTrabajo->prioridad_color }}">{{ $colaTrabajo->prioridad_texto }}</span>
                                    </div>

                                    <!-- Cambiar Estado -->
                                    <form action="{{ route('cola-trabajo.cambiar-estado', $colaTrabajo) }}" method="POST" class="mt-3">
                                        @csrf
                                        <div class="mb-2">
                                            <label class="form-label">Cambiar Estado:</label>
                                            <select name="estado" class="form-select form-select-sm">
                                                <option value="pendiente" {{ $colaTrabajo->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="en_cola" {{ $colaTrabajo->estado == 'en_cola' ? 'selected' : '' }}>En Cola</option>
                                                <option value="en_proceso" {{ $colaTrabajo->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                                <option value="completado" {{ $colaTrabajo->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                                                <option value="cancelado" {{ $colaTrabajo->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-check me-1"></i>Actualizar Estado
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Asignaciones -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Asignaciones</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <p><strong>Tipo de Trabajo:</strong></p>
                                        <p class="text-muted">{{ $colaTrabajo->tipoTrabajo->nombre ?? 'No asignado' }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Maquinaria:</strong></p>
                                        <p class="text-muted">{{ $colaTrabajo->maquinaria->nombre ?? 'No asignada' }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Usuario Asignado:</strong></p>
                                        <p class="text-muted">{{ $colaTrabajo->usuarioAsignado->name ?? 'No asignado' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Fechas -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Fechas</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <p><strong>Inicio Estimado:</strong></p>
                                        <p class="text-muted">{{ $colaTrabajo->fecha_inicio_estimada ? $colaTrabajo->fecha_inicio_estimada->format('d/m/Y H:i') : 'No especificada' }}</p>
                                    </div>

                                    <div class="mb-2">
                                        <p><strong>Fin Estimado:</strong></p>
                                        <p class="text-muted">{{ $colaTrabajo->fecha_fin_estimada ? $colaTrabajo->fecha_fin_estimada->format('d/m/Y H:i') : 'No especificada' }}</p>
                                    </div>

                                    <div class="mb-2">
                                        <p><strong>Inicio Real:</strong></p>
                                        <p class="text-muted">{{ $colaTrabajo->fecha_inicio_real ? $colaTrabajo->fecha_inicio_real->format('d/m/Y H:i') : 'No registrado' }}</p>
                                    </div>

                                    <div class="mb-2">
                                        <p><strong>Fin Real:</strong></p>
                                        <p class="text-muted">{{ $colaTrabajo->fecha_fin_real ? $colaTrabajo->fecha_fin_real->format('d/m/Y H:i') : 'No registrado' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Acciones</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('cola-trabajo.edit', $colaTrabajo) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit me-1"></i>Editar Orden
                                        </a>

                                        @if($colaTrabajo->pieza)
                                        <a href="{{ route('seguimiento-pieza.show', $colaTrabajo->pieza->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-chart-line me-1"></i>Seguimiento de Pieza
                                        </a>
                                        @endif

                                        <form action="{{ route('cola-trabajo.destroy', $colaTrabajo) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta orden de trabajo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                <i class="fas fa-trash me-1"></i>Eliminar Orden
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Detalles de Cola de Trabajo inicializada con Bootstrap CDN');

    // Verificar que Bootstrap esté cargado
    if (typeof bootstrap !== 'undefined') {
        console.log('✅ Bootstrap cargado correctamente');

        // Inicializar tooltips si existen
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        console.log(`✅ ${tooltipTriggerList.length} tooltips de Bootstrap inicializados`);
    } else {
        console.error('❌ Bootstrap no está cargado');
    }

    // Verificar iconos de Font Awesome
    const iconos = document.querySelectorAll('.fas, .fa');
    console.log(`✅ ${iconos.length} iconos de Font Awesome encontrados`);

    // Verificar botones
    const botones = document.querySelectorAll('.btn');
    console.log(`✅ ${botones.length} botones encontrados`);

    console.log('✅ Detalles de Cola de Trabajo inicializada correctamente');
});
</script>
@endpush
