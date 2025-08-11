@extends('layouts.app')

@section('title', 'Gestión de Piezas')

@section('css')
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-heading card" style="box-shadow: none !important">
        {{-- Titulos --}}
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="fas fa-cube"></i> Piezas</h3>
                    <p class="text-subtitle text-muted">Gestión de piezas de producción</p>
                </div>

                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Piezas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section pt-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="{{ route('piezas.create') }}" class="btn btn-primary mb-2">
                                <i class="fas fa-plus me-2"></i>Nueva Pieza
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
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Pedido</th>
                                    <th>Cantidad</th>
                                    <th>Material</th>
                                    <th>Dimensiones</th>
                                    <th>Estado</th>
                                    <th>Prioridad</th>
                                    <th>Archivos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($piezas as $pieza)
                                <tr>
                                    <td>{{ $pieza->id }}</td>
                                    <td>
                                        <a href="{{ route('piezas.show', $pieza->id) }}" class="text-body fw-bold">
                                            {{ $pieza->codigo_pieza }}
                                        </a>
                                    </td>
                                    <td>{{ $pieza->nombre_pieza }}</td>
                                    <td>
                                        @if($pieza->pedido)
                                            <a href="{{ route('pedidos.show', $pieza->pedido->id) }}" class="text-body">
                                                {{ $pieza->pedido->numero_pedido }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $pieza->cantidad }}</td>
                                    <td>{{ $pieza->material ?? '-' }}</td>
                                    <td>
                                        @if($pieza->dimensiones_completas)
                                            <small>{{ $pieza->dimensiones_completas }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
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
                                        <div class="d-flex gap-1">
                                            @if($pieza->tiene_plano)
                                                <span class="badge bg-danger" title="Tiene plano PDF">
                                                    <i class="mdi mdi-file-pdf"></i>
                                                </span>
                                            @endif
                                            @if($pieza->tiene_daw)
                                                <span class="badge bg-primary" title="Tiene plano DAW">
                                                    <i class="mdi mdi-file-document"></i>
                                                </span>
                                            @endif
                                            @if(!$pieza->tiene_plano && !$pieza->tiene_daw)
                                                <span class="badge bg-secondary" title="Sin archivos">
                                                    <i class="fas fa-file-times"></i>
                                                </span>
                                            @endif
                                        </div>
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
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" title="Cambiar Estado">
                                                    <i class="fas fa-flag"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $pieza->id }}, 'pendiente')">
                                                        <i class="fas fa-clock me-1 text-secondary"></i>Marcar Pendiente
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $pieza->id }}, 'en_diseno')">
                                                        <i class="fas fa-pencil-ruler me-1 text-info"></i>Marcar En Diseño
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $pieza->id }}, 'en_fabricacion')">
                                                        <i class="fas fa-cog me-1 text-primary"></i>Marcar En Fabricación
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $pieza->id }}, 'en_control_calidad')">
                                                        <i class="fas fa-check-circle me-1 text-warning"></i>Marcar En Control
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $pieza->id }}, 'completada')">
                                                        <i class="fas fa-check me-1 text-success"></i>Marcar Completada
                                                    </a></li>
                                                </ul>
                                            </div>
                                            <form action="{{ route('piezas.destroy', $pieza->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta pieza?')" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <i class="fas fa-cube text-muted" style="font-size: 48px;"></i>
                                        <p class="text-muted mt-2">No hay piezas registradas</p>
                                        <a href="{{ route('piezas.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Crear Primera Pieza
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($piezas->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $piezas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para cambiar estado -->
<form id="formCambiarEstado" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="estado" id="estadoInput">
</form>

@endsection

@push('scripts')
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function cambiarEstado(piezaId, estado) {
    if (confirm('¿Estás seguro de que quieres cambiar el estado de esta pieza?')) {
        const form = document.getElementById('formCambiarEstado');
        const estadoInput = document.getElementById('estadoInput');

        form.action = `/produccion/piezas/${piezaId}/cambiar-estado`;
        estadoInput.value = estado;
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Gestión de Piezas inicializada con Bootstrap CDN');

    // Verificar que Bootstrap esté cargado
    if (typeof bootstrap !== 'undefined') {
        console.log('✅ Bootstrap cargado correctamente');
    } else {
        console.error('❌ Bootstrap no está cargado');
    }

    // Verificar iconos de Font Awesome
    const iconos = document.querySelectorAll('.fas, .fa');
    console.log(`✅ ${iconos.length} iconos de Font Awesome encontrados`);

    console.log('✅ Gestión de Piezas inicializada correctamente');
});
</script>
@endpush
