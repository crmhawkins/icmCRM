@extends('layouts.app')

@section('title', 'Editar Maquinaria')

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
                                <i class="fas fa-edit me-2"></i>
                                Editar Maquinaria
                            </h1>
                            <p class="text-muted mb-0">Modificar información de la maquinaria</p>
                        </div>
                        <div class="page-title-right">
                            <a href="{{ route('maquinaria.show', $maquinaria) }}" class="btn btn-secondary">
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
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs me-2"></i>
                            Información de la Maquinaria
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('maquinaria.update', $maquinaria) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label fw-bold">Nombre *</label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                               id="nombre" name="nombre" value="{{ old('nombre', $maquinaria->nombre) }}" required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="codigo" class="form-label fw-bold">Código *</label>
                                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" 
                                               id="codigo" name="codigo" value="{{ old('codigo', $maquinaria->codigo) }}" required>
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tipo" class="form-label fw-bold">Tipo *</label>
                                        <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="corte" {{ old('tipo', $maquinaria->tipo) === 'corte' ? 'selected' : '' }}>Corte</option>
                                            <option value="doblado" {{ old('tipo', $maquinaria->tipo) === 'doblado' ? 'selected' : '' }}>Doblado</option>
                                            <option value="soldadura" {{ old('tipo', $maquinaria->tipo) === 'soldadura' ? 'selected' : '' }}>Soldadura</option>
                                            <option value="pintura" {{ old('tipo', $maquinaria->tipo) === 'pintura' ? 'selected' : '' }}>Pintura</option>
                                            <option value="ensamblaje" {{ old('tipo', $maquinaria->tipo) === 'ensamblaje' ? 'selected' : '' }}>Ensamblaje</option>
                                            <option value="otro" {{ old('tipo', $maquinaria->tipo) === 'otro' ? 'selected' : '' }}>Otro</option>
                                        </select>
                                        @error('tipo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="estado" class="form-label fw-bold">Estado *</label>
                                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                            <option value="">Seleccionar estado</option>
                                            <option value="activa" {{ old('estado', $maquinaria->estado) === 'activa' ? 'selected' : '' }}>Activa</option>
                                            <option value="mantenimiento" {{ old('estado', $maquinaria->estado) === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                            <option value="fuera_servicio" {{ old('estado', $maquinaria->estado) === 'fuera_servicio' ? 'selected' : '' }}>Fuera de Servicio</option>
                                        </select>
                                        @error('estado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ubicacion" class="form-label fw-bold">Ubicación</label>
                                        <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" 
                                               id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $maquinaria->ubicacion) }}">
                                        @error('ubicacion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="capacidad" class="form-label fw-bold">Capacidad</label>
                                        <input type="text" class="form-control @error('capacidad') is-invalid @enderror" 
                                               id="capacidad" name="capacidad" value="{{ old('capacidad', $maquinaria->capacidad) }}"
                                               placeholder="Ej: 1000 kg, 2m x 3m">
                                        @error('capacidad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                          id="descripcion" name="descripcion" rows="3" 
                                          placeholder="Descripción detallada de la maquinaria">{{ old('descripcion', $maquinaria->descripcion) }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="fecha_instalacion" class="form-label fw-bold">Fecha de Instalación</label>
                                <input type="date" class="form-control @error('fecha_instalacion') is-invalid @enderror" 
                                       id="fecha_instalacion" name="fecha_instalacion" 
                                       value="{{ old('fecha_instalacion', $maquinaria->fecha_instalacion ? \Carbon\Carbon::parse($maquinaria->fecha_instalacion)->format('Y-m-d') : '') }}">
                                @error('fecha_instalacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipos de Trabajo Asociados -->
                            @if(isset($tiposTrabajo) && $tiposTrabajo->count() > 0)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipos de Trabajo Asociados</label>
                                <div class="row">
                                    @foreach($tiposTrabajo as $tipoTrabajo)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="tipos_trabajo[]" value="{{ $tipoTrabajo->id }}" 
                                                   id="tipo_trabajo_{{ $tipoTrabajo->id }}"
                                                   {{ $maquinaria->tiposTrabajo->contains($tipoTrabajo->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tipo_trabajo_{{ $tipoTrabajo->id }}">
                                                {{ $tipoTrabajo->nombre }} ({{ $tipoTrabajo->codigo }})
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('maquinaria.show', $maquinaria) }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
// Validación del lado del cliente
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const requiredFields = form.querySelectorAll('[required]');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, completa todos los campos obligatorios.');
        }
    });
    
    // Limpiar validación al escribir
    requiredFields.forEach(field => {
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });
});
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
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.form-check {
    margin-bottom: 0.5rem;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5c636a;
    border-color: #565e64;
}

@media (max-width: 768px) {
    .page-title-box {
        flex-direction: column;
        text-align: center;
    }
    
    .page-title-right {
        margin-top: 1rem;
    }
    
    .d-flex.justify-content-end {
        flex-direction: column;
    }
    
    .gap-2 {
        gap: 0.5rem !important;
    }
}
</style>
@endpush
