@extends('layouts.app')

@section('titulo', 'Diagrama de Gantt')

<style>
    .css-96uzu9 {
        z-index: -1;
    }

    .stats-card {
        background: #fff;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .stats-number {
        font-size: 2rem;
        font-weight: bold;
    }

    .gantt-container {
        transition: all 0.3s ease;
        padding: 2rem;
    }

    .gantt-task-bar {
        height: 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
        position: relative;
        cursor: pointer;
    }

    .task-in-progress {
        background: #4CAF50;
    }

    .task-pending {
        background: #FFC107;
    }

    .task-completed {
        background: #2196F3;
    }

    .task-delayed {
        background: #f44336;
    }

    .task-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .zoom-button {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .zoom-button:hover {
        background: #e5e7eb;
    }

    .task-time {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .project-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #374151;
        margin: 1.5rem 0 1rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .project-title:hover {
        background-color: #f3f4f6;
    }

    .project-title.active {
        background-color: #e5e7eb;
        color: #1f2937;
    }

    .project-selector {
        position: relative;
        display: inline-block;
    }

    .project-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        z-index: 50;
        min-width: 200px;
        max-height: 300px;
        overflow-y: auto;
    }

    .project-dropdown.show {
        display: block;
    }

    .project-option {
        padding: 0.5rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .project-option:hover {
        background-color: #f3f4f6;
    }

    .gantt-timeline {
        width: 60%;
        margin-left: auto;
    }

    .task-date {
        font-size: 0.7rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .timeline-header {
        display: flex;
        margin-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 0.5rem;
    }

    .month-marker {
        padding: 0.5rem;
        font-size: 0.875rem;
        color: #4b5563;
        font-weight: 500;
        flex-shrink: 0;
        position: relative;
    }

    .month-marker::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        width: 1px;
        height: 8px;
        background-color: #e5e7eb;
    }

    .gantt-timeline {
        width: 100%;
        position: relative;
    }

    .gantt-task-bar {
        height: 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
        position: absolute;
        min-width: 20px;
        cursor: default;
    }

    /* Estados de las tareas */
    .task-resumed {
        background: #4CAF50;
    }

    .task-paused {
        background: #9e9e9e;
    }

    .task-completed {
        background: #2196F3;
    }

    .task-cancelled {
        background: #f44336;
    }

    .task-review {
        background: #FF9800;
    }

    .task-progress {
        position: absolute;
        height: 100%;
        left: 0;
        top: 0;
        border-radius: 6px;
    }

    .task-resumed .task-progress {
        background-color: rgba(0, 100, 0, 0.3);
    }

    .task-paused .task-progress {
        background-color: rgba(66, 66, 66, 0.3);
    }

    .task-completed .task-progress {
        background-color: rgba(13, 71, 161, 0.3);
    }

    .task-cancelled .task-progress {
        background-color: rgba(183, 28, 28, 0.3);
    }

    .task-review .task-progress {
        background-color: rgba(230, 81, 0, 0.3);
    }

    .warning-indicator {
        position: absolute;
        right: -20px;
        top: -2px;
        color: #f44336;
        font-size: 16px;
    }

    .progress-label {
        position: absolute;
        left: 4px;
        top: -16px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #1a1a1a;
        white-space: nowrap;
    }

    .task-info-modal {
        display: none;
        position: absolute;
        background: white;
        padding: 1rem;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        min-width: 200px;
        pointer-events: none;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 999;
        backdrop-filter: blur(2px);
    }

    .modal-container {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        width: 90%;
        max-width: 500px;
        overflow: hidden;
        padding: 1.5rem;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: white;
        position: relative;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2563eb;
        margin-right: 2rem;
    }

    .modal-close-btn {
        background: transparent;
        border: none;
        color: #6b7280;
        cursor: pointer;
        font-size: 1.5rem;
        line-height: 1;
        padding: 0.75rem;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        position: absolute;
        right: -0.5rem;
        top: -0.5rem;
    }

    .modal-close-btn:hover {
        background-color: #f3f4f6;
        color: #1f2937;
    }

    .modal-content {
        padding-right: 0.5rem;
        max-height: 70vh;
        overflow-y: auto;
    }

    .alert-item {
        padding: 1.25rem;
        border-bottom: 1px solid #e5e7eb;
        margin: 0 -1.5rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .alert-item:last-child {
        border-bottom: none;
        margin-bottom: -1.5rem;
    }

    .alert-title {
        font-weight: 600;
        color: #1f2937;
        font-size: 1.125rem;
        margin-bottom: 0.75rem;
    }

    .alert-project {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }

    .alert-delay {
        font-size: 0.875rem;
        color: #2563eb;
        background-color: #dbeafe;
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        display: inline-block;
    }

    .project-selector-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        margin-bottom: 2rem;
    }

    .project-header {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .delayed-tasks-indicator {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background-color: #FEF2F2;
        border: 1px solid #FCA5A5;
        border-radius: 0.375rem;
        color: #DC2626;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .delayed-tasks-indicator:hover {
        background-color: #FEE2E2;
    }
</style>

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Diagrama de Gantt</h1>
            <div class="flex gap-2">
                <button class="zoom-button" onclick="adjustZoom(1.1)">Zoom +</button>
                <button class="zoom-button" onclick="adjustZoom(0.9)">Zoom -</button>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="stats-card bg-blue-50">
                <div class="text-blue-600 stats-number" id="totalTasks">0</div>
                <div class="text-gray-600">Tareas Totales</div>
            </div>
            <div class="stats-card bg-green-50">
                <div class="text-green-600">
                    <span class="stats-number" id="totalTime">0</span>
                    <span class="text-sm ml-1">días laborales</span>
                </div>
                <div class="text-gray-600">Tiempo estimado (8h/día)</div>
            </div>
            <div class="stats-card bg-yellow-50">
                <div class="text-yellow-600 stats-number" id="inProduction">0</div>
                <div class="text-gray-600">En Producción</div>
            </div>
            <div class="stats-card">
                <div class="text-gray-800 font-medium mb-2">Estados Tarea</div>
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <div class="task-dot bg-green-500"></div>
                        <span class="text-sm text-gray-600">Reanudada</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="task-dot bg-gray-500"></div>
                        <span class="text-sm text-gray-600">Pausada</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="task-dot bg-blue-500"></div>
                        <span class="text-sm text-gray-600">Completada</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="task-dot bg-red-500"></div>
                        <span class="text-sm text-gray-600">Cancelada</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="task-dot bg-orange-500"></div>
                        <span class="text-sm text-gray-600">En Revisión</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gantt Chart -->
        <div class="gantt-chart overflow-x-auto">
            <div id="tasksContainer" class="gantt-container min-w-full">
                @php
                    $tasksByProject = collect($datos)->groupBy('id_proyecto');
                    
                    // Verificar que hay datos antes de usar first()
                    if ($tasksByProject->count() > 0) {
                        $firstProject = $tasksByProject->first();
                        $firstProjectId = key($tasksByProject->all());
                    } else {
                        $firstProject = collect();
                        $firstProjectId = null;
                    }

                    // Obtener todas las tareas retrasadas
                    $delayedTasks = collect($datos)->filter(function($task) {
                        if (!$task['fecha_fin']) return false;
                        $taskEnd = \Carbon\Carbon::parse($task['fecha_fin']);
                        return $task['progreso'] < 100 && $taskEnd->isPast() && $task['estado'] != 'completado';
                    });
                @endphp

                <div class="project-selector-wrapper">
                    <div class="project-selector">
                        <h3 class="project-title active" onclick="toggleProjectDropdown()" id="currentProject">
                            @if($firstProject->count() > 0)
                                {{ $firstProject->first()['proyecto'] }}
                            @else
                                Sin pedidos en producción
                            @endif
                            <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </h3>
                        <div class="project-dropdown" id="projectDropdown">
                            @foreach($tasksByProject as $projectId => $tasks)
                                <div class="project-option" 
                                     onclick="selectProject('{{ $projectId }}', '{{ $tasks->first()['proyecto'] }}')"
                                     data-project-id="{{ $projectId }}"
                                     data-total-tasks="{{ $tasks->count() }}"
                                     data-in-production="{{ $tasks->where('estado', 'en_proceso')->count() }}"
                                     data-total-time="@php
                                         $tiempoTotal = $tasks->sum(function($task) {
                                             if (!$task['duracion']) return 0;
                                             list($h, $m, $s) = array_pad(explode(':', $task['duracion']), 3, 0);
                                             $totalHoras = $h + ($m / 60) + ($s / 3600);
                                             return ceil($totalHoras / 8); // Convertir a días laborales de 8h
                                         });
                                         echo $tiempoTotal;
                                     @endphp">
                                    {{ $tasks->first()['proyecto'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @php
                        // Agrupar tareas retrasadas por proyecto
                        $delayedTasksByProject = $delayedTasks->groupBy('proyecto');
                        $totalDelayedTasks = $delayedTasks->count();
                    @endphp

                    @if($totalDelayedTasks > 0)
                        <div class="delayed-tasks-indicator" onclick="openModal()">
                            <span class="mr-2">⚠️</span>
                            {{ $totalDelayedTasks }} {{ $totalDelayedTasks === 1 ? 'tarea retrasada en total' : 'tareas retrasadas en total' }}
                        </div>
                    @endif
                </div>

                @if($tasksByProject->count() > 0)
                    @foreach($tasksByProject as $projectId => $tasks)
                        <div class="project-section" data-project-id="{{ $projectId }}" style="{{ $projectId != $firstProjectId ? 'display: none;' : '' }}">
                
                            @php
                                // Ordenar tareas por fecha de creación
                                $sortedTasks = $tasks->sortBy('fecha_creacion');
                                
                                // Obtener el rango de fechas para este proyecto
                                $projectStartDate = $sortedTasks->min('fecha_creacion');
                                $projectEndDate = $sortedTasks->max('fecha_creacion');
                                
                                // Crear array de meses entre las fechas
                                $startMonth = \Carbon\Carbon::parse($projectStartDate)->startOfMonth();
                                $endMonth = \Carbon\Carbon::parse($projectEndDate)->endOfMonth();
                                $months = [];
                                $currentMonth = $startMonth->copy();
                                
                                while ($currentMonth->lte($endMonth)) {
                                    $months[] = [
                                        'date' => $currentMonth->copy(),
                                        'position' => $currentMonth->diffInDays($startMonth) / $endMonth->diffInDays($startMonth) * 100
                                    ];
                                    $currentMonth->addMonth();
                                }
                            @endphp

                            <!-- Timeline Header con Meses -->
                            <div class="timeline-header">
                                <div class="w-1/5"></div>
                                <div class="w-2/3 relative mb-4">
                                    @foreach($months as $month)
                                        <div class="month-marker" style="position: absolute; left: {{ $month['position'] }}%">
                                            {{ $month['date']->format('M Y') }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-data-message" style="text-align: center; padding: 50px; color: #666;">
                        <h3>📊 Diagrama de Gantt de Producción</h3>
                        <p>No hay pedidos en producción actualmente.</p>
                        <p>Para ver el diagrama de Gantt, necesitas:</p>
                        <ul style="text-align: left; display: inline-block; margin: 20px 0;">
                            <li>✅ Crear pedidos en el sistema</li>
                            <li>✅ Procesarlos con IA</li>
                            <li>✅ Pasar los pedidos a producción</li>
                            <li>✅ Generar órdenes de trabajo</li>
                        </ul>
                        <p><strong>El diagrama mostrará:</strong></p>
                        <ul style="text-align: left; display: inline-block; margin: 20px 0;">
                            <li>📅 Fechas de inicio y fin de cada tarea</li>
                            <li>⏱️ Tiempos estimados vs. reales</li>
                            <li>📈 Progreso de cada pieza</li>
                            <li>🏭 Estado de cada orden de trabajo</li>
                            <li>⚠️ Tareas retrasadas</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal para información de la tarea -->
<div id="taskInfoModal" class="task-info-modal">
    <h3 class="text-lg font-semibold mb-2" id="modalTaskName"></h3>
    <div class="space-y-1">
        <p class="text-gray-700">
            Progreso: <span id="modalProgress" class="font-medium"></span>
        </p>
        <p class="text-gray-700">
            Duración total: <span id="modalDuration" class="font-medium"></span>
        </p>
    </div>
</div>

<!-- Modal de alertas -->
<div id="modalOverlay" class="modal-overlay"></div>
<div id="modalContainer" class="modal-container">
    <div class="modal-header">
        <h3 class="modal-title">Listado de Alertas</h3>
        <button class="modal-close-btn" onclick="closeModal()">×</button>
    </div>
    <div class="modal-content">
        @php
            $delayedTasks = collect($datos)->filter(function($task) {
                return $task['progreso'] < 100 && 
                       \Carbon\Carbon::parse($task['fecha_fin'])->isPast() && 
                       $task['estado'] != 4;
            });
        @endphp

        @if($delayedTasks->isEmpty())
            <div class="text-center text-gray-500 py-4">
                No hay alertas pendientes.
            </div>
        @else
            @foreach($delayedTasks as $task)
                <div class="alert-item">
                    <div class="alert-title">{{ $task['tarea'] }}</div>
                    <div class="alert-project">{{ $task['proyecto'] }}</div>
                    @php
                        $diasRetraso = \Carbon\Carbon::parse($task['fecha_fin'])->diffInDays(now());
                    @endphp
                    <div class="alert-delay">
                        Retraso: {{ $diasRetraso }} {{ $diasRetraso === 1 ? 'día' : 'días' }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentZoom = 1;

    window.adjustZoom = function(factor) {
        currentZoom *= factor;
        currentZoom = Math.min(Math.max(0.5, currentZoom), 2);
        document.getElementById('tasksContainer').style.transform = `scaleX(${currentZoom})`;
        document.getElementById('tasksContainer').style.transformOrigin = 'left';
    }

    window.showTaskInfo = function(event, taskName, progress, duration) {
        const modal = document.getElementById('taskInfoModal');
        const modalTaskName = document.getElementById('modalTaskName');
        const modalProgress = document.getElementById('modalProgress');
        const modalDuration = document.getElementById('modalDuration');

        // Formatear la duración
        const [hours, minutes, seconds] = duration.split(':');
        const formattedDuration = `${hours}h ${minutes}m ${seconds}s`;

        modalTaskName.textContent = taskName;
        modalProgress.textContent = progress + '%';
        modalDuration.textContent = formattedDuration;

        // Posicionar el modal cerca del cursor
        const offset = 10;
        modal.style.left = (event.pageX + offset) + 'px';
        modal.style.top = (event.pageY + offset) + 'px';

        // Asegurar que el modal no se salga de la ventana
        const rect = modal.getBoundingClientRect();
        if (rect.right > window.innerWidth) {
            modal.style.left = (event.pageX - rect.width - offset) + 'px';
        }
        if (rect.bottom > window.innerHeight) {
            modal.style.top = (event.pageY - rect.height - offset) + 'px';
        }

        modal.style.display = 'block';
    }

    window.hideTaskInfo = function() {
        document.getElementById('taskInfoModal').style.display = 'none';
    }

    // Función para actualizar las estadísticas
    function updateStats(projectId) {
        const projectOption = document.querySelector(`.project-option[data-project-id="${projectId}"]`);
        if (projectOption) {
            document.getElementById('totalTasks').textContent = projectOption.dataset.totalTasks;
            document.getElementById('totalTime').textContent = projectOption.dataset.totalTime;
            document.getElementById('inProduction').textContent = projectOption.dataset.inProduction;
        }
    }

    window.toggleProjectDropdown = function() {
        const dropdown = document.getElementById('projectDropdown');
        dropdown.classList.toggle('show');

        // Cerrar dropdown al hacer click fuera
        document.addEventListener('click', function closeDropdown(e) {
            const selector = document.querySelector('.project-selector');
            if (!selector.contains(e.target)) {
                dropdown.classList.remove('show');
                document.removeEventListener('click', closeDropdown);
            }
        });
    }

    window.selectProject = function(projectId, projectName) {
        // Actualizar título activo
        const currentProject = document.getElementById('currentProject');
        currentProject.textContent = projectName;
        
        // Añadir el icono de flecha nuevamente
        currentProject.innerHTML = projectName + ' <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>';

        // Ocultar dropdown
        document.getElementById('projectDropdown').classList.remove('show');

        // Mostrar sección del proyecto seleccionado
        document.querySelectorAll('.project-section').forEach(section => {
            section.style.display = section.dataset.projectId === projectId ? '' : 'none';
        });

        // Actualizar estadísticas al cambiar de proyecto
        updateStats(projectId);
    }

    // Cerrar paneles al hacer click en ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('projectDropdown').classList.remove('show');
            closeModal();
        }
    });

    // Inicializar estadísticas con el primer proyecto
    updateStats('{{ $firstProjectId }}');

    window.openModal = function() {
        document.getElementById('modalOverlay').style.display = 'block';
        document.getElementById('modalContainer').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    window.closeModal = function() {
        document.getElementById('modalOverlay').style.display = 'none';
        document.getElementById('modalContainer').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Cerrar modal con click fuera
    document.getElementById('modalOverlay').addEventListener('click', closeModal);

    window.openModal = function() {
        document.getElementById('modalOverlay').style.display = 'block';
        document.getElementById('modalContainer').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    window.closeModal = function() {
        document.getElementById('modalOverlay').style.display = 'none';
        document.getElementById('modalContainer').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Cerrar modal con click fuera
    document.getElementById('modalOverlay').addEventListener('click', closeModal);

    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
});
</script>
@endsection
