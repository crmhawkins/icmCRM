<?php

namespace App\Models\Models\Produccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoTrabajo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_trabajo';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'orden',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer'
    ];

    // Relaciones
    public function maquinaria()
    {
        return $this->belongsToMany(Maquinaria::class, 'maquinaria_tipos_trabajo', 'tipo_trabajo_id', 'maquinaria_id')
                    ->withPivot('eficiencia', 'tiempo_setup_minutos', 'activo')
                    ->withTimestamps();
    }

    public function colaTrabajo()
    {
        return $this->hasMany(ColaTrabajo::class, 'tipo_trabajo_id');
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('orden', 'asc')->orderBy('nombre', 'asc');
    }
}
