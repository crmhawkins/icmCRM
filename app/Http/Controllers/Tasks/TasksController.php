<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Jornada\Jornada;
use App\Models\Prioritys\Priority;
use App\Models\Tasks\LogTasks;
use App\Models\Tasks\Task;
use App\Models\Tasks\TaskStatus;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    public function index()
    {
        $tareas = Task::all();
        return view('tasks.index', compact('tareas'));
    }
    public function cola()
    {
        $usuarios = User::where('access_level_id',5)->where('inactive', 0)->get();
        //$usuarios = User::all();
        return view('tasks.cola', compact('usuarios'));
    }
    public function revision()
    {
        $tareas = Task::all();
        return view('tasks.revision', compact('tareas'));
    }
    public function asignar()
    {
        $tareas = Task::all();
        return view('tasks.asignar', compact('tareas'));
    }

    // public function edit(string $id)
    // {
    //     $task = Task::find($id);
    //     $employees = User::where('inactive', 0)->get();
    //     $prioritys = Priority::all();
    //     $status = TaskStatus::all();
    //     $data = [];



    //     // Obtener los departamentos a través de los servicios de los conceptos del presupuesto relacionado con la tarea
    //     $departamentos = collect(); // Inicializar colección vacía

    //     if ($task->presupuestoConcepto && $task->presupuestoConcepto->servicio) {
    //         $servicio = $task->presupuestoConcepto->servicio;

    //         // Verificar si el servicio tiene departamentos asociados
    //         if ($servicio->servicoNombre()->exists()) {
    //             $departamentos = $servicio->departamentos()->get();
    //         }
    //     }

    //     if ($task->duplicated == 0) {
    //         $trabajador = User::find($task->admin_user_id);
    //         if ($trabajador) {
    //             $data = [
    //                 '0' => [
    //                     'num' => 1,
    //                     'id' => $trabajador->id,
    //                     'trabajador' => $trabajador->name,
    //                     'horas_estimadas' => $task->estimated_time,
    //                     'horas_reales' => $task->real_time,
    //                     'status' => $task->task_status_id,
    //                     'task_id' => $task->id,
    //                 ],
    //             ];
    //         }
    //     } else {
    //         $count = 1;
    //         $tareasDuplicadas = Task::where('split_master_task_id', $task->id)->get();
    //         $trabajador = User::find($task->admin_user_id);

    //         if ($trabajador) {
    //             $data = [
    //                 '0' => [
    //                     'num' => 1,
    //                     'id' => $trabajador->id,
    //                     'trabajador' => $trabajador->name,
    //                     'horas_estimadas' => $task->estimated_time,
    //                     'horas_reales' => $task->real_time,
    //                     'status' => $task->task_status_id,
    //                     'task_id' => $task->id,
    //                 ],
    //             ];
    //         } else {
    //             $count = 0;
    //         }

    //         foreach ($tareasDuplicadas as $tarea) {
    //             if ($tarea->admin_user_id) {
    //                 $trabajador = User::find($tarea->admin_user_id);
    //                 $data[$count] = [
    //                     'num' => $count + 1,
    //                     'id' => $trabajador->id ?? 1,
    //                     'trabajador' => $trabajador->name ?? 'No existe',
    //                     'horas_estimadas' => $tarea->estimated_time,
    //                     'horas_reales' => $tarea->real_time,
    //                     'status' => $tarea->task_status_id,
    //                     'task_id' => $tarea->id,
    //                 ];
    //                 $count++;
    //             }
    //         }
    //     }

    //     return view('tasks.edit', compact('task', 'prioritys', 'employees', 'data', 'status', 'departamentos'));
    // }



    public function edit(string $id)
{
    $task = Task::findOrFail($id);

    // Para saber si la tarea es maestra: split_master_task_id es null
    $isMaster = is_null($task->split_master_task_id);

    // La tarea maestra es la misma si es master, o la que tenga en split_master_task_id si no lo es
    $masterTask = $isMaster ? $task : Task::find($task->split_master_task_id);

    // Catálogos
    $employees = User::where('inactive', 0)->get();
    $prioritys = Priority::all();
    $status = TaskStatus::all();

    // Recopilamos departamentos desde el servicio de la tarea (si existe)
    $departamentos = collect();
    if ($task->presupuestoConcepto && $task->presupuestoConcepto->servicio) {
        $servicio = $task->presupuestoConcepto->servicio;
        // Verificamos si el servicio está relacionado para obtener sus departamentos
        if ($servicio->servicoNombre()->exists()) {
            $departamentos = $servicio->departamentos()->get();
        }
    }

    // Preparar data: la tarea misma + posibles tareas asociadas (si es maestra)
    $data = [];

    if ($isMaster) {
        // Si es maestra, traemos todas las tareas duplicadas (asociadas)
        $tareasDuplicadas = Task::where('split_master_task_id', $task->id)->get();

        // Agregamos primero la propia (maestra) a data
        $trabajador = User::find($task->admin_user_id);
        $count = 0;

        if ($trabajador) {
            $data[$count] = [
                'num'             => $count + 1,
                'id'              => $trabajador->id,
                'trabajador'      => $trabajador->name,
                'horas_estimadas' => $task->estimated_time,
                'horas_reales'    => $task->real_time,
                'status'          => $task->task_status_id,
                'task_id'         => $task->id,
                'department_id'   => optional($task->presupuestoConcepto->servicio->departamentos->first())->id ?? null, // Asigna el departamento si existe
            ];
            $count++;
        }

        // Agregar cada tarea duplicada (hija)
        foreach ($tareasDuplicadas as $tareaHija) {
            if ($tareaHija->admin_user_id) {
                $trabajadorHija = User::find($tareaHija->admin_user_id);
                $data[$count] = [
                    'num'             => $count + 1,
                    'id'              => $trabajadorHija->id ?? null,
                    'trabajador'      => $trabajadorHija->name ?? 'No existe',
                    'horas_estimadas' => $tareaHija->estimated_time,
                    'horas_reales'    => $tareaHija->real_time,
                    'status'          => $tareaHija->task_status_id,
                    'task_id'         => $tareaHija->id,
                    'department_id'   => optional($tareaHija->presupuestoConcepto->servicio->departamentos->first())->id ?? null, // Asigna el departamento si existe
                ];
                $count++;
            }
        }
    } else {
        // Si NO es maestra, solo agregamos la propia tarea
        $trabajador = User::find($task->admin_user_id);
        if ($trabajador) {
            $data[] = [
                'num'             => 1,
                'id'              => $trabajador->id,
                'trabajador'      => $trabajador->name,
                'horas_estimadas' => $task->estimated_time,
                'horas_reales'    => $task->real_time,
                'status'          => $task->task_status_id,
                'task_id'         => $task->id,
                'department_id'   => optional($task->presupuestoConcepto->servicio->departamentos->first())->id ?? null, // Asigna el departamento si existe
            ];
        }
    }

    // Devolvemos todo a la vista edit
    return view('tasks.edit', compact(
        'task',
        'isMaster',
        'masterTask',
        'employees',
        'prioritys',
        'status',
        'departamentos',
        'data'
    ));
}


