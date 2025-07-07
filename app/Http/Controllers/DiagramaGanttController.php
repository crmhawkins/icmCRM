<?php

namespace App\Http\Controllers;

use App\Models\Budgets\Budget;
use App\Models\Tasks\LogTasks;
use Illuminate\Http\Request;

class DiagramaGanttController extends Controller
{

    public function getDataGrantt()
{
    $proyectos = Budget::with('tasks')->get();
    $datos = [];
    $maxFechaFin = null;
    $minFechaInicio = null;
    $tareaMaestra = null;

    foreach ($proyectos as $proyecto) {
        foreach ($proyecto->tasks as $tarea) {
            $logInicio = LogTasks::where('task_id', $tarea->id)->orderBy('date_start', 'asc')->first();
            $logFin = LogTasks::where('task_id', $tarea->id)->orderBy('date_end', 'desc')->first();

            if ($logInicio && $logFin) {
                // Convertir estimated_time a milisegundos
                list($horas, $minutos, $segundos) = explode(':', $tarea->estimated_time);
                $duracionEnMilisegundos = ($horas * 60 * 60 * 1000) + ($minutos * 60 * 1000);

                // Convertir real_time (progreso) a milisegundos
                list($horasReal, $minutosReal, $segundosReal) = explode(':', $tarea->real_time);
                $progresoEnMilisegundos = ($horasReal * 60 * 60 * 1000) + ($minutosReal * 60 * 1000);

                // Buscar la tarea maestra
                if ($tarea->split_master_task_id === null) {
                    $tareaMaestra = $tarea;
                }

                // Definir los límites del gráfico
                if (!$minFechaInicio || strtotime($logInicio->date_start) < strtotime($minFechaInicio)) {
                    $minFechaInicio = $logInicio->date_start;
                }
                if (!$maxFechaFin || strtotime($logFin->date_end) > strtotime($maxFechaFin)) {
                    $maxFechaFin = $logFin->date_end;
                }

                $datos[] = [
                    'Proyecto' => $proyecto->name,
                    'Tarea' => $tarea->title,
                    'Inicio' => $logInicio->date_start,
                    'Fin' => $logFin->date_end,
                    'Duración' => $duracionEnMilisegundos,
                    'Progreso' => $progresoEnMilisegundos,
                ];
            }
        }
    }

    // Si hay una tarea maestra, establecer su duración total y progreso total
    if ($tareaMaestra) {
        list($horas, $minutos, $segundos) = explode(':', $tareaMaestra->estimated_time);
        $duracionTotalProyecto = ($horas * 60 * 60 * 1000) + ($minutos * 60 * 1000);

        list($horasReal, $minutosReal, $segundosReal) = explode(':', $tareaMaestra->real_time);
        $progresoTotalProyecto = ($horasReal * 60 * 60 * 1000) + ($minutosReal * 60 * 1000);

        $datos[] = [
            'Proyecto' => 'Tarea Maestra',
            'Tarea' => $tareaMaestra->title,
            'Inicio' => $minFechaInicio,
            'Fin' => date('Y-m-d H:i:s', strtotime($minFechaInicio) + $duracionTotalProyecto),
            'Duración' => $duracionTotalProyecto,
            'Progreso' => $progresoTotalProyecto,
        ];
    }

    return [
        'datos' => $datos,
        'minFechaInicio' => $minFechaInicio,
        'maxFechaFin' => $maxFechaFin
    ];
}



    public function mostrarDiagramaGantt()
    {
        $datos = $this->getDataGrantt();
        // dd($datos);
        return view('diagrama.index', compact('datos'));
    }
}
