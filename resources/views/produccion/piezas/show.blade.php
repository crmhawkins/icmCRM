@extends('layouts.app')

@section('title', 'Detalles de la Pieza')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('produccion.dashboard') }}">Producción</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('piezas.index') }}">Piezas</a></li>
                        <li class="breadcrumb-item active">{{ $pieza->codigo_pieza }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Pieza: {{ $pieza->codigo_pieza }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información de la Pieza -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información de la Pieza</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Código de Pieza</label>
                        <p class="text-muted">{{ $pieza->codigo_pieza }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre</label>
                        <p class="text-muted">{{ $pieza->nombre_pieza }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pedido</label>
                        <p class="text-muted">
                            @if($pieza->pedido)
                                <a href="{{ route('pedidos.show', $pieza->pedido->id) }}" class="text-body">
                                    {{ $pieza->pedido->numero_pedido }}
                                </a>
                            @else
                                No asignado
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Estado</label>
                        <div>
                            <span class="badge bg-{{ $pieza->estado_color }}">
                                {{ $pieza->estado_texto }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prioridad</label>
                        <div>
                            <span class="badge bg-{{ $pieza->prioridad_color }}">
                                {{ $pieza->prioridad_texto }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cantidad</label>
                        <p class="text-muted">{{ $pieza->cantidad }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Material</label>
                        <p class="text-muted">{{ $pieza->material ?? 'No especificado' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Acabado</label>
                        <p class="text-muted">{{ $pieza->acabado ?? 'No especificado' }}</p>
                    </div>

                    @if($pieza->dimensiones_completas)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dimensiones</label>
                        <p class="text-muted">{{ $pieza->dimensiones_completas }}</p>
                    </div>
                    @endif

                    @if($pieza->peso_unitario)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Peso</label>
                        <p class="text-muted">{{ $pieza->peso_completo }}</p>
                    </div>
                    @endif

                    @if($pieza->precio_unitario)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Precio</label>
                        <p class="text-muted">
                            Unitario: {{ number_format($pieza->precio_unitario, 2) }} €<br>
                            Total: {{ number_format($pieza->precio_total, 2) }} €
                        </p>
                    </div>
                    @endif

                    <div class="d-grid gap-2">
                        <a href="{{ route('piezas.edit', $pieza->id) }}" class="btn btn-outline-primary">
                            <i class="mdi mdi-pencil me-1"></i>Editar Pieza
                        </a>
                        <a href="{{ route('seguimiento-pieza.show', $pieza->id) }}" class="btn btn-outline-success">
                            <i class="mdi mdi-chart-line me-1"></i>Seguimiento de Pieza
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archivos y Asignaciones -->
        <div class="col-lg-8">
            <!-- Archivos -->
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Archivos de la Pieza</h5>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
                        <i class="mdi mdi-upload me-1"></i>Subir Archivo
                    </button>
                </div>
                <div class="card-body">
                    @if($pieza->archivos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Tamaño</th>
                                        <th>Subido</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pieza->archivos as $archivo)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($archivo->es_principal)
                                                    <span class="badge bg-success me-2">Principal</span>
                                                @endif
                                                {{ $archivo->nombre_original }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $archivo->tipo_archivo_color }}">
                                                {{ $archivo->tipo_archivo_texto }}
                                            </span>
                                        </td>
                                        <td>{{ $archivo->tamaño_formateado }}</td>
                                        <td>{{ $archivo->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if($archivo->es_visualizable)
                                                    <a href="{{ $archivo->url_vista }}" class="btn btn-sm btn-outline-primary" target="_blank" title="Ver">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ $archivo->url_descarga }}" class="btn btn-sm btn-outline-secondary" title="Descargar">
                                                    <i class="mdi mdi-download"></i>
                                                </a>
                                                @if(!$archivo->es_principal)
                                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="marcarComoPrincipal({{ $archivo->id }})" title="Marcar como Principal">
                                                        <i class="mdi mdi-star"></i>
                                                    </button>
                                                @endif
                                                <form action="{{ route('archivos-piezas.destroy', $archivo->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este archivo?')" title="Eliminar">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="mdi mdi-file-remove text-muted" style="font-size: 48px;"></i>
                            <p class="text-muted mt-2">No hay archivos subidos para esta pieza</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
                                <i class="mdi mdi-upload me-2"></i>Subir Primer Archivo
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Asignaciones -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Asignaciones</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo de Trabajo</label>
                                <p class="text-muted">
                                    @if($pieza->tipoTrabajo)
                                        {{ $pieza->tipoTrabajo->nombre }}
                                    @else
                                        No asignado
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Maquinaria Asignada</label>
                                <p class="text-muted">
                                    @if($pieza->maquinariaAsignada)
                                        {{ $pieza->maquinariaAsignada->nombre }}
                                    @else
                                        No asignada
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Usuario Asignado</label>
                        <p class="text-muted">
                            @if($pieza->usuarioAsignado)
                                {{ $pieza->usuarioAsignado->name }}
                            @else
                                No asignado
                            @endif
                        </p>
                    </div>

                    @if($pieza->especificaciones_tecnicas)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Especificaciones Técnicas</label>
                        <p class="text-muted">{{ $pieza->especificaciones_tecnicas }}</p>
                    </div>
                    @endif

                    @if($pieza->notas_fabricacion)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Notas de Fabricación</label>
                        <p class="text-muted">{{ $pieza->notas_fabricacion }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para subir archivo -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('archivos-piezas.store', $pieza->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileModalLabel">Subir Archivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo *</label>
                        <input type="file" class="form-control" id="archivo" name="archivo" required>
                        <div class="form-text">Formatos permitidos: PDF, DAW, DWG, imágenes, documentos</div>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_archivo" class="form-label">Tipo de Archivo</label>
                        <select class="form-select" id="tipo_archivo" name="tipo_archivo" required>
                            <option value="plano_pdf">Plano PDF</option>
                            <option value="plano_daw">Plano DAW</option>
                            <option value="plano_dwg">Plano DWG</option>
                            <option value="imagen">Imagen</option>
                            <option value="documento">Documento</option>
                            <option value="especificacion">Especificación</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion_archivo" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion_archivo" name="descripcion" rows="3"></textarea>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="es_principal" name="es_principal">
                        <label class="form-check-label" for="es_principal">
                            Marcar como archivo principal
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Subir Archivo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Formulario oculto para marcar como principal -->
<form id="formMarcarPrincipal" method="POST" style="display: none;">
    @csrf
</form>

@endsection

@push('scripts')
<script>
function marcarComoPrincipal(archivoId) {
    if (confirm('¿Estás seguro de que quieres marcar este archivo como principal?')) {
        const form = document.getElementById('formMarcarPrincipal');
        form.action = `/produccion/archivos-piezas/${archivoId}/marcar-principal`;
        form.submit();
    }
}
</script>
@endpush
