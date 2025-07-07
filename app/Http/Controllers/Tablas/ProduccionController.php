<?php

namespace App\Http\Controllers\Tablas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tablas\Produccion;
use App\Models\Projects\Project;
use App\Models\Clients\Client;
use Illuminate\Support\Facades\DB;

class ProduccionController extends Controller
{
    public function guardarTablaProduccion(Request $request, $project_id)
    {
        //dd($request->all);
        $data = $request->validate([
            'referencia' => 'required|string|max:255',
            'pedido_cliente' => 'required|string|max:255',
            'cliente' => 'required|string|max:255',
            'articulo' => 'required|string|max:255',
            'revision' => 'required|string|max:255',


            'trabajos' => 'required|array',
            'trabajos.*.nombre' => 'required|string',
            'trabajos.*.minutos' => 'nullable|numeric',
            'trabajos.*.coste_unitario' => 'nullable|numeric',
            'trabajos.*.total_coste' => 'nullable|numeric',
            'trabajos.*.precio_venta_unitario' => 'nullable|numeric',
            'trabajos.*.beneficio' => 'nullable|numeric',
            'trabajos.*.total_venta' => 'nullable|numeric',
            'total_horas' => 'nullable|numeric',
            'coste_total' => 'nullable|numeric',
            'venta_total' => 'nullable|numeric',


            'cortes' => 'required|array',
            'cortes.*.nombre' => 'required|string',
            'cortes.*.minutos' => 'nullable|numeric',
            'cortes.*.coste_unitario' => 'nullable|numeric',
            'cortes.*.total_coste' => 'nullable|numeric',
            'cortes.*.precio_venta_unitario' => 'nullable|numeric',
            'cortes.*.beneficio' => 'nullable|numeric',
            'cortes.*.total_venta' => 'nullable|numeric',
            'coste_total_corte' => 'nullable|numeric',
            'venta_total_corte' => 'nullable|numeric',


            'otros' => 'required|array',
            'otros.*.nombre' => 'required|string',
            'otros.*.minutos' => 'nullable|numeric',
            'otros.*.coste_unitario' => 'nullable|numeric',
            'otros.*.total_coste' => 'nullable|numeric',
            'otros.*.precio_venta_unitario' => 'nullable|numeric',
            'otros.*.beneficio' => 'nullable|numeric',
            'otros.*.total_venta' => 'nullable|numeric',
            'coste_total_otros' => 'nullable|numeric',
            'venta_total_otros' => 'nullable|numeric',


            'materiales' => 'required|array',
            'materiales.*.nombre' => 'required|string',
            'materiales.*.minutos' => 'nullable|numeric',
            'materiales.*.coste_unitario' => 'nullable|numeric',
            'materiales.*.total_coste' => 'nullable|numeric',
            'materiales.*.precio_venta_unitario' => 'nullable|numeric',
            'materiales.*.total_venta' => 'nullable|numeric',
            'coste_total_materiales' => 'nullable|numeric',
            'venta_total_materiales' => 'nullable|numeric',

            
            'longitud_unitaria_metro' => 'nullable|numeric',
            'total_unitaria_metro' => 'nullable|numeric',


            'longitud_unitaria_peso' => 'nullable|numeric',
            'total_unitaria_peso' => 'nullable|numeric',


            'beneficio_produccion_euro' => 'nullable|numeric',
            'beneficio_corte_euro' => 'nullable|numeric',
            'beneficio_otros_euro' => 'nullable|numeric',
            'beneficio_materiales_euro' => 'nullable|numeric',
            'gastos_financieros_euro' => 'nullable|numeric',
            'beneficio_corte_porcentaje' => 'nullable|numeric',

            'beneficio_produccion_porcentaje' => 'nullable|numeric',
            'beneficio_corte_porcentaje' => 'nullable|numeric',
            'beneficio_otros_porcentaje' => 'nullable|numeric',
            'beneficio_materiales_porcentaje' => 'nullable|numeric',
            'gastos_financieros_porcentaje' => 'nullable|numeric',
            'beneficio_teorico_total_porcentaje' => 'nullable|numeric',

            'precio_venta_total' => 'nullable|numeric',
            'unitario_total' => 'nullable|numeric',
            'unidades_valoradas' => 'nullable|numeric',


            'subasta_total' => 'nullable|numeric',
            'subasta_unitario' => 'nullable|numeric',
            'porcentaje_beneficio_total' => 'nullable|numeric',
            'euro_beneficio_total' => 'nullable|numeric',


            'porcentaje_deseado' => 'nullable|numeric',
            'precio_aproximado_facturar' => 'nullable|numeric',


            'calculo_materiales' => 'nullable|array',
            'calculo_materiales.*.unidad' => 'nullable|string|max:255',
            'calculo_materiales.*.descripcion' => 'nullable|string|max:255',
            'calculo_materiales.*.precio_unitario' => 'nullable|numeric',
            'calculo_materiales.*.coste_partida' => 'nullable|numeric',
            'calculo_materiales_total' => 'nullable|numeric',

            'calculo_material_laser' => 'nullable|array',
            'calculo_material_laser.*.metros' => 'nullable|numeric',
            'calculo_material_laser.*.descripcion' => 'nullable|string|max:255',
            'calculo_material_laser.*.precio_metro' => 'nullable|numeric',
            'calculo_material_laser.*.coste_partida' => 'nullable|numeric',
            'calculo_materiales_laser_total' => 'nullable|numeric',


            'tipos_tubos_laser' => 'nullable|integer',


            'materiales_precio_coste' => 'nullable|array',
            'materiales_precio_coste.*.nombre' => 'nullable|string',
            'materiales_precio_coste.*.precio' => 'nullable|string',

            'comerciales' => 'nullable|array',
            'comerciales.*.nombre' => 'nullable|string',
            'comerciales.*.codigo' => 'nullable|string',


            'calculo_precios_chapas' => 'nullable|array',
            'calculo_precios_chapas.*.unidad' => 'nullable|string',
            'calculo_precios_chapas.*.chapa' => 'nullable|string',
            'calculo_precios_chapas.*.largo' => 'nullable|string',
            'calculo_precios_chapas.*.ancho' => 'nullable|string',
            'calculo_precios_chapas.*.espesor' => 'nullable|string',
            'calculo_precios_chapas.*.material' => 'nullable|string',
            'calculo_precios_chapas.*.coste' => 'nullable|string',
            'calculo_precios_chapas.*.kg' => 'nullable|string',
            'calculo_precios_chapas_total_coste' => 'nullable|string',
            'calculo_precios_chapas_total_kg' => 'nullable|string',


            'comercial_seleccionado' => 'nullable|string',
            'tecnico_siglas' => 'nullable|string',


            'fecha_realizacion' => 'nullable|string'
        ]);

        $client = Client::where('name', $data['cliente'])->first();

        $produccion = Produccion::where('referencia', $data['referencia'])
            ->where('cliente_id', $client->id)
            ->first();
        
        if (!$produccion) {
            return redirect()->back()->with('error', 'No se encontró la producción a actualizar.');
        }

        $produccion->update([
            // 1ª tabla
            'cliente_id' => $client->id,
            'project_id' => $project_id,
            'referencia' => $data['referencia'],
            'pedido_cliente' => $data['pedido_cliente'],
            'articulo' => $data['articulo'],
            'revision' => $data['revision'],
            'trabajos' => $data['trabajos'],
            'total_horas' => $data['total_horas'],
            'total_coste' => $data['coste_total'],
            'total_venta' => $data['venta_total'],

            // 2ª tabla
            'cortes' => $data['cortes'],
            'total_coste_cortes' => $data['coste_total_corte'],
            'total_venta_cortes' => $data['venta_total_corte'],

            // 3ª tabla
            'otros' => $data['otros'],
            'total_coste_otros' => $data['coste_total_otros'],
            'total_venta_otros' => $data['venta_total_otros'],

            // 4ª tabla
            'materiales' => $data['materiales'],
            'total_coste_materiales' => $data['coste_total_materiales'],
            'total_venta_materiales' => $data['venta_total_materiales'],

            // 5ª tabla
            'precio_metro' => [
                'longitud_unitaria_metro' => $data['longitud_unitaria_metro'],
                'total_metro' => $data['total_unitaria_metro'],
            ],

            // 6ª tabla
            'precio_kg' => [
                'longitud_unitaria_peso' => $data['longitud_unitaria_peso'],
                'total_peso' => $data['total_unitaria_peso'],
            ],

            // 7ª tabla
            'resumen_venta' => [
                'beneficio_produccion_euro' => $data['beneficio_produccion_euro'],
                'beneficio_corte_euro' => $data['beneficio_corte_euro'],
                'beneficio_otros_euro' => $data['beneficio_otros_euro'],
                'beneficio_materiales_euro' => $data['beneficio_materiales_euro'],
                'gastos_financieros_euro' => $data['gastos_financieros_euro'],
                'beneficio_corte_porcentaje' => $data['beneficio_corte_porcentaje'],

                'beneficio_produccion_porcentaje' => $data['beneficio_produccion_porcentaje'],
                'beneficio_otros_porcentaje' => $data['beneficio_otros_porcentaje'],
                'beneficio_materiales_porcentaje' => $data['beneficio_materiales_porcentaje'],
                'gastos_financieros_porcentaje' => $data['gastos_financieros_porcentaje'],
                'beneficio_teorico_total_porcentaje' => $data['beneficio_teorico_total_porcentaje'],
            ],

            // 8ª tabla
            'precios_teoricos' => [
                'precio_venta_total' => $data['precio_venta_total'],
                'unitario_total' => $data['unitario_total'],
                'unidades_valoradas' => $data['unidades_valoradas'],
            ],

            // 9ª tabla
            'precio_final' => [
                'subasta_total' => $data['subasta_total'],
                'subasta_unitario' => $data['subasta_unitario'],
                'porcentaje_beneficio_total' => $data['porcentaje_beneficio_total'],
                'euro_beneficio_total' => $data['euro_beneficio_total'],
            ],

            // 10ª tabla
            'apoyo_facturar' => [
                'porcentaje_deseado' => $data['porcentaje_deseado'],
                'precio_aproximado_facturar' => $data['precio_aproximado_facturar'],
            ],

            // 11ª tabla
            'calculo_materiales' => $data['calculo_materiales'],
            'calculo_materiales_total' => $data['calculo_materiales_total'],

            // 12ª tabla
            'calculo_materiales_laser' => $data['calculo_material_laser'],
            'calculo_materiales_laser_total' => $data['calculo_materiales_laser_total'],

            // 13ª tabla
            'tipos_tubos_laser' => $data['tipos_tubos_laser'],

            // 14ª tabla
            'materiales_precio_coste' => $data['materiales_precio_coste'],
            'comerciales' => $data['comerciales'],

            // 15ª tabla
            'calculo_precios_chapas' => $data['calculo_precios_chapas'],
            'calculo_precios_chapas_total_coste' => $data['calculo_precios_chapas_total_coste'],
            'calculo_precios_chapas_total_kg' => $data['calculo_precios_chapas_total_kg'],

            // 16ª tabla
            'comercial_seleccionado' => $data['comercial_seleccionado'],
            'tecnico_siglas' => $data['tecnico_siglas'],

            // 17ª tabla
            'fecha_realizacion' => $data['fecha_realizacion']
        ]);

        return redirect()->route('tablas.index', ['project_id' => $project_id])
            ->with('success', 'Producción actualizada correctamente');
    }
}