<?php

namespace App\Models\Models\Produccion;

use App\Models\Budgets\Budget;
use App\Models\Projects\Project;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pedidos';

    protected $fillable = [
        'numero_pedido',
        'codigo_cliente',
        'nombre_cliente',
        'fecha_pedido',
        'fecha_entrega_estimada',
        'descripcion_general',
        'total_piezas',
        'valor_total',
        'moneda',
        'estado',
        'notas_ia',
        'notas_manuales',
        'archivo_pdf_original',
        'usuario_procesador_id',
        'proyecto_id',
        'presupuesto_id',
        'procesado_ia',
        'fecha_procesamiento_ia',
        'activo'
    ];

    protected $casts = [
        'fecha_pedido' => 'date',
        'fecha_entrega_estimada' => 'date',
        'valor_total' => 'decimal:2',
        'procesado_ia' => 'boolean',
        'fecha_procesamiento_ia' => 'datetime',
        'activo' => 'boolean'
    ];

    // Relaciones
    public function piezas()
    {
        return $this->hasMany(Pieza::class, 'pedido_id');
    }



    public function usuarioProcesador()
    {
        return $this->belongsTo(User::class, 'usuario_procesador_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }

    public function presupuesto()
    {
        return $this->belongsTo(Budget::class, 'presupuesto_id');
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

    public function scopePendienteAnalisis($query)
    {
        return $query->where('estado', 'pendiente_analisis');
    }

    public function scopeAnalizado($query)
    {
        return $query->where('estado', 'analizado');
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }

    public function scopeCompletado($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopeProcesadoIA($query)
    {
        return $query->where('procesado_ia', true);
    }

    public function scopeNoProcesadoIA($query)
    {
        return $query->where('procesado_ia', false);
    }

    // Accessors
    public function getEstadoColorAttribute()
    {
        return [
            'pendiente_analisis' => 'warning',
            'analizado' => 'info',
            'en_proceso' => 'primary',
            'completado' => 'success',
            'cancelado' => 'danger'
        ][$this->estado] ?? 'secondary';
    }

    public function getEstadoTextoAttribute()
    {
        return [
            'pendiente_analisis' => 'Pendiente de Análisis',
            'analizado' => 'Analizado',
            'en_proceso' => 'En Proceso',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ][$this->estado] ?? 'Desconocido';
    }

    public function getPiezasCompletadasAttribute()
    {
        return $this->piezas()->where('estado', 'completada')->count();
    }

    public function getPiezasPendientesAttribute()
    {
        return $this->piezas()->whereIn('estado', ['pendiente', 'en_diseno', 'en_fabricacion'])->count();
    }

    public function getProgresoAttribute()
    {
        if ($this->total_piezas == 0) return 0;
        return round(($this->piezas_completadas / $this->total_piezas) * 100, 2);
    }

    // Métodos
    public function calcularTotalPiezas()
    {
        $this->total_piezas = $this->piezas()->count();
        $this->save();
    }

    public function calcularValorTotal()
    {
        $this->valor_total = $this->piezas()->sum('precio_total');
        $this->save();
    }

    public function marcarComoProcesadoIA()
    {
        $this->procesado_ia = true;
        $this->fecha_procesamiento_ia = now();
        $this->save();
    }
}
