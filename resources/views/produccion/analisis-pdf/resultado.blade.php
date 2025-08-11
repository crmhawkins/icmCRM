@extends('layouts.app')

@section('title', 'Resultado del Análisis de PDF')

@section('content')
<!-- Estilos CSS para el modal -->
<style>
.modal-backdrop {
    z-index: 9998 !important;
}
#modalRespuestaIA {
    z-index: 9999 !important;
}
#modalRespuestaIA .modal-dialog {
    z-index: 10000 !important;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('produccion.dashboard') }}">Producción</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('analisis-pdf.create') }}">Análisis de PDF</a></li>
                        <li class="breadcrumb-item active">Resultado</li>
                    </ol>
                </div>
                <h4 class="page-title">Resultado del Análisis de PDF</h4>
            </div>
        </div>
    </div>

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

    <div class="row">
        <!-- Información del Pedido -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header" style="background-color: #EA761C; color: white;">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-file-document me-2"></i>Información del Pedido
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Archivo:</label>
                        <p class="text-muted small">{{ Str::limit($nombreArchivo, 25) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nº Pedido:</label>
                        <p class="text-muted">{{ $datos['numero_pedido'] ?? 'No identificado' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cliente:</label>
                        <p class="text-muted small">{{ Str::limit($datos['cliente'] ?? 'No identificado', 20) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Fechas:</label>
                        <p class="text-muted small mb-1">
                            <strong>Pedido:</strong> {{ $datos['fecha_pedido'] ?? 'No especificada' }}
                        </p>
                        <p class="text-muted small">
                            <strong>Entrega:</strong> {{ $datos['fecha_entrega'] ?? 'No especificada' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Valor Total:</label>
                        <p class="text-muted">
                            @if(isset($datos['valor_total']))
                                {{ number_format($datos['valor_total'], 2) }} {{ $datos['moneda'] ?? 'EUR' }}
                            @else
                                No especificado
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Piezas:</label>
                        <p class="text-muted">{{ count($datos['piezas'] ?? []) }} piezas</p>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="reprocesarPDF()">
                            <i class="mdi mdi-refresh me-1"></i>Reprocesar
                        </button>
                        <a href="{{ route('analisis-pdf.create') }}" class="btn btn-outline-warning btn-sm" style="border-color: #EA761C; color: #EA761C;">
                            <i class="mdi mdi-upload me-1"></i>Nuevo PDF
                        </a>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="mostrarRespuestaIA()">
                            <i class="mdi mdi-code-json me-1"></i>Ver Respuesta IA
                        </button>
                        <a href="{{ route('analisis-pdf.previsualizar') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="mdi mdi-file-pdf me-1"></i>Previsualizar PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Piezas -->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-cube me-2"></i>Piezas Identificadas
                    </h5>
                    <span class="badge bg-light text-dark">{{ count($datos['piezas'] ?? []) }} piezas</span>
                </div>
                <div class="card-body">
                    @if(isset($datos['piezas']) && count($datos['piezas']) > 0)
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 12%;">Código</th>
                                        <th style="width: 35%;">Nombre</th>
                                        <th style="width: 8%;">Cant.</th>
                                        <th style="width: 15%;">Material</th>
                                        <th style="width: 20%;">Tipo Trabajo</th>
                                        <th style="width: 10%;">Precio</th>
                                        <th style="width: 10%;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos['piezas'] as $pieza)
                                    <tr>
                                        <td>
                                            <span class="fw-bold" style="color: #EA761C;">{{ $pieza['codigo_pieza'] ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-bold">{{ Str::limit($pieza['nombre_pieza'] ?? 'Sin nombre', 40) }}</div>
                                                @if(isset($pieza['descripcion']))
                                                    <small class="text-muted">{{ Str::limit($pieza['descripcion'], 35) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $pieza['cantidad'] ?? 1 }}</span>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($pieza['material'] ?? '-', 25) }}</small>
                                        </td>
                                        <td>
                                            @if(isset($pieza['tipo_trabajo']))
                                                <span class="badge bg-warning small">{{ Str::limit($pieza['tipo_trabajo'], 30) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($pieza['precio_unitario']))
                                                <span class="fw-bold">{{ number_format($pieza['precio_unitario'], 2) }} €</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($pieza['id']) && $pieza['id'])
                                                <a href="{{ route('seguimiento-pieza.show', $pieza['id']) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="mdi mdi-chart-line me-1"></i>Seguimiento
                                                </a>
                                            @else
                                                <small class="text-muted">
                                                    <i class="mdi mdi-information-outline me-1"></i>
                                                    Crear pedido primero
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="mdi mdi-cube text-muted" style="font-size: 48px;"></i>
                            <p class="text-muted mt-2">No se identificaron piezas en el PDF</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario para crear pedido -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-check-circle me-2"></i>Crear Pedido con Datos Extraídos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="mdi mdi-information-outline me-2"></i>
                        <strong>Instrucciones:</strong> Si los datos extraídos son correctos, puedes crear el pedido. 
                        Los campos se pre-llenan con la información extraída por la IA, pero puedes modificarlos si es necesario.
                    </div>

                    <form action="{{ route('analisis-pdf.crear-pedido') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="numero_pedido" class="form-label">Número de Pedido *</label>
                                    <input type="text" class="form-control @error('numero_pedido') is-invalid @enderror" 
                                           id="numero_pedido" name="numero_pedido" 
                                           value="{{ $datos['numero_pedido'] ?? '' }}" required>
                                    @error('numero_pedido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="codigo_cliente" class="form-label">Código de Cliente</label>
                                    <input type="text" class="form-control" id="codigo_cliente" name="codigo_cliente">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
                                    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" 
                                           value="{{ $datos['cliente'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="moneda" class="form-label">Moneda *</label>
                                    <select class="form-select" id="moneda" name="moneda" required>
                                        <option value="EUR" {{ ($datos['moneda'] ?? 'EUR') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                        <option value="USD" {{ ($datos['moneda'] ?? '') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                        <option value="GBP" {{ ($datos['moneda'] ?? '') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fecha_pedido" class="form-label">Fecha de Pedido</label>
                                    <input type="date" class="form-control" id="fecha_pedido" name="fecha_pedido" 
                                           value="{{ $datos['fecha_pedido'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fecha_entrega_estimada" class="form-label">Fecha de Entrega Estimada</label>
                                    <input type="date" class="form-control" id="fecha_entrega_estimada" name="fecha_entrega_estimada" 
                                           value="{{ $datos['fecha_entrega'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="valor_total" class="form-label">Valor Total</label>
                                    <input type="number" step="0.01" class="form-control" id="valor_total" name="valor_total" 
                                           value="{{ $datos['valor_total'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_general" class="form-label">Descripción General</label>
                            <textarea class="form-control" id="descripcion_general" name="descripcion_general" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="notas_manuales" class="form-label">Notas Manuales</label>
                            <textarea class="form-control" id="notas_manuales" name="notas_manuales" rows="2" 
                                      placeholder="Notas adicionales sobre el pedido..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="mdi mdi-check me-2"></i>Crear Pedido con {{ count($datos['piezas'] ?? []) }} Piezas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar respuesta de la IA -->
<div class="modal fade" id="modalRespuestaIA" tabindex="-1" role="dialog" aria-labelledby="modalRespuestaIALabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-xl" role="document" style="z-index: 10000;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #EA761C; color: white;">
                <h5 class="modal-title" id="modalRespuestaIALabel">
                    <i class="mdi mdi-robot me-2"></i>Respuesta Completa de la IA
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card" style="border-color: #EA761C;">
                            <div class="card-header" style="background-color: #EA761C; color: white;">
                                <h6 class="mb-0"><i class="mdi mdi-file-document me-2"></i>Información del Pedido</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p><strong>Número:</strong> {{ $datos['numero_pedido'] ?? 'N/A' }}</p>
                                        <p><strong>Cliente:</strong> {{ $datos['cliente'] ?? 'N/A' }}</p>
                                        <p><strong>Fecha Pedido:</strong> {{ $datos['fecha_pedido'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>Fecha Entrega:</strong> {{ $datos['fecha_entrega'] ?? 'N/A' }}</p>
                                        <p><strong>Valor Total:</strong> 
                                            @if(isset($datos['valor_total']))
                                                {{ number_format($datos['valor_total'], 2) }} {{ $datos['moneda'] ?? 'EUR' }}
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                        <p><strong>Total Piezas:</strong> {{ count($datos['piezas'] ?? []) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="mdi mdi-chart-pie me-2"></i>Resumen de Piezas</h6>
                            </div>
                            <div class="card-body">
                                @php
                                    $tiposTrabajo = collect($datos['piezas'] ?? [])->groupBy('tipo_trabajo')->map->count();
                                    $totalPrecio = collect($datos['piezas'] ?? [])->sum('precio_unitario');
                                @endphp
                                <p><strong>Tipos de Trabajo:</strong></p>
                                <ul class="list-unstyled">
                                    @foreach($tiposTrabajo as $tipo => $cantidad)
                                        <li><span class="badge bg-warning me-2">{{ $tipo }}</span> {{ $cantidad }} piezas</li>
                                    @endforeach
                                </ul>
                                <p><strong>Valor Total Piezas:</strong> {{ number_format($totalPrecio, 2) }} €</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="mdi mdi-code-json me-2"></i>JSON Completo</h6>
                    </div>
                    <div class="card-body">
                        <div class="border rounded p-3 bg-light">
                            <pre class="mb-0" style="white-space: pre-wrap; font-family: 'Courier New', monospace; font-size: 11px; max-height: 300px; overflow-y: auto;">{{ $respuestaIA }}</pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn" style="background-color: #EA761C; border-color: #EA761C; color: white;" onclick="copiarRespuesta()">
                    <i class="mdi mdi-content-copy me-1"></i>Copiar JSON
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para reprocesar -->
<form id="formReprocesar" method="POST" style="display: none;">
    @csrf
</form>

<!-- JavaScript inline para evitar problemas de carga -->
<script>
// Definir funciones globalmente
function reprocesarPDF() {
    if (confirm('¿Estás seguro de que quieres reprocesar el PDF? Se sobrescribirá el análisis actual.')) {
        const form = document.getElementById('formReprocesar');
        form.action = "{{ route('analisis-pdf.reprocesar') }}";
        form.submit();
    }
}

function mostrarRespuestaIA() {
    console.log('Intentando abrir modal...');
    if (typeof $ !== 'undefined') {
        try {
            $('#modalRespuestaIA').modal('show');
            console.log('Comando modal ejecutado');
        } catch (error) {
            console.error('Error al abrir modal:', error);
            alert('Error al abrir el modal. Revisa la consola para más detalles.');
        }
    } else {
        console.error('jQuery no está disponible');
        alert('jQuery no está disponible. El modal no puede abrirse.');
    }
}

function copiarRespuesta() {
    const jsonText = `{{ $respuestaIA }}`;
    navigator.clipboard.writeText(jsonText).then(function() {
        // Mostrar notificación de éxito
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="mdi mdi-check me-1"></i>Copiado!';
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-primary');
        }, 2000);
    }).catch(function(err) {
        console.error('Error al copiar: ', err);
        alert('Error al copiar al portapapeles');
    });
}

function cerrarModal() {
    if (typeof $ !== 'undefined') {
        $('#modalRespuestaIA').modal('hide');
    }
}

function testModal() {
    console.log('Test modal function called');
    console.log('jQuery available:', typeof $ !== 'undefined');
    if (typeof $ !== 'undefined') {
        console.log('jQuery version:', $.fn.jquery);
        console.log('Bootstrap modal method exists:', typeof $.fn.modal);
        console.log('Modal element exists:', $('#modalRespuestaIA').length);
        
        // Intentar abrir el modal de diferentes formas
        try {
            $('#modalRespuestaIA').modal('show');
            console.log('Modal show command executed');
        } catch (error) {
            console.error('Error with modal show:', error);
        }
    } else {
        console.error('jQuery no está disponible');
        alert('jQuery no está disponible');
    }
}

// Inicializar cuando el documento esté listo
$(document).ready(function() {
    console.log('Document ready - inicializando modal...');
    
    // Verificar que el modal existe
    console.log('Modal element:', $('#modalRespuestaIA').length);
    
    // Evento para mostrar modal
    $('#modalRespuestaIA').on('show.bs.modal', function () {
        console.log('Modal se está abriendo...');
    });
    
    $('#modalRespuestaIA').on('shown.bs.modal', function () {
        console.log('Modal está abierto');
    });
    
    // Evento para ocultar modal
    $('#modalRespuestaIA').on('hide.bs.modal', function () {
        console.log('Modal se está cerrando...');
    });
    
    $('#modalRespuestaIA').on('hidden.bs.modal', function () {
        console.log('Modal está cerrado');
    });
});
</script>
@endsection 