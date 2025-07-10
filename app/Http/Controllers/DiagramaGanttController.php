<?php

namespace App\Http\Controllers;

use App\Models\Budgets\Budget;
use App\Models\Tasks\LogTasks;
use Illuminate\Http\Request;

class DiagramaGanttController extends Controller
{
    private function hmsToSeconds($hms) {
        list($h, $m, $s) = explode(':', $hms);
        return ($h * 3600) + ($m * 60) + $s;
    }

    public function getDataGrantt()
    {
        $proyectos = Budget::with('tasks')->get();
        $datos = [];
        $maxFechaFin = null;
        $minFechaInicio = null;
        $tareaMaestra = null;
        $taskProgress = []; // Track accumulated progress per task

        foreach($proyectos as $proyect) {
            foreach($proyect->tasks as $task) {
                $logs = LogTasks::where('task_id', $task->id)->get();
                $taskId = $task->id;
                
                if ($logs->count() > 0) {
                    $totalProgress = 0;
                    $duracionEstimada = $this->hmsToSeconds($task->estimated_time);
                    $firstLog = true;
                    $taskData = null;

                    foreach($logs as $log) {
                        $inicio = $log->date_start;
                        $fin = $log->date_end;
                        
                        $tiempoReal = strtotime($fin) - strtotime($inicio);
                        $currentProgress = ($duracionEstimada > 0) ? min(100, round(($tiempoReal / $duracionEstimada) * 100)) : 0;
                        $totalProgress += $currentProgress;
                        
                        if ($firstLog) {
                            $taskData = [
                                'id_tarea' => $taskId,
                                'tarea' => $task->title,
                                'estado' => $task->task_status_id,
                                'proyecto' => $proyect->concept,
                                'id_proyecto' => $proyect->id,
                                'duracion' => $task->estimated_time,
                                'progreso' => min(100, $totalProgress), // Cap at 100%
                                'fecha_creacion' => $task->created_at,
                                'fecha_inicio' => $inicio,
                                'fecha_fin' => $fin
                            ];
                            $firstLog = false;
                        } else {
                            // Update only the progress and dates if needed
                            $taskData['progreso'] = min(100, $totalProgress);
                            // Update fecha_fin to the latest
                            if (strtotime($fin) > strtotime($taskData['fecha_fin'])) {
                                $taskData['fecha_fin'] = $fin;
                            }
                            // Update fecha_inicio to the earliest
                            if (strtotime($inicio) < strtotime($taskData['fecha_inicio'])) {
                                $taskData['fecha_inicio'] = $inicio;
                            }
                        }
                    }
                    
                    $datos[] = $taskData;
                    
                } else {
                    $datos[] = [
                        'id_tarea' => $taskId,
                        'tarea' => $task->title,
                        'estado' => $task->task_status_id,
                        'proyecto' => $proyect->concept,
                        'id_proyecto' => $proyect->id,
                        'duracion' => $task->estimated_time,
                        'progreso' => 0,
                        'fecha_creacion' => $task->created_at,
                        'fecha_inicio' => null,
                        'fecha_fin' => null
                    ];
                }
            }
        }

        return $datos;
    }

    public function mostrarDiagramaGantt()
    {
        $datos = $this->getDataGrantt();
        
        // Debug: Ensure we have data
        if (empty($datos)) {
            \Log::info('No hay datos en el diagrama Gantt');
        } else {
            \Log::info('Datos del diagrama Gantt: ' . count($datos) . ' tareas encontradas');
        }
        
        return view('diagrama.index', compact('datos'));
    }
}
