@extends('layouts.app')

@section('titulo', 'Cola de trabajo')

@php
$departments = collect($tasks)->pluck('departamento')->unique()->values();
$defaultDepartment = $departments->first();
@endphp

<style>
    .css-96uzu9 {
        z-index: -1;
    }

    .task-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 0.5rem;
    }

    .task-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 0.75rem;
        margin-right: 0.75rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        min-width: 250px;
    }

    .task-card:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .task-card.continuation {
        border-top: 2px dashed #6b7280;
    }

    .task-card.has-continuation {
        border-bottom: 2px dashed #6b7280;
    }

    .department-selector {
        position: relative;
        display: inline-block;
        margin-bottom: 2rem;
    }

    .department-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #374151;
        padding: 0.5rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .department-title:hover {
        background-color: #f3f4f6;
    }

    .department-dropdown {
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

    .department-option {
        padding: 0.5rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .department-option:hover {
        background-color: #f3f4f6;
    }

    .department-dropdown.show {
        display: block;
    }

    .task-card[data-department] {
        display: none;
    }

    .task-card[data-department="{{ $defaultDepartment }}"] {
        display: block;
    }

    .time-indicator {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .time-main {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 500;
    }

    .time-details {
        display: flex;
        justify-content: space-between;
        padding-top: 0.25rem;
        border-top: 1px dashed #e5e7eb;
        color: #9ca3af;
        font-size: 0.75rem;
    }

    .time-badge {
        background-color: #e5e7eb;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
    }

    .row-header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .row-time {
        font-weight: 500;
        color: #4b5563;
    }

    .original-time {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-left: 0.5rem;
    }

    .date-header {
        font-weight: 500;
        color: #4b5563;
    }

    .date-header .day-name {
        font-weight: 600;
        color: #1f2937;
    }

    .today-indicator {
        color: #2563eb;
        font-weight: 600;
    }
</style>

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Cola de trabajo</h1>
        </div>

        <!-- Selector de Departamento -->
        <div class="department-selector">
            <h3 class="department-title" onclick="toggleDepartmentDropdown()" id="currentDepartment">
                {{ $defaultDepartment }}
                <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </h3>
            <div class="department-dropdown" id="departmentDropdown">
                @foreach($departments as $department)
                    <div class="department-option" onclick="selectDepartment('{{ $department }}')">
                        {{ $department }}
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Contenedor de tareas --}}
        <div class="task-container">
            {{-- Contenedor para las filas --}}
            @for($i = 1; $i <= 5; $i++)
                <div class="row-container">
                    <div class="task-row" data-row="{{ $i }}">
                        @foreach($tasks as $task)
                            @if($task['fila'] == $i)
                                <div class="task-card {{ $task['is_continuation'] ? 'continuation' : '' }} {{ $task['has_continuation'] ? 'has-continuation' : '' }}" 
                                     data-task-id="{{ $task['id'] }}"
                                     data-department="{{ $task['departamento'] }}"
                                     data-time="{{ $task['time'] }}">
                                    <div class="task-header">
                                        <span class="task-title">{{ $task['title'] }}</span>
                                        <span class="task-user">{{ $task['usuario'] }}</span>
                                    </div>
                                    <div class="task-times">
                                        <span>{{ $task['time'] }}</span>
                                        @if($task['has_continuation'])
                                            <span>(Total: {{ $task['remaining_total'] }})</span>
                                        @endif
                                        <span>Realizado: {{ $task['real_time'] }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row-time-indicator"></div>
                </div>
            @endfor
        </div>

        <style>
            .task-container {
                padding: 20px;
            }

            .row-container {
                display: flex;
                align-items: stretch;
                margin-bottom: 15px;
                position: relative;
            }

            .task-row {
                flex-grow: 1;
                min-height: 100px;
                border: 1px dashed #ccc;
                padding: 10px;
                background: #f9f9f9;
                margin-right: 150px;
            }

            .row-time-indicator {
                position: absolute;
                right: 0;
                top: 50%;
                transform: translateY(-50%);
                padding: 5px 10px;
                background: #f0f0f0;
                border-radius: 4px;
                font-size: 0.9em;
                width: 140px;
                text-align: center;
            }

            .row-time-indicator.exceeded {
                background: #ff6b6b;
                color: white;
                font-weight: bold;
            }

            .task-card {
                background: white;
                border: 1px solid #ddd;
                padding: 10px;
                margin: 5px;
                cursor: move;
                user-select: none;
                transition: all 0.2s ease;
            }

            .task-card.dragging {
                opacity: 0.7;
                transform: scale(1.02);
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }

            .task-card.continuation {
                border-top: 3px solid #007bff;
            }

            .task-card.has-continuation {
                border-bottom: 3px solid #007bff;
            }

            .task-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 5px;
            }

            .task-times {
                font-size: 0.9em;
                color: #666;
            }
        </style>

        @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const MAX_HOURS_PER_ROW = 8 * 3600;

                // Funciones de utilidad existentes...
                function timeToSeconds(time) {
                    if (!time) return 0;
                    const [hours, minutes, seconds] = time.split(':').map(Number);
                    return (hours * 3600) + (minutes * 60) + seconds;
                }

                function secondsToTime(seconds) {
                    const hours = Math.floor(seconds / 3600);
                    const minutes = Math.floor((seconds % 3600) / 60);
                    const secs = seconds % 60;
                    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                }

                function calculateRowTime(row) {
                    let totalSeconds = 0;
                    row.querySelectorAll('.task-card:not([style*="display: none"])').forEach(task => {
                        const timeStr = task.getAttribute('data-time');
                        totalSeconds += timeToSeconds(timeStr);
                    });
                    return totalSeconds;
                }

                function updateRowTimeIndicator(taskRow) {
                    const rowContainer = taskRow.closest('.row-container');
                    const indicator = rowContainer.querySelector('.row-time-indicator');
                    const totalSeconds = calculateRowTime(taskRow);
                    const totalHours = totalSeconds / 3600;
                    const timeStr = secondsToTime(totalSeconds);
                    
                    indicator.textContent = `Tiempo total: ${timeStr}`;
                    indicator.className = `row-time-indicator ${totalHours > 8 ? 'exceeded' : ''}`;
                }

                // Función para mostrar/ocultar el dropdown
                window.toggleDepartmentDropdown = function() {
                    const dropdown = document.getElementById('departmentDropdown');
                    dropdown.classList.toggle('show');
                };

                // Función para seleccionar departamento
                window.selectDepartment = function(department) {
                    // Actualizar el título del selector
                    document.getElementById('currentDepartment').textContent = department;
                    
                    // Ocultar el dropdown
                    document.getElementById('departmentDropdown').classList.remove('show');
                    
                    // Mostrar/ocultar tareas según el departamento
                    document.querySelectorAll('.task-card').forEach(card => {
                        if (card.getAttribute('data-department') === department) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Actualizar los indicadores de tiempo
                    document.querySelectorAll('.task-row').forEach(row => {
                        updateRowTimeIndicator(row);
                    });
                };

                // Cerrar el dropdown si se hace clic fuera de él
                document.addEventListener('click', function(event) {
                    if (!event.target.closest('.department-selector')) {
                        document.getElementById('departmentDropdown').classList.remove('show');
                    }
                });

                // Inicializar Sortable en cada fila
                document.querySelectorAll('.task-row').forEach(row => {
                    updateRowTimeIndicator(row);

                    new Sortable(row, {
                        group: 'tasks',
                        animation: 150,
                        onStart: function(evt) {
                            evt.item.classList.add('dragging');
                        },
                        onEnd: async function(evt) {
                            evt.item.classList.remove('dragging');
                            const taskElement = evt.item;
                            const newRow = evt.to;
                            const oldRow = evt.from;
                            const taskId = taskElement.getAttribute('data-task-id');
                            const taskTitle = taskElement.querySelector('.task-title').textContent;

                            try {
                                const response = await fetch('/actualizar-fila-tarea', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({
                                        taskId: taskId,
                                        rowAssignments: [{ row: newRow.getAttribute('data-row') }]
                                    })
                                });

                                const data = await response.json();

                                if (data.success) {
                                    if (data.merged) {
                                        console.log('Tareas fusionadas:', data.message);
                                        window.location.reload();
                                    } else {
                                        updateRowTimeIndicator(oldRow);
                                        updateRowTimeIndicator(newRow);
                                    }
                                } else {
                                    console.error('Error al actualizar la fila:', data.error);
                                    oldRow.appendChild(taskElement);
                                    updateRowTimeIndicator(oldRow);
                                    updateRowTimeIndicator(newRow);
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                oldRow.appendChild(taskElement);
                                updateRowTimeIndicator(oldRow);
                                updateRowTimeIndicator(newRow);
                            }
                        }
                    });
                });
            });
        </script>
        @endsection
    </div>
</div>
@endsection