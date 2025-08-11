@extends('layouts.app')

@section('title', 'Gestión de Maquinaria')

@section('css')
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
/* Estilos personalizados para maquinaria */
.btn-group {
    display: flex !important;
    gap: 2px !important;
}

.btn-sm {
    padding: 0.25rem 0.5rem !important;
    font-size: 0.875rem !important;
    border-radius: 0.375rem !important;
}

.dropdown-toggle::after {
    display: inline-block !important;
    margin-left: 0.255em !important;
    vertical-align: 0.255em !important;
    content: "" !important;
    border-top: 0.3em solid !important;
    border-right: 0.3em solid transparent !important;
    border-bottom: 0 !important;
    border-left: 0.3em solid transparent !important;
}

.dropdown-menu {
    display: none !important;
    position: absolute !important;
    z-index: 1000 !important;
    min-width: 10rem !important;
    padding: 0.5rem 0 !important;
    margin: 0 !important;
    font-size: 1rem !important;
    color: #212529 !important;
    text-align: left !important;
    list-style: none !important;
    background-color: #fff !important;
    background-clip: padding-box !important;
    border: 1px solid rgba(0,0,0,.15) !important;
    border-radius: 0.375rem !important;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175) !important;
}

.dropdown-menu.show {
    display: block !important;
}

.dropdown-item {
    display: block !important;
    width: 100% !important;
    padding: 0.25rem 1rem !important;
    clear: both !important;
    font-weight: 400 !important;
    color: #212529 !important;
    text-align: inherit !important;
    text-decoration: none !important;
    white-space: nowrap !important;
    background-color: transparent !important;
    border: 0 !important;
}

.dropdown-item:hover {
    color: #1e2125 !important;
    background-color: #e9ecef !important;
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
.bg-secondary { background-color: #6c757d !important; }
.bg-light { background-color: #f8f9fa !important; }
.text-dark { color: #212529 !important; }
.text-muted { color: #6c757d !important; }

.table th,
.table td {
    padding: 0.75rem !important;
    border-top: 1px solid #dee2e6 !important;
}

.btn {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
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
                    <h3><i class="fas fa-cog"></i> Maquinaria</h3>
                    <p class="text-subtitle text-muted">Gestión de maquinaria de producción</p>
                </div>

                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Maquinaria</li>
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
                            <a href="{{ route('maquinaria.create') }}" class="btn btn-primary mb-2">
                                <i class="fas fa-plus me-2"></i>Nueva Maquinaria
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
                                    <th>Modelo</th>
                                    <th>Fabricante</th>
                                    <th>Ubicación</th>
                                    <th>Estado</th>
                                    <th>Tipos de Trabajo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($maquinaria as $maq)
                                <tr>
                                    <td>{{ $maq->id }}</td>
                                    <td>
                                        <a href="{{ route('maquinaria.show', $maq->id) }}" class="text-body fw-bold">
                                            {{ $maq->codigo }}
                                        </a>
                                    </td>
                                    <td>{{ $maq->nombre }}</td>
                                    <td>{{ $maq->modelo ?? '-' }}</td>
                                    <td>{{ $maq->fabricante ?? '-' }}</td>
                                    <td>{{ $maq->ubicacion ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $maq->estado_color }}">
                                            {{ $maq->estado_texto }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($maq->tiposTrabajo->count() > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($maq->tiposTrabajo->take(3) as $tipo)
                                                    <span class="badge bg-light text-dark">
                                                        {{ $tipo->codigo }}
                                                    </span>
                                                @endforeach
                                                @if($maq->tiposTrabajo->count() > 3)
                                                    <span class="badge bg-secondary">
                                                        +{{ $maq->tiposTrabajo->count() - 3 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">Sin tipos asignados</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('maquinaria.show', $maq->id) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('maquinaria.edit', $maq->id) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" title="Cambiar Estado">
                                                    <i class="fas fa-flag"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $maq->id }}, 'operativa')">
                                                        <i class="fas fa-check-circle me-1 text-success"></i>Marcar Operativa
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $maq->id }}, 'mantenimiento')">
                                                        <i class="fas fa-wrench me-1 text-warning"></i>Marcar Mantenimiento
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $maq->id }}, 'reparacion')">
                                                        <i class="fas fa-exclamation-circle me-1 text-danger"></i>Marcar Reparación
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $maq->id }}, 'inactiva')">
                                                        <i class="fas fa-pause-circle me-1 text-secondary"></i>Marcar Inactiva
                                                    </a></li>
                                                </ul>
                                            </div>
                                            <form action="{{ route('maquinaria.destroy', $maq->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta maquinaria?')" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-cog text-muted" style="font-size: 48px;"></i>
                                        <p class="text-muted mt-2">No hay maquinaria registrada</p>
                                        <a href="{{ route('maquinaria.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Agregar Primera Maquinaria
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Gestión de Maquinaria inicializada con Bootstrap CDN');

    // Verificar que Bootstrap esté cargado
    if (typeof bootstrap !== 'undefined') {
        console.log('✅ Bootstrap cargado correctamente');

        // Inicializar todos los dropdowns de Bootstrap
        const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        dropdownElementList.forEach(function (dropdownToggleEl) {
            new bootstrap.Dropdown(dropdownToggleEl);
        });

        console.log(`✅ ${dropdownElementList.length} dropdowns de Bootstrap inicializados`);
    } else {
        console.error('❌ Bootstrap no está cargado');
    }

    // Verificar iconos de Font Awesome
    const iconos = document.querySelectorAll('.fas, .fa');
    console.log(`✅ ${iconos.length} iconos de Font Awesome encontrados`);

    // Verificar botones
    const botones = document.querySelectorAll('.btn');
    console.log(`✅ ${botones.length} botones encontrados`);

    console.log('✅ Gestión de Maquinaria inicializada correctamente');
});

function cambiarEstado(maquinariaId, estado) {
    if (confirm('¿Estás seguro de que quieres cambiar el estado de esta maquinaria?')) {
        const form = document.getElementById('formCambiarEstado');
        const estadoInput = document.getElementById('estadoInput');

        form.action = `/produccion/maquinaria/${maquinariaId}/cambiar-estado`;
        estadoInput.value = estado;
        form.submit();
    }
}
</script>
@endpush