public function update(Request $request)
{

    //dd($request->all()); // 🔴 PRIMERO, VERIFICA QUE AHORA SE RECIBEN LOS DATOS

    $loadTask = Task::find($request->taskId);

    if ($request->has('employeeId')) {
        foreach ($request->employeeId as $index => $employeeId) {
            if ($employeeId) { // Verificar que el campo no esté vacío
                $exist = Task::where('admin_user_id', $employeeId)->where('split_master_task_id', $loadTask->id)->first();

                if ($exist) {
                    // Actualizar tarea existente
                    $exist->estimated_time = $request->estimatedTime[$index];
                    $exist->real_time = $request->realTime[$index] ?? '00:00:00';
                    $exist->task_status_id = $request->status[$index];
                    $exist->save();
                } else {
                    // Crear nueva subtarea
                    Task::create([
                        'admin_user_id' => $employeeId,
                        'gestor_id' => $loadTask->gestor_id,
                        'priority_id' => $request->priority,
                        'project_id' => $loadTask->project_id,
                        'budget_id' => $loadTask->budget_id,
                        'budget_concept_id' => $loadTask->budget_concept_id,
                        'task_status_id' => $request->status[$index] ?? 2,
                        'split_master_task_id' => $loadTask->id,
                        'duplicated' => 0,
                        'description' => $request->description,
                        'title' => $request->title,
                        'estimated_time' => $request->estimatedTime[$index],
                        'real_time' => $request->realTime[$index] ?? '00:00:00',
                    ]);
                }
            }
        }
    }

    // Actualizar la tarea maestra
    $loadTask->title = $request->title;
    $loadTask->description = $request->description;
    $loadTask->duplicated = 1;
    $loadTask->save();

    return redirect()->route('tarea.edit', $loadTask->id)->with('toast', [
        'icon' => 'success',
        'mensaje' => 'Tarea actualizada correctamente'
    ]);
}


    public function calendar($id)
    {
        $user = User::where('id', $id)->first();

        // Obtener los eventos de tareas para el usuario
        $events = $this->getLogTasks($id);
        // Convertir los eventos en formato adecuado para FullCalendar (si no están ya en ese formato)
        $eventData = [];
        foreach ($events as $event) {
            $eventData[] = [
                'id' => $event[3],
                'title' => $event[0],
                'start' => \Carbon\Carbon::parse($event[1])->addHours(2)->toIso8601String(), // Aquí debería estar la fecha y hora de inicio
                'end' => $event[2] ? \Carbon\Carbon::parse($event[2])->addHours(2)->toIso8601String() : null , // Aquí debería estar la fecha y hora de fin
                'allDay' => false, // Indica si el evento es de todos los días
                'color' =>$event[4]
            ];
        }
        // Datos adicionales de horas trabajadas y producidas
        $horas = $this->getHorasTrabajadas($user);
        $horas_hoy = $this->getHorasTrabajadasHoy($user);
        $horas_hoy2 = $this->getHorasTrabajadasHoy2($user);
        $horas_dia = $this->getHorasTrabajadasDia($user);

        // Pasar los datos de eventos a la vista como JSON
        return view('tasks.timeLine', [
            'user' => $user,
            'horas' => $horas,
            'horas_hoy' => $horas_hoy,
            'horas_dia' => $horas_dia,
            'horas_hoy2' => $horas_hoy2,
            'events' => $eventData // Enviar los eventos como JSON
        ]);
    }


    public function getHorasTrabajadasDia($usuario)
    {
        $horasTrabajadas = DB::select("SELECT SUM(TIMESTAMPDIFF(MINUTE,date_start,date_end)) AS minutos FROM log_tasks where date_start >= cast(now() As Date) AND `admin_user_id` = $usuario->id");
        $hora = floor($horasTrabajadas[0]->minutos / 60);
        $minuto = ($horasTrabajadas[0]->minutos % 60);
        $horas_dia = $hora . ' Horas y ' . $minuto . ' minutos';

        return $horas_dia;
    }

    public function getHorasTrabajadas($usuario)
    {
        $horasTrabajadas = DB::select("SELECT SUM(TIMESTAMPDIFF(MINUTE,date_start,date_end)) AS minutos FROM `log_tasks` WHERE date_start BETWEEN now() - interval (day(now())-1) day AND LAST_DAY(NOW()) AND `admin_user_id` = $usuario->id");
        $hora = floor($horasTrabajadas[0]->minutos / 60);
        $minuto = ($horasTrabajadas[0]->minutos % 60);
        $horas = $hora . ' Horas y ' . $minuto . ' minutos';

        return $horas;
    }

    // Horas producidas hoy
    public function getHorasTrabajadasHoy($user)
    {
        // Se obtiene los datos
        $id = $user->id;
        $fecha = Carbon::now()->toDateString();;
        $resultado = 0;
        $totalMinutos2 = 0;

        $logsTasks = LogTasks::where('admin_user_id', $id)
        ->whereDate('date_start', '=', $fecha)
        ->get();

        foreach($logsTasks as $item){
            if($item->date_end == null){
                $item->date_end = Carbon::now();
            }
            $to_time2 = strtotime($item->date_start);
            $from_time2 = strtotime($item->date_end);
            $minutes2 = ($from_time2 - $to_time2) / 60;
            $totalMinutos2 += $minutes2;
        }

        $hora2 = floor($totalMinutos2 / 60);
        $minuto2 = ($totalMinutos2 % 60);
        $horas_dia2 = $hora2 . ' Horas y ' . $minuto2 . ' minutos';

        $resultado = $horas_dia2;

        return $resultado;
    }

    // Horas trabajadas hoy
    public function getHorasTrabajadasHoy2($user)
    {
         // Se obtiene los datos
         $id = $user->id;
         $fecha = Carbon::now()->toDateString();
         $hoy = Carbon::now();
         $resultado = 0;
         $totalMinutos2 = 0;


        $almuerzoHoras = 0;

        $jornadas = Jornada::where('admin_user_id', $id)
        ->whereDate('start_time', $hoy)
        ->get();

        $totalWorkedSeconds = 0;
        foreach($jornadas as $jornada){
            $workedSeconds = Carbon::parse($jornada->start_time)->diffInSeconds($jornada->end_time ?? Carbon::now());
            $totalPauseSeconds = $jornada->pauses->sum(function ($pause) {
                return Carbon::parse($pause->start_time)->diffInSeconds($pause->end_time ?? Carbon::now());
            });
            $totalWorkedSeconds += $workedSeconds - $totalPauseSeconds;
        }
        $horasTrabajadasFinal = $totalWorkedSeconds / 60;

        $hora = floor($horasTrabajadasFinal / 60);
        $minuto = ($horasTrabajadasFinal % 60);

        $horas_dia = $hora . ' Horas y ' . $minuto . ' minutos';

        return $horas_dia;
    }

    public function getLogTasks($idUsuario)
    {
        $events = [];
        $logs = LogTasks::where("admin_user_id", $idUsuario)->get();
        $end = Carbon::now()->format('Y-m-d H:i:s');
        $now = Carbon::now()->format('Y-m-d H:i:s');


        foreach ($logs as $index => $log) {

           $fin = $now;

           if ($log->date_end == null) {
                $nombre = isset($log->tarea->presupuesto->cliente->name) ? $log->tarea->presupuesto->cliente->name : 'El cliente no tiene nombre o no existe';

                $events[] =[
                    "Titulo: " . $log->tarea->title . "\n " . "Cliente: " . $nombre,
                    $log->date_start,
                    $fin,
                    $log->task_id,
                    '#FD994E'

                ];
            } else {
                $nombre = isset($log->tarea->presupuesto->cliente->name) ? $log->tarea->presupuesto->cliente->name : 'El cliente no tiene nombre o no existe';
                $events[] = [
                    "Titulo: " . $log->tarea->title . "\n " . "Cliente: " . $nombre,
                    $log->date_start,
                    $log->date_end,
                    $log->task_id,
                    '#FD994E'

                ];
            }
        }


    return $events;
}

}
