<?php

namespace App\Models\Models\Produccion;

use App\Models\Models\Produccion\Maquinaria;
use App\Models\Models\Produccion\TipoTrabajo;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pieza extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'piezas';

    protected $fillable = [
        'pedido_id',
        'codigo_pieza',
        'nombre_pieza',
        'descripcion',
        'cantidad',
        'material',
        'acabado',
        'dimensiones_largo',
        'dimensiones_ancho',
        'dimensiones_alto',
        'unidad_medida',
        'peso_unitario',
        'unidad_peso',
        'precio_unitario',
        'precio_total',
        'especificaciones_tecnicas',
        'notas_fabricacion',
        'estado',
        'tipo_trabajo_id',
        'maquinaria_asignada_id',
        'usuario_asignado_id',
        'prioridad',
        'fecha_inicio_estimada',
        'fecha_fin_estimada',
        'fecha_inicio_real',
        'fecha_fin_real',
        'tiempo_estimado_horas',
        'tiempo_real_horas',
        'tiene_plano',
        'tiene_daw',
        'activo'
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'dimensiones_largo' => 'decimal:2',
        'dimensiones_ancho' => 'decimal:2',
        'dimensiones_alto' => 'decimal:2',
        'peso_unitario' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'precio_total' => 'decimal:2',
        'prioridad' => 'integer',
        'fecha_inicio_estimada' => 'datetime',
        'fecha_fin_estimada' => 'datetime',
        'fecha_inicio_real' => 'datetime',
        'fecha_fin_real' => 'datetime',
        'tiempo_estimado_horas' => 'decimal:2',
        'tiempo_real_horas' => 'decimal:2',
        'tiene_plano' => 'boolean',
        'tiene_daw' => 'boolean',
        'activo' => 'boolean'
    ];

    // Relaciones
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function tipoTrabajo()
    {
        return $this->belongsTo(TipoTrabajo::class, 'tipo_trabajo_id');
    }

    public function maquinariaAsignada()
    {
        return $this->belongsTo(Maquinaria::class, 'maquinaria_asignada_id');
    }

    public function usuarioAsignado()
    {
        return $this->belongsTo(User::class, 'usuario_asignado_id');
    }

    public function archivos()
    {
        return $this->hasMany(ArchivoPieza::class, 'pieza_id');
    }

    public function archivoPrincipal()
    {
        return $this->hasOne(ArchivoPieza::class, 'pieza_id')->where('es_principal', true);
    }

    public function colaTrabajo()
    {
        return $this->hasMany(ColaTrabajo::class, 'pieza_id');
    }

    public function seguimiento()
    {
        return $this->hasOne(\App\Models\Produccion\SeguimientoPieza::class, 'pieza_id');
    }

    public function planos()
    {
        return $this->hasMany(ArchivoPieza::class, 'pieza_id')
            ->whereIn('tipo_archivo', ['plano_pdf', 'plano_daw', 'plano_dwg']);
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $this->where('activo', true);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePendiente($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnDiseno($query)
    {
        return $query->where('estado', 'en_diseno');
    }

    public function scopeEnFabricacion($query)
    {
        return $query->where('estado', 'en_fabricacion');
    }

    public function scopeCompletada($query)
    {
        return $query->where('estado', 'completada');
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    public function scopeAltaPrioridad($query)
    {
        return $query->where('prioridad', '>=', 8);
    }

    public function scopeConPlanos($query)
    {
        return $query->where('tiene_plano', true);
    }

    public function scopeSinPlanos($query)
    {
        return $query->where('tiene_plano', false);
    }

    // Accessors
    public function getEstadoColorAttribute()
    {
        return [
            'pendiente' => 'secondary',
            'en_diseno' => 'info',
            'en_fabricacion' => 'primary',
            'en_control_calidad' => 'warning',
            'completada' => 'success',
            'cancelada' => 'danger'
        ][$this->estado] ?? 'secondary';
    }

    public function getEstadoTextoAttribute()
    {
        return [
            'pendiente' => 'Pendiente',
            'en_diseno' => 'En Diseño',
            'en_fabricacion' => 'En Fabricación',
            'en_control_calidad' => 'En Control de Calidad',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada'
        ][$this->estado] ?? 'Desconocido';
    }

    public function getPrioridadColorAttribute()
    {
        if ($this->prioridad >= 8) return 'danger';
        if ($this->prioridad >= 6) return 'warning';
        if ($this->prioridad >= 4) return 'info';
        return 'secondary';
    }

    public function getPrioridadTextoAttribute()
    {
        if ($this->prioridad >= 8) return 'Muy Alta';
        if ($this->prioridad >= 6) return 'Alta';
        if ($this->prioridad >= 4) return 'Media';
        return 'Baja';
    }

    public function getDimensionesCompletasAttribute()
    {
        $dimensiones = [];
        if ($this->dimensiones_largo) $dimensiones[] = $this->dimensiones_largo . ' ' . $this->unidad_medida;
        if ($this->dimensiones_ancho) $dimensiones[] = $this->dimensiones_ancho . ' ' . $this->unidad_medida;
        if ($this->dimensiones_alto) $dimensiones[] = $this->dimensiones_alto . ' ' . $this->unidad_medida;

        return implode(' x ', $dimensiones);
    }

    public function getPesoCompletoAttribute()
    {
        if (!$this->peso_unitario) return null;
        return $this->peso_unitario * $this->cantidad . ' ' . $this->unidad_peso;
    }

    // Métodos
    public function calcularPrecioTotal()
    {
        if ($this->precio_unitario && $this->cantidad) {
            $this->precio_total = $this->precio_unitario * $this->cantidad;
            $this->save();
        }
    }

    public function actualizarEstadoArchivos()
    {
        $this->tiene_plano = $this->archivos()->whereIn('tipo_archivo', ['plano_pdf', 'plano_dwg'])->exists();
        $this->tiene_daw = $this->archivos()->where('tipo_archivo', 'plano_daw')->exists();
        $this->save();
    }

    public function iniciarFabricacion()
    {
        $this->estado = 'en_fabricacion';
        $this->fecha_inicio_real = now();
        $this->save();
    }

    public function completarFabricacion()
    {
        $this->estado = 'completada';
        $this->fecha_fin_real = now();
        if ($this->fecha_inicio_real) {
            $this->tiempo_real_horas = $this->fecha_inicio_real->diffInHours($this->fecha_fin_real);
        }
        $this->save();
    }
}
