<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Models\Produccion\Maquinaria;

class MaquinariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maquinaria = [
            [
                'nombre' => 'Cortadora Láser CNC',
                'codigo' => 'LASER_CNC_001',
                'modelo' => 'Fiber Laser 2000W',
                'fabricante' => 'Bystronic',
                'ano_fabricacion' => 2023,
                'numero_serie' => 'LC001-2023',
                'descripcion' => 'Cortadora láser de fibra de alta potencia para metales',
                'ubicacion' => 'Taller Principal',
                'estado' => 'operativa',
                'capacidad_maxima' => 2000.00,
                'unidad_capacidad' => 'W',
                'velocidad_operacion' => 120.00,
                'unidad_velocidad' => 'm/min',
                'activo' => true
            ],
            [
                'nombre' => 'Torno CNC',
                'codigo' => 'TORNO_CNC_001',
                'modelo' => 'TL-250',
                'fabricante' => 'Haas',
                'ano_fabricacion' => 2022,
                'numero_serie' => 'TC001-2022',
                'descripcion' => 'Torno CNC de precisión para piezas metálicas',
                'ubicacion' => 'Taller Mecánico',
                'estado' => 'operativa',
                'capacidad_maxima' => 500.00,
                'unidad_capacidad' => 'mm',
                'velocidad_operacion' => 3000.00,
                'unidad_velocidad' => 'rpm',
                'activo' => true
            ],
            [
                'nombre' => 'Fresadora CNC',
                'codigo' => 'FRESADORA_CNC_001',
                'modelo' => 'VF-2',
                'fabricante' => 'Haas',
                'ano_fabricacion' => 2022,
                'numero_serie' => 'FC001-2022',
                'descripcion' => 'Fresadora CNC de 3 ejes para mecanizado',
                'ubicacion' => 'Taller Mecánico',
                'estado' => 'operativa',
                'capacidad_maxima' => 400.00,
                'unidad_capacidad' => 'mm',
                'velocidad_operacion' => 8100.00,
                'unidad_velocidad' => 'rpm',
                'activo' => true
            ],
            [
                'nombre' => 'Soldadora MIG',
                'codigo' => 'SOLDADORA_MIG_001',
                'modelo' => 'PowerMig 350MP',
                'fabricante' => 'Miller',
                'ano_fabricacion' => 2021,
                'numero_serie' => 'SM001-2021',
                'descripcion' => 'Soldadora MIG multiproceso',
                'ubicacion' => 'Área de Soldadura',
                'estado' => 'operativa',
                'capacidad_maxima' => 350.00,
                'unidad_capacidad' => 'A',
                'velocidad_operacion' => 0.00,
                'unidad_velocidad' => 'A',
                'activo' => true
            ],
            [
                'nombre' => 'Prensa Hidráulica',
                'codigo' => 'PRENSA_HID_001',
                'modelo' => 'PH-100',
                'fabricante' => 'Dake',
                'ano_fabricacion' => 2020,
                'numero_serie' => 'PH001-2020',
                'descripcion' => 'Prensa hidráulica de 100 toneladas',
                'ubicacion' => 'Taller de Formado',
                'estado' => 'operativa',
                'capacidad_maxima' => 100.00,
                'unidad_capacidad' => 'ton',
                'velocidad_operacion' => 0.00,
                'unidad_velocidad' => 'mm/s',
                'activo' => true
            ]
        ];

        foreach ($maquinaria as $maq) {
            Maquinaria::updateOrCreate(
                ['codigo' => $maq['codigo']],
                $maq
            );
        }

        $this->command->info('Maquinaria creada exitosamente.');
    }
}
