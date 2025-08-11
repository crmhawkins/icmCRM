<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Models\Produccion\Pieza;
use App\Models\Produccion\SeguimientoPieza;

class SeguimientoPiezasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las piezas existentes
        $piezas = Pieza::all();

        foreach ($piezas as $pieza) {
            // Crear un seguimiento para cada pieza con datos de ejemplo
            SeguimientoPieza::create([
                'pieza_id' => $pieza->id,
                'codigo_pieza' => $pieza->codigo_pieza,
                'nombre_pieza' => $pieza->nombre_pieza,
                'descripcion' => $pieza->descripcion,
                'cantidad' => $pieza->cantidad,
                'precio_unitario' => $pieza->precio_unitario,
                
                // Datos de ejemplo para trabajos de producción
                'tiempo_produccion_min' => rand(30, 180),
                'coste_produccion_unitario' => 39.00,
                
                // Datos de ejemplo para corte láser
                'tiempo_corte_laser_min' => rand(10, 60),
                'coste_corte_laser_unitario' => 99.00,
                
                // Datos de ejemplo para otros servicios
                'cantidad_otros_servicios' => rand(0, 2),
                'coste_otros_servicios_unitario' => 20.00,
                'tipo_otros_servicios' => ['CHORREADO', 'PINTURA', 'MONTAJE'][rand(0, 2)],
                
                // Datos de ejemplo para materiales
                'cantidad_materiales' => rand(1, 5),
                'coste_materiales_unitario' => 15.00,
                'porcentaje_beneficio_materiales' => 10.00,
                
                // Datos de ejemplo para materiales específicos
                'descripcion_material' => 'PINTURA RAL 9005',
                'precio_unitario_material' => 11.00,
                
                // Datos de ejemplo para tubos
                'metros_tubos' => rand(0, 10),
                'descripcion_tubos' => 'TUBO A/C 40x40x3',
                'precio_metro_tubos' => 8.50,
                
                // Datos de ejemplo para chapas
                'cantidad_chapas' => rand(0, 3),
                'tipo_chapa' => ['A/C', 'AISI 304', 'ALUMINIO'][rand(0, 2)],
                'largo_chapa_mm' => rand(200, 1000),
                'ancho_chapa_mm' => rand(200, 500),
                'espesor_chapa_mm' => rand(2, 10),
                'material_chapa' => 'A/C',
                'coste_chapa' => rand(10, 50),
                'peso_chapa_kg' => rand(1, 20),
                
                // Configuración de beneficios
                'gastos_financieros_porcentaje' => 4.00,
                'porcentaje_deseado_facturacion' => 20.00,
                
                // Estado
                'estado' => ['pendiente', 'en_proceso', 'completado'][rand(0, 2)],
                'comercial_tecnico' => ['MAC', 'EP', 'JFE'][rand(0, 2)],
                'observaciones' => 'Datos de ejemplo generados automáticamente',
            ]);
        }

        $this->command->info('Se han creado ' . $piezas->count() . ' registros de seguimiento de piezas.');
    }
} 