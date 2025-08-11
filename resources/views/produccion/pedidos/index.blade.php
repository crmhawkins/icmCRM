@extends('layouts.app')

@section('title', 'Gestión de Pedidos')

@section('css')
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
/* Estilos personalizados para pedidos */
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

.btn-group {
    display: inline-flex !important;
    position: relative !important;
    vertical-align: middle !important;
}

.btn-group .btn {
    position: relative !important;
    flex: 1 1 auto !important;
}

.btn-group .btn:not(:last-child) {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

.btn-group .btn:not(:first-child) {
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
    margin-left: -1px !important;
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

.bg-info { background-color: #0dcaf0 !important; }
.bg-success { background-color: #198754 !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-primary { background-color: #0d6efd !important; }
.bg-secondary { background-color: #6c757d !important; }
.bg-danger { background-color: #dc3545 !important; }

.table th,
.table td {
    padding: 0.75rem !important;
    border-top: 1px solid #dee2e6 !important;
}

/* Estados de pedidos */
.estado-pendiente { color: #ffc107 !important; }
.estado-analizado { color: #0dcaf0 !important; }
.estado-en-proceso { color: #0d6efd !important; }
.estado-completado { color: #198754 !important; }
.estado-cancelado { color: #dc3545 !important; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-heading card" style="box-shadow: none !important">
        {{-- Titulos --}}
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="fas fa-file-invoice"></i> Pedidos</h3>
                    <p class="text-subtitle text-muted">Gestión de pedidos de producción</p>
                </div>

                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="{{ route('pedidos.create') }}" class="btn btn-primary mb-2">
                                <i class="fas fa-plus me-2"></i>Nuevo Pedido
                            </a>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-success mb-2 me-1">
                                    <i class="fas fa-download me-1"></i> Exportar
                                </button>
                            </div>
                        </div>
                    </div>

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

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Número Pedido</th>
                                    <th>Cliente</th>
                                    <th>Fecha Pedido</th>
                                    <th>Entrega</th>
                                    <th>Piezas</th>
                                    <th>Valor Total</th>
                                    <th>Estado</th>
                                    <th>IA Procesado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>
                                        <a href="{{ route('pedidos.show', $pedido->id) }}" class="text-body fw-bold">
                                            {{ $pedido->numero_pedido }}
                                        </a>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">{{ $pedido->nombre_cliente ?? 'Sin cliente' }}</span>
                                            @if($pedido->codigo_cliente)
                                                <br><small class="text-muted">{{ $pedido->codigo_cliente }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $pedido->fecha_pedido ? $pedido->fecha_pedido->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info">{{ $pedido->piezas()->count() }}</span>
                                            @if($pedido->piezas_completadas > 0)
                                                <span class="badge bg-success ms-1">{{ $pedido->piezas_completadas }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($pedido->valor_total)
                                            <span class="fw-bold">{{ number_format($pedido->valor_total, 2) }} {{ $pedido->moneda }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $pedido->estado_color }}">
                                            {{ $pedido->estado_texto }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($pedido->procesado_ia)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Procesado
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if(!$pedido->procesado_ia)
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="procesarConIA({{ $pedido->id }})" title="Procesar con IA">
                                                <i class="fas fa-robot"></i>
                                            </button>
                                            @endif
                                            <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este pedido?')" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-file-alt text-muted" style="font-size: 48px;"></i>
                                        <p class="text-muted mt-2">No hay pedidos registrados</p>
                                        <a href="{{ route('pedidos.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Crear Primer Pedido
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($pedidos->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pedidos->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
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
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Gestión de Pedidos inicializada con Bootstrap CDN');

    // Verificar que Bootstrap esté cargado
    if (typeof bootstrap !== 'undefined') {
        console.log('✅ Bootstrap cargado correctamente');

        // Inicializar tooltips y popovers si es necesario
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
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

    console.log('✅ Gestión de Pedidos inicializada correctamente');
});

function procesarConIA(pedidoId) {
    if (confirm('¿Estás seguro de que quieres procesar este pedido con IA? Esto puede tomar unos minutos.')) {
        const form = document.getElementById('formProcesarIA');
        form.action = `/produccion/pedidos/${pedidoId}/procesar-ia`;
        form.submit();
    }
}
</script>
@endpush
