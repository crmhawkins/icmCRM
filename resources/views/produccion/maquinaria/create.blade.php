@extends('layouts.app')

@section('title', 'Crear Maquinaria')

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
                                <i class="fas fa-plus me-2"></i>
                                Crear Maquinaria
                            </h1>
                            <p class="text-muted mb-0">Añadir nueva maquinaria al sistema</p>
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
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs me-2"></i>
                            Información de la Maquinaria
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('maquinaria.store') }}" method="POST">
                            @csrf
                            
                            <!-- Información Básica -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Información Básica
                                    </h6>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label fw-bold">Nombre *</label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                               id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="codigo" class="form-label fw-bold">Código *</label>
                                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" 
                                               id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tipo" class="form-label fw-bold">Tipo *</label>
                                        <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="corte" {{ old('tipo') === 'corte' ? 'selected' : '' }}>Corte</option>
                                            <option value="doblado" {{ old('tipo') === 'doblado' ? 'selected' : '' }}>Doblado</option>
                                            <option value="soldadura" {{ old('tipo') === 'soldadura' ? 'selected' : '' }}>Soldadura</option>
                                            <option value="pintura" {{ old('tipo') === 'pintura' ? 'selected' : '' }}>Pintura</option>
                                            <option value="ensamblaje" {{ old('tipo') === 'ensamblaje' ? 'selected' : '' }}>Ensamblaje</option>
                                            <option value="otro" {{ old('tipo') === 'otro' ? 'selected' : '' }}>Otro</option>
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
                                            <option value="activa" {{ old('estado') === 'activa' ? 'selected' : '' }}>Activa</option>
                                            <option value="mantenimiento" {{ old('estado') === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                            <option value="fuera_servicio" {{ old('estado') === 'fuera_servicio' ? 'selected' : '' }}>Fuera de Servicio</option>
                                        </select>
                                        @error('estado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modelo" class="form-label fw-bold">Modelo</label>
                                        <input type="text" class="form-control @error('modelo') is-invalid @enderror" 
                                               id="modelo" name="modelo" value="{{ old('modelo') }}">
                                        @error('modelo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fabricante" class="form-label fw-bold">Fabricante</label>
                                        <input type="text" class="form-control @error('fabricante') is-invalid @enderror" 
                                               id="fabricante" name="fabricante" value="{{ old('fabricante') }}">
                                        @error('fabricante')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ano_fabricacion" class="form-label fw-bold">Año de Fabricación</label>
                                        <input type="number" class="form-control @error('ano_fabricacion') is-invalid @enderror" 
                                               id="ano_fabricacion" name="ano_fabricacion" value="{{ old('ano_fabricacion') }}"
                                               min="1900" max="{{ date('Y') + 1 }}">
                                        @error('ano_fabricacion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="numero_serie" class="form-label fw-bold">Número de Serie</label>
                                        <input type="text" class="form-control @error('numero_serie') is-invalid @enderror" 
                                               id="numero_serie" name="numero_serie" value="{{ old('numero_serie') }}">
                                        @error('numero_serie')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ubicacion" class="form-label fw-bold">Ubicación</label>
                                        <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" 
                                               id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}">
                                        @error('ubicacion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label fw-bold">Descripción</label>
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                                  id="descripcion" name="descripcion" rows="3" 
                                                  placeholder="Descripción detallada de la maquinaria">{{ old('descripcion') }}</textarea>
                                        @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Especificaciones Técnicas -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-cogs me-2"></i>
                                        Especificaciones Técnicas
                                    </h6>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="capacidad_maxima" class="form-label fw-bold">Capacidad Máxima</label>
                                        <input type="number" class="form-control @error('capacidad_maxima') is-invalid @enderror" 
                                               id="capacidad_maxima" name="capacidad_maxima" value="{{ old('capacidad_maxima') }}"
                                               step="0.01" min="0">
                                        @error('capacidad_maxima')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="unidad_capacidad" class="form-label fw-bold">Unidad</label>
                                        <select class="form-select @error('unidad_capacidad') is-invalid @enderror" id="unidad_capacidad" name="unidad_capacidad">
                                            <option value="">Seleccionar</option>
                                            <option value="kg" {{ old('unidad_capacidad') === 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                                            <option value="ton" {{ old('unidad_capacidad') === 'ton' ? 'selected' : '' }}>Toneladas (ton)</option>
                                            <option value="m" {{ old('unidad_capacidad') === 'm' ? 'selected' : '' }}>Metros (m)</option>
                                            <option value="mm" {{ old('unidad_capacidad') === 'mm' ? 'selected' : '' }}>Milímetros (mm)</option>
                                            <option value="cm" {{ old('unidad_capacidad') === 'cm' ? 'selected' : '' }}>Centímetros (cm)</option>
                                            <option value="m2" {{ old('unidad_capacidad') === 'm2' ? 'selected' : '' }}>Metros cuadrados (m²)</option>
                                            <option value="m3" {{ old('unidad_capacidad') === 'm3' ? 'selected' : '' }}>Metros cúbicos (m³)</option>
                                            <option value="l" {{ old('unidad_capacidad') === 'l' ? 'selected' : '' }}>Litros (L)</option>
                                        </select>
                                        @error('unidad_capacidad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="velocidad_operacion" class="form-label fw-bold">Velocidad de Operación</label>
                                        <input type="number" class="form-control @error('velocidad_operacion') is-invalid @enderror" 
                                               id="velocidad_operacion" name="velocidad_operacion" value="{{ old('velocidad_operacion') }}"
                                               step="0.01" min="0">
                                        @error('velocidad_operacion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="unidad_velocidad" class="form-label fw-bold">Unidad</label>
                                        <select class="form-select @error('unidad_velocidad') is-invalid @enderror" id="unidad_velocidad" name="unidad_velocidad">
                                            <option value="">Seleccionar</option>
                                            <option value="m/min" {{ old('unidad_velocidad') === 'm/min' ? 'selected' : '' }}>Metros por minuto (m/min)</option>
                                            <option value="m/s" {{ old('unidad_velocidad') === 'm/s' ? 'selected' : '' }}>Metros por segundo (m/s)</option>
                                            <option value="rpm" {{ old('unidad_velocidad') === 'rpm' ? 'selected' : '' }}>Revoluciones por minuto (rpm)</option>
                                            <option value="km/h" {{ old('unidad_velocidad') === 'km/h' ? 'selected' : '' }}>Kilómetros por hora (km/h)</option>
                                        </select>
                                        @error('unidad_velocidad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Tipos de Trabajo Asociados -->
                            @if(isset($tiposTrabajo) && $tiposTrabajo->count() > 0)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-tasks me-2"></i>
                                        Tipos de Trabajo Asociados
                                    </h6>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Selecciona los tipos de trabajo que puede realizar esta maquinaria y configura sus parámetros.
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50px;">Seleccionar</th>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Eficiencia (%)</th>
                                                    <th>Tiempo Setup (min)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tiposTrabajo as $tipoTrabajo)
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input tipo-trabajo-checkbox" type="checkbox" 
                                                                   name="tipos_trabajo[]" value="{{ $tipoTrabajo->id }}" 
                                                                   id="tipo_trabajo_{{ $tipoTrabajo->id }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ $tipoTrabajo->codigo }}</span>
                                                    </td>
                                                    <td>{{ $tipoTrabajo->nombre }}</td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm eficiencia-input" 
                                                               name="eficiencias[]" value="100" min="0" max="100" 
                                                               disabled style="width: 80px;">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm setup-input" 
                                                               name="tiempos_setup[]" value="0" min="0" 
                                                               disabled style="width: 80px;">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('maquinaria.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Crear Maquinaria
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
document.addEventListener('DOMContentLoaded', function() {
    // Validación del lado del cliente
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
    
    // Control de tipos de trabajo
    const checkboxes = document.querySelectorAll('.tipo-trabajo-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const row = this.closest('tr');
            const eficienciaInput = row.querySelector('.eficiencia-input');
            const setupInput = row.querySelector('.setup-input');
            
            if (this.checked) {
                eficienciaInput.disabled = false;
                setupInput.disabled = false;
                eficienciaInput.classList.remove('text-muted');
                setupInput.classList.remove('text-muted');
            } else {
                eficienciaInput.disabled = true;
                setupInput.disabled = true;
                eficienciaInput.classList.add('text-muted');
                setupInput.classList.add('text-muted');
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

.form-control-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.text-primary {
    color: #0d6efd !important;
}

.alert-info {
    background-color: rgba(13, 202, 240, 0.1);
    border-color: rgba(13, 202, 240, 0.2);
    color: #055160;
}

.table-sm td, .table-sm th {
    padding: 0.5rem;
    vertical-align: middle;
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

.text-muted {
    color: #6c757d !important;
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
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush
