<?php

namespace App\Models\Models\Produccion;

use App\Models\Budgets\Budget;
use App\Models\Models\Produccion\Pieza;
use App\Models\Projects\Project;
use App\Models\Tasks\Task;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColaTrabajo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cola_trabajo';

    protected $fillable = [
        'proyecto_id',
        'presupuesto_id',
        'tarea_id',
        'pieza_id',
        'maquinaria_id',
        'tipo_trabajo_id',
        'usuario_asignado_id',
        'codigo_trabajo',
        'descripcion_trabajo',
        'especificaciones',
        'cantidad_piezas',
        'tiempo_estimado_horas',
        'tiempo_real_horas',
        'prioridad',
        'estado',
        'fecha_inicio_estimada',
        'fecha_fin_estimada',
        'fecha_inicio_real',
        'fecha_fin_real',
        'notas',
        'activo',
        'tiempo_pausado_minutos',
        'fecha_ultima_pausa',
        'tiempo_acumulado_minutos',
        'estado_tiempo',
        'notas_tiempo',
        'eficiencia_porcentaje'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'cantidad_piezas' => 'integer',
        'tiempo_estimado_horas' => 'decimal:2',
        'tiempo_real_horas' => 'decimal:2',
        'fecha_inicio_estimada' => 'datetime',
        'fecha_fin_estimada' => 'datetime',
        'fecha_inicio_real' => 'datetime',
        'fecha_fin_real' => 'datetime'
    ];

    // Relaciones
    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }

    public function presupuesto()
    {
        return $this->belongsTo(Budget::class, 'presupuesto_id');
    }

    public function tarea()
    {
        return $this->belongsTo(Task::class, 'tarea_id');
    }

    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class, 'maquinaria_id');
    }

    public function tipoTrabajo()
    {
        return $this->belongsTo(TipoTrabajo::class, 'tipo_trabajo_id');
    }

    public function usuarioAsignado()
    {
        return $this->belongsTo(User::class, 'usuario_asignado_id');
    }

    public function pieza()
    {
        return $this->belongsTo(Pieza::class, 'pieza_id');
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePendiente($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnCola($query)
    {
        return $query->where('estado', 'en_cola');
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }

    public function scopeCompletado($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    public function scopeUrgente($query)
    {
        return $query->where('prioridad', 'urgente');
    }

    // Accessors
    public function getPrioridadColorAttribute()
    {
        return [
            'baja' => 'secondary',
            'normal' => 'info',
            'alta' => 'warning',
            'urgente' => 'danger'
        ][$this->prioridad] ?? 'info';
    }

    public function getEstadoColorAttribute()
    {
        return [
            'pendiente' => 'secondary',
            'en_cola' => 'info',
            'en_proceso' => 'primary',
            'pausado' => 'warning',
            'completado' => 'success',
            'cancelado' => 'danger'
        ][$this->estado] ?? 'secondary';
    }

    public function getEstadoTextoAttribute()
    {
        return [
            'pendiente' => 'Pendiente',
            'en_cola' => 'En Cola',
            'en_proceso' => 'En Proceso',
            'pausado' => 'Pausado',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ][$this->estado] ?? 'Desconocido';
    }

    public function getPrioridadTextoAttribute()
    {
        return [
            'baja' => 'Baja',
            'normal' => 'Normal',
            'alta' => 'Alta',
            'urgente' => 'Urgente'
        ][$this->prioridad] ?? 'Normal';
    }

    // Métodos para control de tiempos
    public function iniciarTrabajo()
    {
        $this->update([
            'estado_tiempo' => 'en_progreso',
            'fecha_inicio_real' => now(),
            'fecha_ultima_pausa' => null
        ]);
    }

    public function pausarTrabajo()
    {
        if ($this->estado_tiempo === 'en_progreso') {
            $this->update([
                'estado_tiempo' => 'pausado',
                'fecha_ultima_pausa' => now()
            ]);
        }
    }

    public function reanudarTrabajo()
    {
        if ($this->estado_tiempo === 'pausado') {
            // Calcular tiempo pausado y agregarlo al acumulado
            $tiempoPausado = now()->diffInMinutes($this->fecha_ultima_pausa);
            $this->update([
                'estado_tiempo' => 'en_progreso',
                'tiempo_pausado_minutos' => $this->tiempo_pausado_minutos + $tiempoPausado,
                'fecha_ultima_pausa' => null
            ]);
        }
    }

    public function finalizarTrabajo()
    {
        if (in_array($this->estado_tiempo, ['en_progreso', 'pausado'])) {
            $tiempoTotal = $this->calcularTiempoTotal();

            $this->update([
                'estado_tiempo' => 'completado',
                'estado' => 'completado',
                'fecha_fin_real' => now(),
                'tiempo_real_horas' => $tiempoTotal / 60, // Convertir minutos a horas
                'eficiencia_porcentaje' => $this->calcularEficiencia($tiempoTotal)
            ]);
        }
    }

    public function calcularTiempoTotal()
    {
        if (!$this->fecha_inicio_real) {
            return 0;
        }

        $tiempoBase = now()->diffInMinutes($this->fecha_inicio_real);
        return $tiempoBase - $this->tiempo_pausado_minutos;
    }

    public function calcularEficiencia($tiempoTotalMinutos)
    {
        if (!$this->tiempo_estimado_horas) {
            return null;
        }

        $tiempoEstimadoMinutos = $this->tiempo_estimado_horas * 60;
        $eficiencia = ($tiempoEstimadoMinutos / $tiempoTotalMinutos) * 100;

        return round($eficiencia, 2);
    }

    public function getTiempoTranscurridoFormateadoAttribute()
    {
        $minutos = $this->calcularTiempoTotal();
        $horas = floor($minutos / 60);
        $minutosRestantes = $minutos % 60;

        return sprintf('%02d:%02d', $horas, $minutosRestantes);
    }

    public function getEstadoTiempoColorAttribute()
    {
        return match($this->estado_tiempo) {
            'no_iniciado' => 'secondary',
            'en_progreso' => 'primary',
            'pausado' => 'warning',
            'completado' => 'success',
            default => 'secondary'
        };
    }

    public function getEstadoTiempoTextoAttribute()
    {
        return match($this->estado_tiempo) {
            'no_iniciado' => 'No Iniciado',
            'en_progreso' => 'En Progreso',
            'pausado' => 'Pausado',
            'completado' => 'Completado',
            default => 'Desconocido'
        };
    }
}
