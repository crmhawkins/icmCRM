<?php

namespace App\Models\Models\Produccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maquinaria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maquinaria';

    protected $fillable = [
        'nombre',
        'codigo',
        'modelo',
        'fabricante',
        'ano_fabricacion',
        'numero_serie',
        'descripcion',
        'ubicacion',
        'estado',
        'capacidad_maxima',
        'unidad_capacidad',
        'velocidad_operacion',
        'unidad_velocidad',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'ano_fabricacion' => 'integer',
        'capacidad_maxima' => 'decimal:2',
        'velocidad_operacion' => 'decimal:2'
    ];

    // Relaciones
    public function tiposTrabajo()
    {
        return $this->belongsToMany(TipoTrabajo::class, 'maquinaria_tipos_trabajo', 'maquinaria_id', 'tipo_trabajo_id')
                    ->withPivot('eficiencia', 'tiempo_setup_minutos', 'activo')
                    ->withTimestamps();
    }

    public function colaTrabajo()
    {
        return $this->hasMany(ColaTrabajo::class, 'maquinaria_id');
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopeOperativa($query)
    {
        return $query->where('estado', 'operativa');
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    // Accessors
    public function getEstadoColorAttribute()
    {
        return [
            'operativa' => 'success',
            'mantenimiento' => 'warning',
            'reparacion' => 'danger',
            'inactiva' => 'secondary'
        ][$this->estado] ?? 'secondary';
    }

    public function getEstadoTextoAttribute()
    {
        return [
            'operativa' => 'Operativa',
            'mantenimiento' => 'En Mantenimiento',
            'reparacion' => 'En Reparación',
            'inactiva' => 'Inactiva'
        ][$this->estado] ?? 'Desconocido';
    }
}
