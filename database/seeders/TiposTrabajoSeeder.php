<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Models\Produccion\TipoTrabajo;

class TiposTrabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposTrabajo = [
            [
                'nombre' => 'Diseño y Planificación',
                'codigo' => 'DISENO',
                'descripcion' => 'Diseño inicial y planificación del trabajo',
                'tiempo_estimado_horas' => 2.0,
                'requiere_maquinaria' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Corte de Metal',
                'codigo' => 'CORTE_METAL',
                'descripcion' => 'Corte de materiales metálicos',
                'tiempo_estimado_horas' => 1.5,
                'requiere_maquinaria' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Corte de Aluminio',
                'codigo' => 'CORTE_ALUM',
                'descripcion' => 'Corte específico de aluminio',
                'tiempo_estimado_horas' => 1.0,
                'requiere_maquinaria' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Corte de Madera',
                'codigo' => 'CORTE_MADERA',
                'descripcion' => 'Corte de materiales de madera',
                'tiempo_estimado_horas' => 1.0,
                'requiere_maquinaria' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Soldadura',
                'codigo' => 'SOLDADURA',
                'descripcion' => 'Soldadura de piezas metálicas',
                'tiempo_estimado_horas' => 2.0,
                'requiere_maquinaria' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Manejo de Material Pesado',
                'codigo' => 'MANEJO_PESADO',
                'descripcion' => 'Manejo y transporte de materiales pesados',
                'tiempo_estimado_horas' => 0.5,
                'requiere_maquinaria' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Acabado y Pulido',
                'codigo' => 'ACABADO',
                'descripcion' => 'Acabado final y pulido de piezas',
                'tiempo_estimado_horas' => 1.0,
                'requiere_maquinaria' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Control de Calidad',
                'codigo' => 'CALIDAD',
                'descripcion' => 'Verificación y control de calidad final',
                'tiempo_estimado_horas' => 0.5,
                'requiere_maquinaria' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Montaje',
                'codigo' => 'MONTAJE',
                'descripcion' => 'Montaje y ensamblaje de piezas',
                'tiempo_estimado_horas' => 1.5,
                'requiere_maquinaria' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Pintura',
                'codigo' => 'PINTURA',
                'descripcion' => 'Aplicación de pintura y acabados',
                'tiempo_estimado_horas' => 1.0,
                'requiere_maquinaria' => false,
                'activo' => true
            ]
        ];

        foreach ($tiposTrabajo as $tipo) {
            TipoTrabajo::updateOrCreate(
                ['nombre' => $tipo['nombre']],
                $tipo
            );
        }

        $this->command->info('Tipos de trabajo creados exitosamente.');
    }
}
