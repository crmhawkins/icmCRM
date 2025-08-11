@extends('layouts.app')

@section('title', 'Detalles del Pedido')

@section('css')
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    /* Estilos personalizados para pedidos */
    .page-heading {
        margin-bottom: 0 !important;
    }
    
    .page-title {
        padding: 1rem !important;
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
    
    .card-header {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid rgba(0,0,0,.125) !important;
        font-weight: 600 !important;
    }
    
    .card-header.bg-primary, .bg-primary .card-body {
        background-color: #0d6efd !important;
        color: white !important;
    }
    
    .card-header.bg-success,.bg-success .card-body{
        background-color: #198754 !important;
        color: rgb(55, 55, 55) !important;
    }
    
    .card-header.bg-warning, .bg-warning .card-body {
        background-color: #ffc107 !important;
        color: #ffffff !important;
    }
    
    .card-header.bg-info, .bg-info .card-body {
        background-color: #0dcaf0 !important;
        color: white !important;
    }
    
    /* Asegurar que los textos de los stats cards sean visibles */
    .bg-primary.text-white h4,
    .bg-primary.text-white p,
    .bg-primary.text-white i {
        color: white !important;
    }
    
    .bg-success.text-white h4,
    .bg-success.text-white p,
    .bg-success.text-white i {
        color: white !important;
    }
    
    .bg-warning.text-white h4,
    .bg-warning.text-white p,
    .bg-warning.text-white i {
        color: white !important;
    }
    
    .bg-info.text-white h4,
    .bg-info.text-white p,
    .bg-info.text-white i {
        color: white !important;
    }
    
    /* Asegurar que los iconos sean visibles */
    .fas, .fa {
        display: inline-block !important;
        font-style: normal !important;
        font-variant: normal !important;
        text-rendering: auto !important;
        -webkit-font-smoothing: antialiased !important;
    }
    
    /* Forzar colores en los stats cards */
    .card.bg-primary h4,
    .card.bg-primary p,
    .card.bg-primary i {
        color: white !important;
    }
    
    .card.bg-success h4,
    .card.bg-success p,
    .card.bg-success i {
        color: white !important;
    }
    
    .card.bg-warning h4,
    .card.bg-warning p,
    .card.bg-warning i {
        color: white !important;
    }
    
    .card.bg-info h4,
    .card.bg-info p,
    .card.bg-info i {
        color: white !important;
    }
    
    /* Estilos más específicos para forzar visibilidad */
    .card.bg-primary .card-body h4,
    .card.bg-primary .card-body p,
    .card.bg-primary .card-body i {
        color: white !important;
        text-shadow: none !important;
    }
    
    .card.bg-success .card-body h4,
    .card.bg-success .card-body p,
    .card.bg-success .card-body i {
        color: white !important;
        text-shadow: none !important;
    }
    
    .card.bg-warning .card-body h4,
    .card.bg-warning .card-body p,
    .card.bg-warning .card-body i {
        color: white !important;
        text-shadow: none !important;
    }
    
    .card.bg-info .card-body h4,
    .card.bg-info .card-body p,
    .card.bg-info .card-body i {
        color: white !important;
        text-shadow: none !important;
    }
    
    /* Estilos inline para máxima prioridad */
    .stats-text-white {
        color: white !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-heading card" style="box-shadow: none !important">
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-8 order-md-1 order-first">
                    <h3><i class="fas fa-shopping-cart me-2"></i> Pedido: {{ $pedido->numero_pedido }}</h3>
                    <p class="text-subtitle text-muted">Detalles del pedido y gestión de producción</p>
                </div>
                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('produccion.dashboard') }}">Producción</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pedidos.index') }}">Pedidos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pedido->numero_pedido }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <!-- Mensajes de sesión -->
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

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('mostrar_respuesta_ia'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="mdi mdi-robot me-2"></i>
                <strong>Análisis de IA completado:</strong> La respuesta de la IA se ha guardado. Revisa la información extraída antes de confirmar el procesamiento.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    <div class="row">
        <!-- Información del Pedido -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Número de Pedido</label>
                        <p class="text-muted">{{ $pedido->numero_pedido }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cliente</label>
                        <p class="text-muted">{{ $pedido->nombre_cliente ?? 'No especificado' }}</p>
                        @if($pedido->codigo_cliente)
                            <small class="text-muted">Código: {{ $pedido->codigo_cliente }}</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Estado</label>
                        <div>
                            <span class="badge bg-{{ $pedido->estado_color }}">
                                {{ $pedido->estado_texto }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Procesamiento IA</label>
                        <div>
                            @if($pedido->procesado_ia)
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Procesado con IA
                                </span>
                            @elseif($pedido->notas_ia)
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i>Respuesta IA Pendiente
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-clock me-1"></i>Pendiente de IA
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Botón para pasar a producción -->
                    @if($pedido->procesado_ia && $pedido->estado !== 'en_produccion' && $pedido->estado !== 'completado')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Acciones de Producción</label>
                        <div class="d-grid gap-2">
                            <form action="{{ route('pedidos.pasar-a-produccion', $pedido->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-lg w-100" onclick="return confirm('¿Estás seguro de que quieres pasar este pedido a producción? Se generarán automáticamente las tareas para cada departamento.')">
                                    <i class="fas fa-industry me-2"></i>Pasar a Producción
                                </button>
                            </form>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Esto generará automáticamente las órdenes de trabajo para cada pieza y las asignará a los departamentos correspondientes.
                        </small>
                    </div>
                    @endif

                    <!-- Botón para descargar PDF de producción -->
                    @if($pedido->procesado_ia && $pedido->piezas->count() > 0)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Documentos de Producción</label>
                        <div class="d-grid gap-2">
                            <a href="{{ route('pedidos.download-pdf-produccion', $pedido->id) }}" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-file-pdf me-2"></i>Descargar PDF de Producción
                            </a>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Descarga el PDF completo con todas las órdenes de producción de este pedido.
                        </small>
                    </div>
                    @endif

                    @if($pedido->estado === 'en_produccion')
                    <div class="mb-3">
                        <div class="alert alert-info">
                            <i class="fas fa-industry me-2"></i>
                            <strong>Pedido en Producción</strong><br>
                            El pedido está siendo procesado en producción. Puedes ver el progreso en la cola de trabajo.
                        </div>
                    </div>
                    @endif

                    <!-- Mostrar respuesta de IA si existe -->
                    @if($pedido->notas_ia && !$pedido->procesado_ia)
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-robot me-2"></i>Respuesta de la IA - Revisar antes de procesar
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Instrucciones:</strong> Revisa la respuesta de la IA antes de confirmar el procesamiento.
                                        Una vez confirmado, se crearán automáticamente las piezas y órdenes de trabajo.
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Respuesta de la IA:</label>
                                        <div class="border rounded p-3 bg-light">
                                            <pre class="mb-0" style="white-space: pre-wrap; font-family: 'Courier New', monospace; font-size: 12px;">{{ $pedido->notas_ia }}</pre>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <form action="{{ route('pedidos.confirmar-procesamiento-ia', $pedido->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success" onclick="return confirm('¿Estás seguro de que quieres procesar esta respuesta de IA? Se crearán las piezas automáticamente.')">
                                                <i class="fas fa-check me-1"></i>Confirmar y Procesar
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-secondary" onclick="reprocesarIA()">
                                            <i class="fas fa-redo me-1"></i>Reprocesar con IA
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Mostrar información de procesamiento IA si ya fue procesado -->
                    @if($pedido->procesado_ia)
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-check-circle me-2"></i>Procesamiento IA Completado
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Fecha de procesamiento:</strong> {{ $pedido->fecha_procesamiento_ia ? $pedido->fecha_procesamiento_ia->format('d/m/Y H:i:s') : 'N/A' }}</p>
                                            <p><strong>Piezas creadas:</strong> {{ $pedido->piezas->count() }}</p>
                                            <p><strong>Órdenes de trabajo generadas:</strong> {{ $pedido->piezas->where('tipo_trabajo_id', '!=', null)->count() }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Total piezas:</strong> {{ $pedido->total_piezas }}</p>
                                            <p><strong>Piezas completadas:</strong> {{ $pedido->piezas_completadas }}</p>
                                            <p><strong>Progreso general:</strong> {{ number_format($pedido->progreso, 1) }}%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Fechas</label>
                        <div>
                            <p class="text-muted mb-1">
                                <strong>Pedido:</strong> {{ $pedido->fecha_pedido ? $pedido->fecha_pedido->format('d/m/Y') : 'No especificada' }}
                            </p>
                            <p class="text-muted">
                                <strong>Entrega:</strong> {{ $pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('d/m/Y') : 'No especificada' }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Valor Total</label>
                        <p class="text-muted">
                            @if($pedido->valor_total)
                                {{ number_format($pedido->valor_total, 2) }} {{ $pedido->moneda }}
                            @else
                                No especificado
                            @endif
                        </p>
                    </div>

                    @if($pedido->descripcion_general)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <p class="text-muted">{{ $pedido->descripcion_general }}</p>
                    </div>
                    @endif

                    <div class="d-grid gap-2">
                        @if(!$pedido->procesado_ia)
                            <button type="button" class="btn btn-primary" onclick="procesarConIA({{ $pedido->id }})">
                                <i class="mdi mdi-robot me-1"></i>Procesar con IA
                            </button>
                        @endif
                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-outline-primary">
                            <i class="mdi mdi-pencil me-1"></i>Editar Pedido
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas y Piezas -->
        <div class="col-lg-8">
            <!-- Estadísticas -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 stats-text-white">{{ $pedido->total_piezas }}</h4>
                                    <p class="mb-0 stats-text-white">Total Piezas</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-cube fa-2x stats-text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 stats-text-white">{{ $pedido->piezas_completadas }}</h4>
                                    <p class="mb-0 stats-text-white">Completadas</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x stats-text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 stats-text-white">{{ $pedido->piezas_pendientes }}</h4>
                                    <p class="mb-0 stats-text-white">Pendientes</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x stats-text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0 stats-text-white">{{ $pedido->progreso }}%</h4>
                                    <p class="mb-0 stats-text-white">Progreso</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chart-line fa-2x stats-text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Piezas -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Piezas del Pedido</h5>
                    <a href="{{ route('piezas.create', ['pedido_id' => $pedido->id]) }}" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-plus me-1"></i>Agregar Pieza
                    </a>
                </div>
                <div class="card-body">
                    @if($pedido->piezas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>Material</th>
                                        <th>Estado</th>
                                        <th>Prioridad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pedido->piezas as $pieza)
                                    <tr>
                                        <td>
                                            <a href="{{ route('piezas.show', $pieza->id) }}" class="text-body fw-bold">
                                                {{ $pieza->codigo_pieza }}
                                            </a>
                                        </td>
                                        <td>{{ $pieza->nombre_pieza }}</td>
                                        <td>{{ $pieza->cantidad }}</td>
                                        <td>{{ $pieza->material ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $pieza->estado_color }}">
                                                {{ $pieza->estado_texto }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $pieza->prioridad_color }}">
                                                {{ $pieza->prioridad_texto }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('piezas.show', $pieza->id) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('piezas.edit', $pieza->id) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('seguimiento-pieza.show', $pieza->id) }}" class="btn btn-sm btn-outline-success" title="Seguimiento">
                                                    <i class="fas fa-chart-line"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-cube text-muted" style="font-size: 48px;"></i>
                            <p class="text-muted mt-2">No hay piezas registradas para este pedido</p>
                            <a href="{{ route('piezas.create', ['pedido_id' => $pedido->id]) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Agregar Primera Pieza
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Notas de IA -->
    @if($pedido->notas_ia)
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Análisis de IA</h5>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded">{{ $pedido->notas_ia }}</pre>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Notas Manuales -->
    @if($pedido->notas_manuales)
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Notas Manuales</h5>
                </div>
                <div class="card-body">
                    <p>{{ $pedido->notas_manuales }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    </section>
</div>

<!-- Formulario oculto para procesar con IA -->
<form id="formProcesarIA" method="POST" style="display: none;">
    @csrf
</form>

@endsection

@push('scripts')
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function procesarConIA(pedidoId) {
    if (confirm('¿Estás seguro de que quieres procesar este pedido con IA? Esto puede tomar unos minutos.')) {
        const form = document.getElementById('formProcesarIA');
        form.action = `/produccion/pedidos/${pedidoId}/procesar-ia`;
        form.submit();
    }
}

function reprocesarIA() {
    if (confirm('¿Estás seguro de que quieres reprocesar este pedido con IA? Se sobrescribirá la respuesta anterior.')) {
        const form = document.getElementById('formProcesarIA');
        form.action = `/produccion/pedidos/{{ $pedido->id }}/procesar-ia`;
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Detalles del Pedido inicializado con Bootstrap CDN');

    // Verificar que Bootstrap esté cargado
    if (typeof bootstrap !== 'undefined') {
        console.log('✅ Bootstrap cargado correctamente');
    } else {
        console.error('❌ Bootstrap no está cargado');
    }

    // Verificar iconos de Font Awesome
    const iconos = document.querySelectorAll('.fas, .fa');
    console.log(`✅ ${iconos.length} iconos de Font Awesome encontrados`);

    console.log('✅ Detalles del Pedido inicializado correctamente');
});
</script>
@endpush
