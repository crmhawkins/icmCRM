@extends('layouts.app')

@section('title', 'Detalles de Maquinaria')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="page-heading card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="page-title">
                            <h1 class="h3 mb-0 text-gray-800">
                                <i class="fas fa-cogs me-2"></i>
                                Detalles de Maquinaria
                            </h1>
                            <p class="text-muted mb-0">Información detallada de la maquinaria</p>
                        </div>
                        <div class="page-title-right">
                            <a href="{{ route('maquinaria.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <section class="section pt-4">
        <div class="row g-4">
            <!-- Información Principal de la Maquinaria -->
            <div class="col-lg-8">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs me-2"></i>
                            Información de la Maquinaria
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nombre:</label>
                                    <p class="form-control-plaintext">{{ $maquinaria->nombre }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Código:</label>
                                    <p class="form-control-plaintext">{{ $maquinaria->codigo }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tipo:</label>
                                    <p class="form-control-plaintext">{{ $maquinaria->tipo }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Estado:</label>
                                    <span class="badge bg-{{ $maquinaria->estado === 'activa' ? 'success' : 'danger' }}">
                                        {{ ucfirst($maquinaria->estado) }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ubicación:</label>
                                    <p class="form-control-plaintext">{{ $maquinaria->ubicacion ?? 'No especificada' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Capacidad:</label>
                                    <p class="form-control-plaintext">{{ $maquinaria->capacidad ?? 'No especificada' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($maquinaria->descripcion)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción:</label>
                            <p class="form-control-plaintext">{{ $maquinaria->descripcion }}</p>
                        </div>
                        @endif

                        @if($maquinaria->fecha_instalacion)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Fecha de Instalación:</label>
                            <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($maquinaria->fecha_instalacion)->format('d/m/Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Panel Derecho - Estadísticas y Acciones -->
            <div class="col-lg-4">
                <!-- Estado de la Maquinaria -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2"></i>
                            Estado Actual
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-cogs fa-3x text-{{ $maquinaria->estado === 'activa' ? 'success' : 'danger' }}"></i>
                        </div>
                        <h4 class="text-{{ $maquinaria->estado === 'activa' ? 'success' : 'danger' }}">
                            {{ ucfirst($maquinaria->estado) }}
                        </h4>
                        <p class="text-muted mb-0">
                            @if($maquinaria->estado === 'activa')
                                Maquinaria operativa
                            @else
                                Maquinaria fuera de servicio
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-tools me-2"></i>
                            Acciones
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('maquinaria.edit', $maquinaria) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>
                                Editar
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminacion()">
                                <i class="fas fa-trash me-1"></i>
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tipos de Trabajo Asociados -->
        @if($maquinaria->tiposTrabajo && $maquinaria->tiposTrabajo->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tasks me-2"></i>
                            Tipos de Trabajo Asociados
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Tiempo Estimado</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maquinaria->tiposTrabajo as $tipoTrabajo)
                                    <tr>
                                        <td>
                                            <span class="badge bg-secondary">{{ $tipoTrabajo->codigo }}</span>
                                        </td>
                                        <td>{{ $tipoTrabajo->nombre }}</td>
                                        <td>{{ Str::limit($tipoTrabajo->descripcion, 50) }}</td>
                                        <td>{{ $tipoTrabajo->tiempo_estimado_horas ?? 'N/A' }}h</td>
                                        <td>
                                            <span class="badge bg-{{ $tipoTrabajo->activo ? 'success' : 'danger' }}">
                                                {{ $tipoTrabajo->activo ? 'Activo' : 'Inactivo' }}
                                            </span>
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
        @endif

        <!-- Trabajos Asignados -->
        @if($maquinaria->colaTrabajo && $maquinaria->colaTrabajo->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Trabajos Asignados
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Usuario</th>
                                        <th>Proyecto</th>
                                        <th>Estado</th>
                                        <th>Prioridad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maquinaria->colaTrabajo->take(5) as $trabajo)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">{{ $trabajo->codigo_trabajo }}</span>
                                        </td>
                                        <td>{{ Str::limit($trabajo->descripcion, 40) }}</td>
                                        <td>
                                            @if($trabajo->usuarioAsignado)
                                                {{ $trabajo->usuarioAsignado->name }}
                                            @else
                                                <span class="text-muted">Sin asignar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($trabajo->proyecto)
                                                {{ Str::limit($trabajo->proyecto->nombre, 30) }}
                                            @else
                                                <span class="text-muted">Sin proyecto</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $trabajo->estado === 'pendiente' ? 'warning' : ($trabajo->estado === 'en_proceso' ? 'info' : 'success') }}">
                                                {{ ucfirst(str_replace('_', ' ', $trabajo->estado)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $trabajo->prioridad === 'alta' ? 'danger' : ($trabajo->prioridad === 'media' ? 'warning' : 'success') }}">
                                                {{ ucfirst($trabajo->prioridad) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($maquinaria->colaTrabajo->count() > 5)
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                Ver todos los trabajos ({{ $maquinaria->colaTrabajo->count() }})
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
</div>

<!-- Modal de Confirmación para Eliminar -->
<div class="modal fade" id="confirmarEliminacionModal" tabindex="-1" aria-labelledby="confirmarEliminacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmarEliminacionModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres eliminar la maquinaria <strong>{{ $maquinaria->nombre }}</strong>?</p>
                <p class="text-danger mb-0">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('maquinaria.destroy', $maquinaria) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmarEliminacion() {
    const modal = new bootstrap.Modal(document.getElementById('confirmarEliminacionModal'));
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.card-header {
    border-bottom: none;
    font-weight: 600;
}

.form-label {
    color: #6c757d;
    font-size: 0.875rem;
}

.form-control-plaintext {
    color: #495057;
    font-weight: 500;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.table-sm td, .table-sm th {
    padding: 0.5rem;
    vertical-align: middle;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.avatar-sm {
    width: 3rem;
    height: 3rem;
}

.avatar-title {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.bg-soft-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.text-primary {
    color: #0d6efd !important;
}

@media (max-width: 768px) {
    .page-title-box {
        flex-direction: column;
        text-align: center;
    }
    
    .page-title-right {
        margin-top: 1rem;
    }
    
    .col-lg-8, .col-lg-4 {
        margin-bottom: 1rem;
    }
}
</style>
@endpush
