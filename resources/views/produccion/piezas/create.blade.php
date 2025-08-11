@extends('layouts.app')

@section('title', 'Crear Nueva Pieza')

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
                        <li class="breadcrumb-item active">Crear Pieza</li>
                    </ol>
                </div>
                <h4 class="page-title">Crear Nueva Pieza</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('piezas.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Información Básica</h5>
                                
                                <div class="mb-3">
                                    <label for="pedido_id" class="form-label">Pedido *</label>
                                    <select class="form-select @error('pedido_id') is-invalid @enderror" id="pedido_id" name="pedido_id" required>
                                        <option value="">Seleccionar pedido</option>
                                        @foreach($pedidos as $pedido)
                                            <option value="{{ $pedido->id }}" {{ old('pedido_id') == $pedido->id ? 'selected' : '' }}>
                                                {{ $pedido->numero_pedido }} - {{ $pedido->nombre_cliente ?? 'Sin cliente' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pedido_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="codigo_pieza" class="form-label">Código de Pieza *</label>
                                            <input type="text" class="form-control @error('codigo_pieza') is-invalid @enderror" 
                                                   id="codigo_pieza" name="codigo_pieza" value="{{ old('codigo_pieza') }}" required>
                                            @error('codigo_pieza')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cantidad" class="form-label">Cantidad *</label>
                                            <input type="number" class="form-control @error('cantidad') is-invalid @enderror" 
                                                   id="cantidad" name="cantidad" value="{{ old('cantidad', 1) }}" min="1" required>
                                            @error('cantidad')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nombre_pieza" class="form-label">Nombre de la Pieza *</label>
                                    <input type="text" class="form-control @error('nombre_pieza') is-invalid @enderror" 
                                           id="nombre_pieza" name="nombre_pieza" value="{{ old('nombre_pieza') }}" required>
                                    @error('nombre_pieza')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                              id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="material" class="form-label">Material</label>
                                            <input type="text" class="form-control @error('material') is-invalid @enderror" 
                                                   id="material" name="material" value="{{ old('material') }}">
                                            @error('material')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="acabado" class="form-label">Acabado</label>
                                            <input type="text" class="form-control @error('acabado') is-invalid @enderror" 
                                                   id="acabado" name="acabado" value="{{ old('acabado') }}">
                                            @error('acabado')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-3">Dimensiones y Especificaciones</h5>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="dimensiones_largo" class="form-label">Largo</label>
                                            <input type="number" step="0.01" class="form-control @error('dimensiones_largo') is-invalid @enderror" 
                                                   id="dimensiones_largo" name="dimensiones_largo" value="{{ old('dimensiones_largo') }}" min="0">
                                            @error('dimensiones_largo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="dimensiones_ancho" class="form-label">Ancho</label>
                                            <input type="number" step="0.01" class="form-control @error('dimensiones_ancho') is-invalid @enderror" 
                                                   id="dimensiones_ancho" name="dimensiones_ancho" value="{{ old('dimensiones_ancho') }}" min="0">
                                            @error('dimensiones_ancho')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="dimensiones_alto" class="form-label">Alto</label>
                                            <input type="number" step="0.01" class="form-control @error('dimensiones_alto') is-invalid @enderror" 
                                                   id="dimensiones_alto" name="dimensiones_alto" value="{{ old('dimensiones_alto') }}" min="0">
                                            @error('dimensiones_alto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                                            <select class="form-select @error('unidad_medida') is-invalid @enderror" id="unidad_medida" name="unidad_medida">
                                                <option value="mm" {{ old('unidad_medida') == 'mm' ? 'selected' : '' }}>mm</option>
                                                <option value="cm" {{ old('unidad_medida') == 'cm' ? 'selected' : '' }}>cm</option>
                                                <option value="m" {{ old('unidad_medida') == 'm' ? 'selected' : '' }}>m</option>
                                                <option value="pulg" {{ old('unidad_medida') == 'pulg' ? 'selected' : '' }}>pulgadas</option>
                                            </select>
                                            @error('unidad_medida')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="peso_unitario" class="form-label">Peso Unitario</label>
                                            <input type="number" step="0.01" class="form-control @error('peso_unitario') is-invalid @enderror" 
                                                   id="peso_unitario" name="peso_unitario" value="{{ old('peso_unitario') }}" min="0">
                                            @error('peso_unitario')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="unidad_peso" class="form-label">Unidad de Peso</label>
                                            <select class="form-select @error('unidad_peso') is-invalid @enderror" id="unidad_peso" name="unidad_peso">
                                                <option value="kg" {{ old('unidad_peso') == 'kg' ? 'selected' : '' }}>kg</option>
                                                <option value="g" {{ old('unidad_peso') == 'g' ? 'selected' : '' }}>g</option>
                                                <option value="lb" {{ old('unidad_peso') == 'lb' ? 'selected' : '' }}>lb</option>
                                            </select>
                                            @error('unidad_peso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioridad" class="form-label">Prioridad *</label>
                                            <select class="form-select @error('prioridad') is-invalid @enderror" id="prioridad" name="prioridad" required>
                                                <option value="">Seleccionar prioridad</option>
                                                <option value="1" {{ old('prioridad') == '1' ? 'selected' : '' }}>1 - Muy Baja</option>
                                                <option value="2" {{ old('prioridad') == '2' ? 'selected' : '' }}>2 - Baja</option>
                                                <option value="3" {{ old('prioridad') == '3' ? 'selected' : '' }}>3 - Media-Baja</option>
                                                <option value="4" {{ old('prioridad') == '4' ? 'selected' : '' }}>4 - Media</option>
                                                <option value="5" {{ old('prioridad') == '5' ? 'selected' : '' }}>5 - Normal</option>
                                                <option value="6" {{ old('prioridad') == '6' ? 'selected' : '' }}>6 - Media-Alta</option>
                                                <option value="7" {{ old('prioridad') == '7' ? 'selected' : '' }}>7 - Alta</option>
                                                <option value="8" {{ old('prioridad') == '8' ? 'selected' : '' }}>8 - Muy Alta</option>
                                                <option value="9" {{ old('prioridad') == '9' ? 'selected' : '' }}>9 - Crítica</option>
                                                <option value="10" {{ old('prioridad') == '10' ? 'selected' : '' }}>10 - Urgente</option>
                                            </select>
                                            @error('prioridad')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Información Económica</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                            <input type="number" step="0.01" class="form-control @error('precio_unitario') is-invalid @enderror" 
                                                   id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario') }}" min="0">
                                            @error('precio_unitario')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tiempo_estimado_horas" class="form-label">Tiempo Estimado (horas)</label>
                                            <input type="number" step="0.01" class="form-control @error('tiempo_estimado_horas') is-invalid @enderror" 
                                                   id="tiempo_estimado_horas" name="tiempo_estimado_horas" value="{{ old('tiempo_estimado_horas') }}" min="0">
                                            @error('tiempo_estimado_horas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-3">Asignaciones</h5>
                                
                                <div class="mb-3">
                                    <label for="tipo_trabajo_id" class="form-label">Tipo de Trabajo</label>
                                    <select class="form-select @error('tipo_trabajo_id') is-invalid @enderror" id="tipo_trabajo_id" name="tipo_trabajo_id">
                                        <option value="">Seleccionar tipo de trabajo</option>
                                        @foreach($tiposTrabajo as $tipo)
                                            <option value="{{ $tipo->id }}" {{ old('tipo_trabajo_id') == $tipo->id ? 'selected' : '' }}>
                                                {{ $tipo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipo_trabajo_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="maquinaria_asignada_id" class="form-label">Maquinaria Asignada</label>
                                    <select class="form-select @error('maquinaria_asignada_id') is-invalid @enderror" id="maquinaria_asignada_id" name="maquinaria_asignada_id">
                                        <option value="">Seleccionar maquinaria</option>
                                        @foreach($maquinaria as $maq)
                                            <option value="{{ $maq->id }}" {{ old('maquinaria_asignada_id') == $maq->id ? 'selected' : '' }}>
                                                {{ $maq->nombre }} ({{ $maq->estado }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('maquinaria_asignada_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="usuario_asignado_id" class="form-label">Usuario Asignado</label>
                                    <select class="form-select @error('usuario_asignado_id') is-invalid @enderror" id="usuario_asignado_id" name="usuario_asignado_id">
                                        <option value="">Seleccionar usuario</option>
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}" {{ old('usuario_asignado_id') == $usuario->id ? 'selected' : '' }}>
                                                {{ $usuario->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('usuario_asignado_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Fechas Estimadas</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha_inicio_estimada" class="form-label">Fecha de Inicio Estimada</label>
                                            <input type="datetime-local" class="form-control @error('fecha_inicio_estimada') is-invalid @enderror" 
                                                   id="fecha_inicio_estimada" name="fecha_inicio_estimada" value="{{ old('fecha_inicio_estimada') }}">
                                            @error('fecha_inicio_estimada')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha_fin_estimada" class="form-label">Fecha de Fin Estimada</label>
                                            <input type="datetime-local" class="form-control @error('fecha_fin_estimada') is-invalid @enderror" 
                                                   id="fecha_fin_estimada" name="fecha_fin_estimada" value="{{ old('fecha_fin_estimada') }}">
                                            @error('fecha_fin_estimada')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Especificaciones Adicionales</h5>
                                
                                <div class="mb-3">
                                    <label for="especificaciones_tecnicas" class="form-label">Especificaciones Técnicas</label>
                                    <textarea class="form-control @error('especificaciones_tecnicas') is-invalid @enderror" 
                                              id="especificaciones_tecnicas" name="especificaciones_tecnicas" rows="3">{{ old('especificaciones_tecnicas') }}</textarea>
                                    @error('especificaciones_tecnicas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notas_fabricacion" class="form-label">Notas de Fabricación</label>
                                    <textarea class="form-control @error('notas_fabricacion') is-invalid @enderror" 
                                              id="notas_fabricacion" name="notas_fabricacion" rows="3">{{ old('notas_fabricacion') }}</textarea>
                                    @error('notas_fabricacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('piezas.index') }}" class="btn btn-secondary me-2">
                                        <i class="mdi mdi-arrow-left me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-content-save me-1"></i>Crear Pieza
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
    // Validación de fechas
    const fechaInicio = document.getElementById('fecha_inicio_estimada');
    const fechaFin = document.getElementById('fecha_fin_estimada');
    
    if (fechaInicio && fechaFin) {
        fechaInicio.addEventListener('change', function() {
            fechaFin.min = this.value;
        });
        
        fechaFin.addEventListener('change', function() {
            fechaInicio.max = this.value;
        });
    }
});
</script>
@endpush 