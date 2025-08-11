@extends('layouts.app')

@section('title', 'Cola de Trabajo')

@section('css')
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
/* ESTILOS BÁSICOS PARA BOTONES */
.btn-accion {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    margin: 2px !important;
    min-width: 35px !important;
    min-height: 35px !important;
    padding: 0.375rem 0.75rem !important;
    border: 1px solid transparent !important;
    border-radius: 0.25rem !important;
    text-decoration: none !important;
    cursor: pointer !important;
    transition: all 0.15s ease-in-out !important;
}

/* COLORES PARA BOTONES DE ACCIONES */
.btn-ver {
    color: #007bff !important;
    border-color: #007bff !important;
    background-color: transparent !important;
}

.btn-ver:hover {
    color: #fff !important;
    background-color: #007bff !important;
}

.btn-editar {
    color: #6c757d !important;
    border-color: #6c757d !important;
    background-color: transparent !important;
}

.btn-editar:hover {
    color: #fff !important;
    background-color: #6c757d !important;
}

.btn-estado {
    color: #ffc107 !important;
    border-color: #ffc107 !important;
    background-color: transparent !important;
}

.btn-estado:hover {
    color: #000 !important;
    background-color: #ffc107 !important;
}

.btn-asignar {
    color: #17a2b8 !important;
    border-color: #17a2b8 !important;
    background-color: transparent !important;
}

.btn-asignar:hover {
    color: #fff !important;
    background-color: #17a2b8 !important;
}

.btn-eliminar {
    color: #dc3545 !important;
    border-color: #dc3545 !important;
    background-color: transparent !important;
}

.btn-eliminar:hover {
    color: #fff !important;
    background-color: #dc3545 !important;
}

/* CONTENEDORES */
.acciones-container {
    min-width: 250px !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 4px !important;
    align-items: center !important;
}

.control-tiempo-container {
    min-width: 120px !important;
    text-align: center !important;
}

.control-tiempo-container .btn-group {
    margin-top: 4px !important;
         }

         .control-tiempo-container .btn-sm {
             padding: 0.25rem 0.5rem !important;
             font-size: 0.75rem !important;
         }

         .tiempo-transcurrido {
             font-weight: bold !important;
             color: #007bff !important;
         }

         .control-tiempo-container .badge {
             font-size: 0.7rem !important;
         }

