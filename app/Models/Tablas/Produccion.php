<?php

namespace App\Models\Tablas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Clients\Client;

class Produccion extends Model
{
    use HasFactory;

    protected $table = 'producciones';

    protected $fillable = [
        'cliente_id', 'project_id', 'referencia', 'pedido_cliente', 'articulo', 'revision', 'trabajos',
        'materiales', 'cortes', 'otros', 'total_horas', 'total_coste', 'total_venta', 'total_coste_materiales', 'total_venta_materiales',
        'total_coste_cortes', 'total_venta_cortes', 'total_coste_otros', 'total_venta_otros', 'precio_metro', 'precio_kg', 'resumen_venta',
        'precios_teoricos', 'precio_final', 'apoyo_facturar', 'calculo_materiales', 'calculo_materiales_laser', 'calculo_materiales_total', 
        'calculo_materiales_laser_total', 'tipos_tubos_laser', 'materiales_precio_coste', 'comerciales', 'calculo_precios_chapas', 
        'calculo_precios_chapas_total_coste', 'calculo_precios_chapas_total_kg', 'comercial_seleccionado', 'tecnico_siglas', 'fecha_realizacion'
    ];

    protected $casts = [
        'trabajos' => 'array',
        'cortes' => 'array',
        'otros' => 'array',
        'materiales' => 'array',
        'precio_metro' => 'array',
        'precio_kg' => 'array',
        'resumen_venta' => 'array',
        'precios_teoricos' => 'array',
        'precio_final' => 'array',
        'apoyo_facturar' => 'array',
        'calculo_materiales' => 'array',
        'calculo_materiales_laser' => 'array',
        'materiales_precio_coste' => 'array',
        'comerciales' => 'array',
        'calculo_precios_chapas' => 'array',
    ];

    /**
     * Relación con el modelo Cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Client::class);
    }
}
