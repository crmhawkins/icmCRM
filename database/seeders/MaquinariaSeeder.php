<?php

namespace Database\Seeders;

use App\Models\Models\Produccion\Maquinaria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaquinariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maquinaria = [
            [
                'nombre' => 'Cizalla Hidráulica 1',
                'codigo' => 'CIZ-001',
                'modelo' => 'CH-3000',
                'fabricante' => 'LVD',
                'ano_fabricacion' => 2020,
                'numero_serie' => 'LVD2020CH3000-001',
                'descripcion' => 'Cizalla hidráulica para corte de chapa hasta 6mm',
                'ubicacion' => 'Taller Principal',
                'estado' => 'operativa',
                'capacidad_maxima' => 6.0,
                'unidad_capacidad' => 'mm',
                'velocidad_operacion' => 25.0,
                'unidad_velocidad' => 'golpes/min'
            ],
            [
                'nombre' => 'Plegadora Hidráulica 1',
                'codigo' => 'PLE-001',
                'modelo' => 'PH-4000',
                'fabricante' => 'LVD',
                'ano_fabricacion' => 2019,
                'numero_serie' => 'LVD2019PH4000-001',
                'descripcion' => 'Plegadora hidráulica para doblado de chapa',
                'ubicacion' => 'Taller Principal',
                'estado' => 'operativa',
                'capacidad_maxima' => 8.0,
                'unidad_capacidad' => 'mm',
                'velocidad_operacion' => 15.0,
                'unidad_velocidad' => 'golpes/min'
            ],
            [
                'nombre' => 'Sierra de Cinta 1',
                'codigo' => 'SIE-001',
                'modelo' => 'SC-500',
                'fabricante' => 'Kasto',
                'ano_fabricacion' => 2021,
                'numero_serie' => 'KAS2021SC500-001',
                'descripcion' => 'Sierra de cinta automática para corte de perfiles',
                'ubicacion' => 'Taller de Corte',
                'estado' => 'operativa',
                'capacidad_maxima' => 500.0,
                'unidad_capacidad' => 'mm',
                'velocidad_operacion' => 120.0,
                'unidad_velocidad' => 'm/min'
            ],
            [
                'nombre' => 'Torno CNC 1',
                'codigo' => 'TOR-001',
                'modelo' => 'TC-800',
                'fabricante' => 'Haas',
                'ano_fabricacion' => 2022,
                'numero_serie' => 'HAA2022TC800-001',
                'descripcion' => 'Torno CNC para mecanizado de piezas cilíndricas',
                'ubicacion' => 'Taller de Mecanizado',
                'estado' => 'operativa',
                'capacidad_maxima' => 800.0,
                'unidad_capacidad' => 'mm',
                'velocidad_operacion' => 4000.0,
                'unidad_velocidad' => 'rpm'
            ],
            [
                'nombre' => 'Fresadora CNC 1',
                'codigo' => 'FRE-001',
                'modelo' => 'FC-1000',
                'fabricante' => 'Haas',
                'ano_fabricacion' => 2021,
                'numero_serie' => 'HAA2021FC1000-001',
                'descripcion' => 'Fresadora CNC para mecanizado de superficies',
                'ubicacion' => 'Taller de Mecanizado',
                'estado' => 'operativa',
                'capacidad_maxima' => 1000.0,
                'unidad_capacidad' => 'mm',
                'velocidad_operacion' => 8000.0,
                'unidad_velocidad' => 'rpm'
            ],
            [
                'nombre' => 'Soldadora MIG 1',
                'codigo' => 'SOL-MIG-001',
                'modelo' => 'SM-350',
                'fabricante' => 'Lincoln Electric',
                'ano_fabricacion' => 2020,
                'numero_serie' => 'LIN2020SM350-001',
                'descripcion' => 'Soldadora MIG para acero al carbono',
                'ubicacion' => 'Taller de Soldadura',
                'estado' => 'operativa',
                'capacidad_maxima' => 350.0,
                'unidad_capacidad' => 'A',
                'velocidad_operacion' => 15.0,
                'unidad_velocidad' => 'm/min'
            ],
            [
                'nombre' => 'Soldadora TIG 1',
                'codigo' => 'SOL-TIG-001',
                'modelo' => 'ST-200',
                'fabricante' => 'Miller',
                'ano_fabricacion' => 2021,
                'numero_serie' => 'MIL2021ST200-001',
                'descripcion' => 'Soldadora TIG para aluminio e inoxidable',
                'ubicacion' => 'Taller de Soldadura',
                'estado' => 'operativa',
                'capacidad_maxima' => 200.0,
                'unidad_capacidad' => 'A',
                'velocidad_operacion' => 8.0,
                'unidad_velocidad' => 'm/min'
            ],
            [
                'nombre' => 'Cabina de Chorreado 1',
                'codigo' => 'CHO-001',
                'modelo' => 'CC-5000',
                'fabricante' => 'Clemco',
                'ano_fabricacion' => 2019,
                'numero_serie' => 'CLE2019CC5000-001',
                'descripcion' => 'Cabina de chorreado para limpieza de superficies',
                'ubicacion' => 'Taller de Acabados',
                'estado' => 'operativa',
                'capacidad_maxima' => 5000.0,
                'unidad_capacidad' => 'mm',
                'velocidad_operacion' => 20.0,
                'unidad_velocidad' => 'm²/h'
            ],
            [
                'nombre' => 'Cabina de Pintura 1',
                'codigo' => 'PIN-001',
                'modelo' => 'CP-3000',
                'fabricante' => 'Gema',
                'ano_fabricacion' => 2020,
                'numero_serie' => 'GEM2020CP3000-001',
                'descripcion' => 'Cabina de pintura con sistema de aspiración',
                'ubicacion' => 'Taller de Acabados',
                'estado' => 'operativa',
                'capacidad_maxima' => 3000.0,
                'unidad_capacidad' => 'mm',
                'velocidad_operacion' => 15.0,
                'unidad_velocidad' => 'm²/h'
            ]
        ];

        foreach ($maquinaria as $maq) {
            Maquinaria::create($maq);
        }

        $this->command->info('Maquinaria creada exitosamente: ' . count($maquinaria) . ' máquinas');
    }
}
