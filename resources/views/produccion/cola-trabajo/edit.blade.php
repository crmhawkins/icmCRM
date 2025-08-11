@extends('layouts.app')

@section('title', 'Editar Orden de Trabajo')

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
                                Editar Orden de Trabajo
                            </h1>
                            <p class="text-muted mb-0">Modificar información de la orden de trabajo</p>
                        </div>
                        <div class="page-title-right">
                            <a href="{{ route('cola-trabajo.show', $colaTrabajo) }}" class="btn btn-secondary">
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
                            <i class="fas fa-clipboard-list me-2"></i>
                            Información de la Orden de Trabajo
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cola-trabajo.update', $colaTrabajo) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
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
                                        <label for="codigo_trabajo" class="form-label fw-bold">Código de Trabajo *</label>
                                        <input type="text" class="form-control @error('codigo_trabajo') is-invalid @enderror" 
                                               id="codigo_trabajo" name="codigo_trabajo" value="{{ old('codigo_trabajo', $colaTrabajo->codigo_trabajo) }}" required>
                                        @error('codigo_trabajo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label fw-bold">Descripción *</label>
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                                  id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $colaTrabajo->descripcion) }}</textarea>
                                        @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="estado" class="form-label fw-bold">Estado *</label>
                                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                            <option value="">Seleccionar estado</option>
                                            <option value="pendiente" {{ old('estado', $colaTrabajo->estado) === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                            <option value="en_proceso" {{ old('estado', $colaTrabajo->estado) === 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                            <option value="completado" {{ old('estado', $colaTrabajo->estado) === 'completado' ? 'selected' : '' }}>Completado</option>
                                            <option value="cancelado" {{ old('estado', $colaTrabajo->estado) === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                        </select>
                                        @error('estado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="prioridad" class="form-label fw-bold">Prioridad *</label>
                                        <select class="form-select @error('prioridad') is-invalid @enderror" id="prioridad" name="prioridad" required>
                                            <option value="">Seleccionar prioridad</option>
                                            <option value="baja" {{ old('prioridad', $colaTrabajo->prioridad) === 'baja' ? 'selected' : '' }}>Baja</option>
                                            <option value="media" {{ old('prioridad', $colaTrabajo->prioridad) === 'media' ? 'selected' : '' }}>Media</option>
                                            <option value="alta" {{ old('prioridad', $colaTrabajo->prioridad) === 'alta' ? 'selected' : '' }}>Alta</option>
                                            <option value="urgente" {{ old('prioridad', $colaTrabajo->prioridad) === 'urgente' ? 'selected' : '' }}>Urgente</option>
                                        </select>
                                        @error('prioridad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fecha_inicio_estimada" class="form-label fw-bold">Fecha de Inicio Estimada</label>
                                        <input type="date" class="form-control @error('fecha_inicio_estimada') is-invalid @enderror" 
                                               id="fecha_inicio_estimada" name="fecha_inicio_estimada" 
                                               value="{{ old('fecha_inicio_estimada', $colaTrabajo->fecha_inicio_estimada ? \Carbon\Carbon::parse($colaTrabajo->fecha_inicio_estimada)->format('Y-m-d') : '') }}">
                                        @error('fecha_inicio_estimada')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fecha_fin_estimada" class="form-label fw-bold">Fecha de Fin Estimada</label>
                                        <input type="date" class="form-control @error('fecha_fin_estimada') is-invalid @enderror" 
                                               id="fecha_fin_estimada" name="fecha_fin_estimada" 
                                               value="{{ old('fecha_fin_estimada', $colaTrabajo->fecha_fin_estimada ? \Carbon\Carbon::parse($colaTrabajo->fecha_fin_estimada)->format('Y-m-d') : '') }}">
                                        @error('fecha_fin_estimada')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tiempo_estimado_horas" class="form-label fw-bold">Tiempo Estimado (horas)</label>
                                        <input type="number" class="form-control @error('tiempo_estimado_horas') is-invalid @enderror" 
                                               id="tiempo_estimado_horas" name="tiempo_estimado_horas" 
                                               value="{{ old('tiempo_estimado_horas', $colaTrabajo->tiempo_estimado_horas) }}"
                                               step="0.5" min="0">
                                        @error('tiempo_estimado_horas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="notas" class="form-label fw-bold">Notas</label>
                                        <textarea class="form-control @error('notas') is-invalid @enderror" 
                                                  id="notas" name="notas" rows="2">{{ old('notas', $colaTrabajo->notas) }}</textarea>
                                        @error('notas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Asignaciones -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-users me-2"></i>
                                        Asignaciones
                                    </h6>
                                </div>
                                
                                @if(isset($tiposTrabajo) && $tiposTrabajo->count() > 0)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tipo_trabajo_id" class="form-label fw-bold">Tipo de Trabajo</label>
                                        <select class="form-select @error('tipo_trabajo_id') is-invalid @enderror" id="tipo_trabajo_id" name="tipo_trabajo_id">
                                            <option value="">Seleccionar tipo de trabajo</option>
                                            @foreach($tiposTrabajo as $tipoTrabajo)
                                                <option value="{{ $tipoTrabajo->id }}" {{ old('tipo_trabajo_id', $colaTrabajo->tipo_trabajo_id) == $tipoTrabajo->id ? 'selected' : '' }}>
                                                    {{ $tipoTrabajo->nombre }} ({{ $tipoTrabajo->codigo }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tipo_trabajo_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                
                                @if(isset($maquinaria) && $maquinaria->count() > 0)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="maquinaria_id" class="form-label fw-bold">Maquinaria</label>
                                        <select class="form-select @error('maquinaria_id') is-invalid @enderror" id="maquinaria_id" name="maquinaria_id">
                                            <option value="">Seleccionar maquinaria</option>
                                            @foreach($maquinaria as $maq)
                                                <option value="{{ $maq->id }}" {{ old('maquinaria_id', $colaTrabajo->maquinaria_id) == $maq->id ? 'selected' : '' }}>
                                                    {{ $maq->nombre }} ({{ $maq->codigo }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('maquinaria_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="usuario_asignado_id" class="form-label fw-bold">Usuario Asignado</label>
                                        <select class="form-select @error('usuario_asignado_id') is-invalid @enderror" id="usuario_asignado_id" name="usuario_asignado_id">
                                            <option value="">Seleccionar usuario</option>
                                            @foreach(\App\Models\Users\User::all() as $usuario)
                                                <option value="{{ $usuario->id }}" {{ old('usuario_asignado_id', $colaTrabajo->usuario_asignado_id) == $usuario->id ? 'selected' : '' }}>
                                                    {{ $usuario->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('usuario_asignado_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="proyecto_id" class="form-label fw-bold">Proyecto</label>
                                        <select class="form-select @error('proyecto_id') is-invalid @enderror" id="proyecto_id" name="proyecto_id">
                                            <option value="">Seleccionar proyecto</option>
                                            @if(isset($proyectos) && $proyectos->count() > 0)
                                                @foreach($proyectos as $proyecto)
                                                    <option value="{{ $proyecto->id }}" {{ old('proyecto_id', $colaTrabajo->proyecto_id) == $proyecto->id ? 'selected' : '' }}>
                                                        {{ $proyecto->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('proyecto_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Piezas Asociadas -->
                            @if(isset($piezas) && $piezas->count() > 0)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-cube me-2"></i>
                                        Piezas Asociadas
                                    </h6>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Selecciona las piezas que se procesarán en esta orden de trabajo.
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50px;">Seleccionar</th>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($piezas as $pieza)
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="piezas[]" value="{{ $pieza->id }}" 
                                                                   id="pieza_{{ $pieza->id }}"
                                                                   {{ $colaTrabajo->piezas && $colaTrabajo->piezas->contains($pieza->id) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ $pieza->codigo }}</span>
                                                    </td>
                                                    <td>{{ $pieza->nombre }}</td>
                                                    <td>{{ Str::limit($pieza->descripcion, 50) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $pieza->estado === 'activa' ? 'success' : 'danger' }}">
                                                            {{ ucfirst($pieza->estado) }}
                                                        </span>
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
                                     <a href="{{ route('cola-trabajo.show', $colaTrabajo) }}" class="btn btn-secondary">
                                         <i class="fas fa-times me-1"></i>
                                         Cancelar
                                     </a>
                                     <button type="submit" class="btn btn-primary">
                                         <i class="fas fa-save me-1"></i>
                                         Guardar Cambios
                                     </button>
                                 </div>
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
    
    // Validación de fechas
    const fechaInicio = document.getElementById('fecha_inicio_estimada');
    const fechaFin = document.getElementById('fecha_fin_estimada');
    
    if (fechaInicio && fechaFin) {
        fechaInicio.addEventListener('change', function() {
            if (fechaFin.value && this.value > fechaFin.value) {
                fechaFin.value = this.value;
            }
        });
        
        fechaFin.addEventListener('change', function() {
            if (fechaInicio.value && this.value < fechaInicio.value) {
                fechaInicio.value = this.value;
            }
        });
    }
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

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
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
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush
