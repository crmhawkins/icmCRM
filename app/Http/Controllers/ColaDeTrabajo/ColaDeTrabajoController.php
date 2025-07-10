<?php

namespace App\Http\Controllers\ColaDeTrabajo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tasks\Task;
use App\Models\Users\User;
use App\Models\Users\UserDepartament;

class ColaDeTrabajoController extends Controller
{
    private const MAX_HOURS_PER_ROW = 8 * 3600; // 8 horas en segundos
    private const MAX_ROWS = 5;

    public function index()
    {   
        $tasks = $this->getTasks();
        return view('cola-de-trabajo.cola-de-trabajo', ['tasks' => $tasks]);
    }

    private function timeToSeconds($time) {
        if (!$time) return 0;
        list($h, $m, $s) = array_pad(explode(':', $time), 3, 0);
        return ($h * 3600) + ($m * 60) + intval($s);
    }

    private function secondsToTime($seconds) {
        if ($seconds < 0) $seconds = 0;
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);
        $s = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }

    private function calculateRemainingTime($estimatedTime, $realTime) {
        $estimatedSeconds = $this->timeToSeconds($estimatedTime);
        $realSeconds = $this->timeToSeconds($realTime);
        return max(0, $estimatedSeconds - $realSeconds);
    }

    private function processTask($task, $currentRow, $remainingTimeInRow) {
        if($task->admin_user_id != null) {
            $user = User::find($task->admin_user_id);
            $name = $user->name;
            $departamento_id = $user->admin_user_department_id;
        } else {
            $name = 'Sin asignar';
            $departamento_id = null;
        }
        
        if($departamento_id != null) {
            $departamento = UserDepartament::find($departamento_id)->name;
        } else {
            $departamento = 'Sin asignar';
        }

        // Calcular tiempo restante en segundos
        $remainingSeconds = $this->calculateRemainingTime($task->estimated_time, $task->real_time);
        
        // Si no queda tiempo por realizar, retornamos null
        if ($remainingSeconds <= 0) return null;

        $remainingTimeFormatted = $this->secondsToTime($remainingSeconds);
        $timeForThisRow = min($remainingSeconds, $remainingTimeInRow);

        return [
            'id' => $task->id,
            'usuario' => $name,
            'departamento' => $departamento,
            'title' => $task->title,
            'time' => $this->secondsToTime($timeForThisRow),
            'remaining_total' => $remainingTimeFormatted,
            'real_time' => $task->real_time ?: '00:00:00',
            'fila' => $currentRow,
            'is_continuation' => false,
            'has_continuation' => $timeForThisRow < $remainingSeconds,
            'remaining_seconds' => $remainingSeconds - $timeForThisRow
        ];
    }

    public function getTasks()
    {
        // Obtener todas las tareas activas ordenadas por fecha de creación
        $tasks = Task::where('task_status_id', '!=', 3)
                    ->where('task_status_id', '!=', 5)
                    ->orderBy('created_at', 'asc')
                    ->get();
        
        $processedTasks = [];
        $rowTimes = array_fill(1, self::MAX_ROWS, self::MAX_HOURS_PER_ROW);
        
        // Primero procesar tareas con fila fija
        foreach($tasks as $key => $task) {
            if($task->fila !== null) {
                $row = $task->fila;
                if($row > 0 && $row <= self::MAX_ROWS) {
                    $processedTask = $this->processTask($task, $row, self::MAX_HOURS_PER_ROW);
                    if($processedTask) {
                        $processedTasks[] = $processedTask;
                        $remainingSeconds = $processedTask['remaining_seconds'];
                        
                        // Si la tarea tiene continuación, procesarla en las siguientes filas
                        $currentRow = $row + 1;
                        while($remainingSeconds > 0 && $currentRow <= self::MAX_ROWS) {
                            $timeForThisRow = min($remainingSeconds, self::MAX_HOURS_PER_ROW);
                            $processedTasks[] = [
                                'id' => $task->id,
                                'usuario' => $processedTask['usuario'],
                                'departamento' => $processedTask['departamento'],
                                'title' => $task->title,
                                'time' => $this->secondsToTime($timeForThisRow),
                                'remaining_total' => $processedTask['remaining_total'],
                                'real_time' => $processedTask['real_time'],
                                'fila' => $currentRow,
                                'is_continuation' => true,
                                'has_continuation' => $timeForThisRow < $remainingSeconds,
                                'remaining_seconds' => $remainingSeconds - $timeForThisRow
                            ];
                            $remainingSeconds -= $timeForThisRow;
                            $rowTimes[$currentRow] -= $timeForThisRow;
                            $currentRow++;
                        }
                        
                        // Actualizar el tiempo disponible en la fila original
                        $rowTimes[$row] -= $this->timeToSeconds($processedTask['time']);
                    }
                    unset($tasks[$key]); // Remover la tarea procesada
                }
            }
        }

        // Procesar el resto de tareas sin fila fija
        $currentRow = 1;
        foreach($tasks as $task) {
            // Buscar la primera fila con espacio suficiente
            while($currentRow <= self::MAX_ROWS) {
                if($rowTimes[$currentRow] > 0) {
                    $processedTask = $this->processTask($task, $currentRow, $rowTimes[$currentRow]);
                    if($processedTask) {
                        $processedTasks[] = $processedTask;
                        $remainingSeconds = $processedTask['remaining_seconds'];
                        $rowTimes[$currentRow] -= $this->timeToSeconds($processedTask['time']);

                        // Si la tarea tiene continuación, procesarla en las siguientes filas
                        $nextRow = $currentRow + 1;
                        while($remainingSeconds > 0 && $nextRow <= self::MAX_ROWS) {
                            $timeForThisRow = min($remainingSeconds, $rowTimes[$nextRow]);
                            if($timeForThisRow <= 0) break;

                            $processedTasks[] = [
                                'id' => $task->id,
                                'usuario' => $processedTask['usuario'],
                                'departamento' => $processedTask['departamento'],
                                'title' => $task->title,
                                'time' => $this->secondsToTime($timeForThisRow),
                                'remaining_total' => $processedTask['remaining_total'],
                                'real_time' => $processedTask['real_time'],
                                'fila' => $nextRow,
                                'is_continuation' => true,
                                'has_continuation' => $timeForThisRow < $remainingSeconds,
                                'remaining_seconds' => $remainingSeconds - $timeForThisRow
                            ];
                            $remainingSeconds -= $timeForThisRow;
                            $rowTimes[$nextRow] -= $timeForThisRow;
                            $nextRow++;
                        }
                    }
                    break;
                }
                $currentRow++;
            }
            if($currentRow > self::MAX_ROWS) break;
        }

        // Ordenar las tareas por fila y luego por ID para mantener el orden dentro de cada fila
        usort($processedTasks, function($a, $b) {
            if($a['fila'] === $b['fila']) {
                return $a['id'] - $b['id'];
            }
            return $a['fila'] - $b['fila'];
        });

        return $processedTasks;
    }

    public function actualizarFilaTarea(Request $request)
    {
        try {
            $taskId = $request->input('taskId');
            $rowAssignments = $request->input('rowAssignments');
            
            $task = Task::findOrFail($taskId);
            
            // Actualizar solo la fila de la tarea
            if (count($rowAssignments) > 0) {
                $task->update([
                    'fila' => $rowAssignments[0]['row']
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
