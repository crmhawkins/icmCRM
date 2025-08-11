<?php

namespace App\Models\Models\Produccion;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArchivoPieza extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'archivos_piezas';

    protected $fillable = [
        'pieza_id',
        'nombre_archivo',
        'nombre_original',
        'ruta_archivo',
        'extension',
        'tipo_archivo',
        'version',
        'descripcion',
        'tamaño_mb',
        'hash_archivo',
        'usuario_subido_id',
        'es_principal',
        'activo'
    ];

    protected $casts = [
        'tamaño_mb' => 'decimal:2',
        'es_principal' => 'boolean',
        'activo' => 'boolean'
    ];

    // Relaciones
    public function pieza()
    {
        return $this->belongsTo(Pieza::class, 'pieza_id');
    }

    public function usuarioSubido()
    {
        return $this->belongsTo(User::class, 'usuario_subido_id');
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_archivo', $tipo);
    }

    public function scopePlanos($query)
    {
        return $query->whereIn('tipo_archivo', ['plano_pdf', 'plano_daw', 'plano_dwg']);
    }

    public function scopePrincipales($query)
    {
        return $query->where('es_principal', true);
    }

    public function scopePDF($query)
    {
        return $query->where('tipo_archivo', 'plano_pdf');
    }

    public function scopeDAW($query)
    {
        return $query->where('tipo_archivo', 'plano_daw');
    }

    public function scopeDWG($query)
    {
        return $query->where('tipo_archivo', 'plano_dwg');
    }

    // Accessors
    public function getTipoArchivoColorAttribute()
    {
        return [
            'plano_pdf' => 'danger',
            'plano_daw' => 'primary',
            'plano_dwg' => 'success',
            'imagen' => 'info',
            'documento' => 'warning',
            'especificacion' => 'secondary',
            'otro' => 'dark'
        ][$this->tipo_archivo] ?? 'secondary';
    }

    public function getTipoArchivoTextoAttribute()
    {
        return [
            'plano_pdf' => 'Plano PDF',
            'plano_daw' => 'Plano DAW',
            'plano_dwg' => 'Plano DWG',
            'imagen' => 'Imagen',
            'documento' => 'Documento',
            'especificacion' => 'Especificación',
            'otro' => 'Otro'
        ][$this->tipo_archivo] ?? 'Desconocido';
    }

    public function getTamañoFormateadoAttribute()
    {
        if (!$this->tamaño_mb) return 'N/A';
        
        if ($this->tamaño_mb < 1) {
            return round($this->tamaño_mb * 1024, 2) . ' KB';
        } elseif ($this->tamaño_mb < 1024) {
            return round($this->tamaño_mb, 2) . ' MB';
        } else {
            return round($this->tamaño_mb / 1024, 2) . ' GB';
        }
    }

    public function getUrlDescargaAttribute()
    {
        return route('archivos-piezas.download', $this->id);
    }

    public function getUrlVistaAttribute()
    {
        if (in_array($this->extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif'])) {
            return route('archivos-piezas.view', $this->id);
        }
        return null;
    }

    public function getEsDescargableAttribute()
    {
        return true; // Todos los archivos son descargables
    }

    public function getEsVisualizableAttribute()
    {
        return in_array($this->extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif']);
    }

    // Métodos
    public function marcarComoPrincipal()
    {
        // Desmarcar otros archivos principales de la misma pieza
        $this->pieza->archivos()->where('es_principal', true)->update(['es_principal' => false]);
        
        // Marcar este como principal
        $this->es_principal = true;
        $this->save();
        
        // Actualizar el estado de archivos de la pieza
        $this->pieza->actualizarEstadoArchivos();
    }

    public function calcularHash()
    {
        if (file_exists(storage_path('app/' . $this->ruta_archivo))) {
            $this->hash_archivo = hash_file('sha256', storage_path('app/' . $this->ruta_archivo));
            $this->save();
        }
    }

    public function verificarIntegridad()
    {
        if (!$this->hash_archivo) return false;
        
        if (!file_exists(storage_path('app/' . $this->ruta_archivo))) return false;
        
        $hashActual = hash_file('sha256', storage_path('app/' . $this->ruta_archivo));
        return $hashActual === $this->hash_archivo;
    }

    public function obtenerRutaCompleta()
    {
        return storage_path('app/' . $this->ruta_archivo);
    }

    public function existeArchivo()
    {
        return file_exists($this->obtenerRutaCompleta());
    }
}
