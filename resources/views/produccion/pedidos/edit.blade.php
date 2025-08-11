@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('produccion.dashboard') }}">Producción</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pedidos.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item active">Editar {{ $pedido->numero_pedido }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar Pedido: {{ $pedido->numero_pedido }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Información del Pedido</h5>
                                
                                <div class="mb-3">
                                    <label for="numero_pedido" class="form-label">Número de Pedido *</label>
                                    <input type="text" class="form-control @error('numero_pedido') is-invalid @enderror" 
                                           id="numero_pedido" name="numero_pedido" value="{{ old('numero_pedido', $pedido->numero_pedido) }}" required>
                                    @error('numero_pedido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="codigo_cliente" class="form-label">Código del Cliente</label>
                                    <input type="text" class="form-control @error('codigo_cliente') is-invalid @enderror" 
                                           id="codigo_cliente" name="codigo_cliente" value="{{ old('codigo_cliente', $pedido->codigo_cliente) }}">
                                    @error('codigo_cliente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
                                    <input type="text" class="form-control @error('nombre_cliente') is-invalid @enderror" 
                                           id="nombre_cliente" name="nombre_cliente" value="{{ old('nombre_cliente', $pedido->nombre_cliente) }}">
                                    @error('nombre_cliente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha_pedido" class="form-label">Fecha del Pedido</label>
                                            <input type="date" class="form-control @error('fecha_pedido') is-invalid @enderror" 
                                                   id="fecha_pedido" name="fecha_pedido" value="{{ old('fecha_pedido', $pedido->fecha_pedido ? $pedido->fecha_pedido->format('Y-m-d') : '') }}">
                                            @error('fecha_pedido')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha_entrega_estimada" class="form-label">Fecha de Entrega Estimada</label>
                                            <input type="date" class="form-control @error('fecha_entrega_estimada') is-invalid @enderror" 
                                                   id="fecha_entrega_estimada" name="fecha_entrega_estimada" value="{{ old('fecha_entrega_estimada', $pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('Y-m-d') : '') }}">
                                            @error('fecha_entrega_estimada')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion_general" class="form-label">Descripción General</label>
                                    <textarea class="form-control @error('descripcion_general') is-invalid @enderror" 
                                              id="descripcion_general" name="descripcion_general" rows="3">{{ old('descripcion_general', $pedido->descripcion_general) }}</textarea>
                                    @error('descripcion_general')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-3">Información Económica</h5>
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="valor_total" class="form-label">Valor Total</label>
                                            <input type="number" step="0.01" class="form-control @error('valor_total') is-invalid @enderror" 
                                                   id="valor_total" name="valor_total" value="{{ old('valor_total', $pedido->valor_total) }}">
                                            @error('valor_total')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="moneda" class="form-label">Moneda</label>
                                            <select class="form-select @error('moneda') is-invalid @enderror" id="moneda" name="moneda">
                                                <option value="EUR" {{ old('moneda', $pedido->moneda) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                                <option value="USD" {{ old('moneda', $pedido->moneda) == 'USD' ? 'selected' : '' }}>USD</option>
                                                <option value="GBP" {{ old('moneda', $pedido->moneda) == 'GBP' ? 'selected' : '' }}>GBP</option>
                                            </select>
                                            @error('moneda')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="archivo_pdf" class="form-label">Archivo PDF del Pedido</label>
                                    <input type="file" class="form-control @error('archivo_pdf') is-invalid @enderror" 
                                           id="archivo_pdf" name="archivo_pdf" accept=".pdf">
                                    <div class="form-text">
                                        @if($pedido->archivo_pdf_original)
                                            Archivo actual: <strong>{{ basename($pedido->archivo_pdf_original) }}</strong><br>
                                            Deja vacío para mantener el archivo actual
                                        @else
                                            Sube el archivo PDF del pedido para procesarlo con IA
                                        @endif
                                    </div>
                                    @error('archivo_pdf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notas_manuales" class="form-label">Notas Manuales</label>
                                    <textarea class="form-control @error('notas_manuales') is-invalid @enderror" 
                                              id="notas_manuales" name="notas_manuales" rows="3">{{ old('notas_manuales', $pedido->notas_manuales) }}</textarea>
                                    @error('notas_manuales')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if($pedido->procesado_ia)
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information-outline me-2"></i>
                                    <strong>Procesamiento IA:</strong> Este pedido ya ha sido procesado con IA. Si cambias el archivo PDF, el procesamiento se reseteará.
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <i class="mdi mdi-clock me-2"></i>
                                    <strong>Pendiente de IA:</strong> Este pedido aún no ha sido procesado con IA.
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-secondary me-2">
                                        <i class="mdi mdi-arrow-left me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-content-save me-1"></i>Actualizar Pedido
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del archivo PDF
    document.getElementById('archivo_pdf').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.type !== 'application/pdf') {
                alert('Por favor, selecciona un archivo PDF válido.');
                this.value = '';
            }
            
            if (file.size > 10 * 1024 * 1024) { // 10MB
                alert('El archivo es demasiado grande. El tamaño máximo es 10MB.');
                this.value = '';
            }
        }
    });
});
</script>
@endpush 