/* Asegurar que los dropdowns de Bootstrap funcionen correctamente */
.dropdown-menu {
    position: absolute !important;
    z-index: 1000 !important;
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
                    <h3><i class="fas fa-list-ol"></i> Cola de Trabajo</h3>
                    <p class="text-subtitle text-muted">Gestión de órdenes de trabajo</p>
                </div>

                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cola de Trabajo</li>
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
                            <a href="{{ route('cola-trabajo.create') }}" class="btn btn-primary mb-2">
                                <i class="fas fa-plus me-2"></i>Nueva Orden
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

                    <!-- Filtros -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-select" id="filtro-estado">
                                <option value="">Todos los Estados</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="en_cola">En Cola</option>
                                <option value="en_proceso">En Proceso</option>
                                <option value="completado">Completado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filtro-tipo-trabajo">
                                <option value="">Todos los Tipos</option>
                                @foreach($tiposTrabajo as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filtro-maquinaria">
                                <option value="">Toda la Maquinaria</option>
                                @foreach($maquinaria as $maq)
                                    <option value="{{ $maq->id }}">{{ $maq->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filtro-prioridad">
                                <option value="">Todas las Prioridades</option>
                                <option value="1">1 - Muy Baja</option>
                                <option value="2">2 - Baja</option>
                                <option value="3">3 - Media-Baja</option>
                                <option value="4">4 - Media</option>
                                <option value="5">5 - Normal</option>
                                <option value="6">6 - Media-Alta</option>
                                <option value="7">7 - Alta</option>
                                <option value="8">8 - Muy Alta</option>
                                <option value="9">9 - Crítica</option>
                                <option value="10">10 - Urgente</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pieza</th>
                                    <th>Pedido</th>
                                    <th>Tipo Trabajo</th>
                                    <th>Maquinaria</th>
                                    <th>Cantidad</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    <th>Fechas</th>
                                    <th>Control Tiempo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($colaTrabajo as $orden)
                                <tr>
                                    <td>{{ $orden->id }}</td>
                                    <td>
                                        <div>
                                            @if($orden->pieza_id && $orden->pieza)
                                                <a href="{{ route('piezas.show', $orden->pieza_id) }}" class="text-body fw-bold">
                                                    {{ $orden->pieza->codigo_pieza ?? 'N/A' }}
                                                </a>
                                                <br><small class="text-muted">{{ $orden->pieza->nombre_pieza ?? 'Sin pieza' }}</small>
                                            @else
                                                <span class="text-muted">Sin pieza asignada</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($orden->pieza && $orden->pieza->pedido)
                                            <a href="{{ route('pedidos.show', $orden->pieza->pedido->id) }}" class="text-body">
                                                {{ $orden->pieza->pedido->numero_pedido }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($orden->tipoTrabajo)
                                            <span class="badge bg-info">{{ $orden->tipoTrabajo->nombre }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($orden->maquinaria)
                                            <span class="badge bg-secondary">{{ $orden->maquinaria->nombre }}</span>
                                        @else
                                            <span class="text-muted">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>{{ $orden->cantidad }}</td>
                                    <td>
                                        <span class="badge bg-{{ $orden->prioridad >= 8 ? 'danger' : ($orden->prioridad >= 6 ? 'warning' : 'success') }}">
                                            {{ $orden->prioridad }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $orden->estado_color }}">
                                            {{ $orden->estado_texto }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($orden->usuarioAsignado)
                                            {{ $orden->usuarioAsignado->name }}
                                        @else
                                            <span class="text-muted">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <small class="text-muted">
                                                <strong>Inicio:</strong> {{ $orden->fecha_inicio_estimada ? $orden->fecha_inicio_estimada->format('d/m/Y') : '-' }}<br>
                                                <strong>Fin:</strong> {{ $orden->fecha_fin_estimada ? $orden->fecha_fin_estimada->format('d/m/Y') : '-' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-tiempo-container" data-tarea-id="{{ $orden->id }}">
                                            <!-- Estado del tiempo -->
                                            <div class="mb-1">
                                                <span class="badge bg-{{ $orden->estado_tiempo_color ?? 'secondary' }}">
                                                    {{ $orden->estado_tiempo_texto ?? 'No Iniciado' }}
                                                </span>
                                            </div>

                                            <!-- Tiempo transcurrido -->
                                            <div class="mb-1">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i>
                                                    <span class="tiempo-transcurrido">{{ $orden->tiempo_transcurrido_formateado ?? '00:00' }}</span>
                                                </small>
                                            </div>

                                            <!-- Botones de control -->
                                            <div class="btn-group btn-group-sm" role="group">
                                                @if($orden->estado_tiempo === 'no_iniciado')
                                                    <button type="button" class="btn btn-success btn-sm" onclick="iniciarTrabajo({{ $orden->id }})" title="Iniciar Trabajo">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                @elseif($orden->estado_tiempo === 'en_progreso')
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="pausarTrabajo({{ $orden->id }})" title="Pausar">
                                                        <i class="fas fa-pause"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="finalizarTrabajo({{ $orden->id }})" title="Finalizar">
                                                        <i class="fas fa-stop"></i>
                                                    </button>
                                                @elseif($orden->estado_tiempo === 'pausado')
                                                    <button type="button" class="btn btn-success btn-sm" onclick="reanudarTrabajo({{ $orden->id }})" title="Reanudar">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="finalizarTrabajo({{ $orden->id }})" title="Finalizar">
                                                        <i class="fas fa-stop"></i>
                                                    </button>
                                                @elseif($orden->estado_tiempo === 'completado')
                                                    <div class="text-success">
                                                        <i class="fas fa-check"></i>
                                                        <small>{{ number_format($orden->tiempo_real_horas, 2) }}h</small>
                                                    </div>
                                                    @if($orden->eficiencia_porcentaje)
                                                        <div class="text-info">
                                                            <small>{{ $orden->eficiencia_porcentaje }}%</small>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                                                        <td>
                                        <div class="acciones-container">
                                            <!-- Botón Ver -->
                                            <a href="{{ route('cola-trabajo.show', $orden->id) }}" class="btn-accion btn-ver" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Botón Editar -->
                                            <a href="{{ route('cola-trabajo.edit', $orden->id) }}" class="btn-accion btn-editar" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Dropdown Estado -->
                                            <div class="dropdown">
                                                <button type="button" class="btn-accion btn-estado dropdown-toggle" data-bs-toggle="dropdown" title="Cambiar Estado">
                                                    <i class="fas fa-flag"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $orden->id }}, 'pendiente')">
                                                        <i class="fas fa-clock"></i> Marcar Pendiente
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $orden->id }}, 'en_cola')">
                                                        <i class="fas fa-list"></i> Marcar En Cola
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $orden->id }}, 'en_proceso')">
                                                        <i class="fas fa-cogs"></i> Marcar En Proceso
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="cambiarEstado({{ $orden->id }}, 'completado')">
                                                        <i class="fas fa-check"></i> Marcar Completado
                                                    </a></li>
                                                </ul>
                                            </div>

                                            <!-- Dropdown Asignaciones -->
                                            <div class="dropdown">
                                                <button type="button" class="btn-accion btn-asignar dropdown-toggle" data-bs-toggle="dropdown" title="Asignaciones">
                                                    <i class="fas fa-user"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="asignarMaquinaria({{ $orden->id }})">
                                                        <i class="fas fa-tools"></i> Asignar Maquinaria
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="asignarUsuario({{ $orden->id }})">
                                                        <i class="fas fa-user-tie"></i> Asignar Usuario
                                                    </a></li>
                                                </ul>
                                            </div>

                                            <!-- Botón Eliminar -->
                                            <form action="{{ route('cola-trabajo.destroy', $orden->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-accion btn-eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar esta orden?')" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <i class="fas fa-inbox text-muted" style="font-size: 48px;"></i>
                                        <p class="text-muted mt-2">No hay órdenes de trabajo en la cola</p>
                                        <a href="{{ route('cola-trabajo.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Crear Primera Orden
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($colaTrabajo->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $colaTrabajo->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formularios ocultos para acciones -->
<form id="formCambiarEstado" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="estado" id="estadoInput">
</form>

<form id="formAsignarMaquinaria" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="maquinaria_id" id="maquinariaInput">
</form>

<form id="formAsignarUsuario" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="usuario_id" id="usuarioInput">
</form>

@endsection

@push('scripts')
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Funciones para acciones
function cambiarEstado(ordenId, estado) {
    if (confirm('¿Estás seguro de que quieres cambiar el estado de esta orden?')) {
        const form = document.getElementById('formCambiarEstado');
        const estadoInput = document.getElementById('estadoInput');

        form.action = `/produccion/cola-trabajo/${ordenId}/cambiar-estado`;
        estadoInput.value = estado;
        form.submit();
    }
}

function asignarMaquinaria(ordenId) {
    const maquinariaId = prompt('Ingresa el ID de la maquinaria a asignar:');
    if (maquinariaId) {
        const form = document.getElementById('formAsignarMaquinaria');
        const maquinariaInput = document.getElementById('maquinariaInput');

        form.action = `/produccion/cola-trabajo/${ordenId}/asignar-maquinaria`;
        maquinariaInput.value = maquinariaId;
        form.submit();
    }
}

function asignarUsuario(ordenId) {
    const usuarioId = prompt('Ingresa el ID del usuario a asignar:');
    if (usuarioId) {
        const form = document.getElementById('formAsignarUsuario');
        const usuarioInput = document.getElementById('usuarioInput');

        form.action = `/produccion/cola-trabajo/${ordenId}/asignar-usuario`;
        usuarioInput.value = usuarioId;
        form.submit();
    }
}

// Inicialización con Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Inicializando sistema con Bootstrap CDN');

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

    // Configurar filtros
    const filtros = ['filtro-estado', 'filtro-tipo-trabajo', 'filtro-maquinaria', 'filtro-prioridad'];
    filtros.forEach(filtroId => {
        const elemento = document.getElementById(filtroId);
        if (elemento) {
            elemento.addEventListener('change', function() {
                console.log(`Filtro ${filtroId} cambiado a:`, this.value);
            });
        }
    });

    // Verificar iconos de Font Awesome
    const iconos = document.querySelectorAll('.fas, .fa');
    console.log(`✅ ${iconos.length} iconos de Font Awesome encontrados`);

    console.log('✅ Sistema inicializado correctamente');

    // Inicializar actualización de tiempos en tiempo real
    iniciarActualizacionTiempos();
});

       // Funciones para control de tiempo
       function iniciarTrabajo(tareaId) {
           if (confirm('¿Estás seguro de que quieres iniciar el trabajo en esta tarea?')) {
               fetch(`/control-tiempo/tarea/${tareaId}/iniciar`, {
                   method: 'POST',
                   headers: {
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                       'Content-Type': 'application/json'
                   }
               })
               .then(response => response.json())
               .then(data => {
                   if (data.success) {
                       mostrarNotificacion('Trabajo iniciado correctamente', 'success');
                       setTimeout(() => location.reload(), 1000);
                   } else {
                       mostrarNotificacion(data.message, 'error');
                   }
               })
               .catch(error => {
                   console.error('Error:', error);
                   mostrarNotificacion('Error al iniciar el trabajo', 'error');
               });
           }
       }

       function pausarTrabajo(tareaId) {
           fetch(`/control-tiempo/tarea/${tareaId}/pausar`, {
               method: 'POST',
               headers: {
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                   'Content-Type': 'application/json'
               }
           })
           .then(response => response.json())
           .then(data => {
               if (data.success) {
                   mostrarNotificacion('Trabajo pausado correctamente', 'success');
                   setTimeout(() => location.reload(), 1000);
               } else {
                   mostrarNotificacion(data.message, 'error');
               }
           })
           .catch(error => {
               console.error('Error:', error);
               mostrarNotificacion('Error al pausar el trabajo', 'error');
           });
       }

       function reanudarTrabajo(tareaId) {
           fetch(`/control-tiempo/tarea/${tareaId}/reanudar`, {
               method: 'POST',
               headers: {
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                   'Content-Type': 'application/json'
               }
           })
           .then(response => response.json())
           .then(data => {
               if (data.success) {
                   mostrarNotificacion('Trabajo reanudado correctamente', 'success');
                   setTimeout(() => location.reload(), 1000);
               } else {
                   mostrarNotificacion(data.message, 'error');
               }
           })
           .catch(error => {
               console.error('Error:', error);
               mostrarNotificacion('Error al reanudar el trabajo', 'error');
           });
       }

       function finalizarTrabajo(tareaId) {
           if (confirm('¿Estás seguro de que quieres finalizar el trabajo en esta tarea?')) {
               fetch(`/control-tiempo/tarea/${tareaId}/finalizar`, {
                   method: 'POST',
                   headers: {
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                       'Content-Type': 'application/json'
                   }
               })
               .then(response => response.json())
               .then(data => {
                   if (data.success) {
                       mostrarNotificacion('Trabajo finalizado correctamente', 'success');
                       setTimeout(() => location.reload(), 1000);
                   } else {
                       mostrarNotificacion(data.message, 'error');
                   }
               })
               .catch(error => {
                   console.error('Error:', error);
                   mostrarNotificacion('Error al finalizar el trabajo', 'error');
               });
           }
       }

       function iniciarActualizacionTiempos() {
           // Actualizar tiempos cada 30 segundos para tareas en progreso
           setInterval(() => {
               document.querySelectorAll('.control-tiempo-container').forEach(container => {
                   const tareaId = container.dataset.tareaId;
                   const tiempoElement = container.querySelector('.tiempo-transcurrido');

                   if (tiempoElement) {
                       fetch(`/control-tiempo/tarea/${tareaId}/info`)
                           .then(response => response.json())
                           .then(data => {
                               if (data.success && data.data.tiempo_transcurrido) {
                                   tiempoElement.textContent = data.data.tiempo_transcurrido;
                               }
                           })
                           .catch(error => console.error('Error actualizando tiempo:', error));
                   }
               });
           }, 30000); // 30 segundos
       }

       function mostrarNotificacion(mensaje, tipo) {
           const alertClass = tipo === 'success' ? 'alert-success' : 'alert-danger';
           const alertHtml = `
               <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                   ${mensaje}
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
           `;

           // Insertar al inicio del contenedor principal
           const container = document.querySelector('.container-fluid');
           container.insertAdjacentHTML('afterbegin', alertHtml);

           // Auto-ocultar después de 5 segundos
           setTimeout(() => {
               const alert = container.querySelector('.alert');
               if (alert) {
                   alert.remove();
               }
           }, 5000);
       }
</script>
@endpush
