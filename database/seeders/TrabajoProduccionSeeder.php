<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tablas\TrabajoProduccion;

class TrabajoProduccionSeeder extends Seeder
{
    public function run(): void
    {
        $trabajos = [
            ['CIZALLA Y/O PLEGADORA', 32.05, 39.60, 24],
            ['CORTE DE SIERRA', 32.05, 37.80, 18],
            ['MONTAJE DE PIEZAS PUNT.', 32.05, 39.60, 24],
            ['TORNO Y FRESA', 32.05, 43.00, 31],
            ['SOLDADURA A/C', 32.05, 39.60, 24],
            ['SOLDADURA ALUMINIO', 32.05, 39.60, 24],
            ['SOLDADURA INOX', 32.05, 39.60, 24],
            ['CHORREADO Y LIMPIEZA', 32.05, 39.60, 24],
            ['TERMINACIÓN Y PINTURA', 32.05, 39.60, 24],
            ['VERIFICACIÓN', 27.30, 35.00, 28],
            ['EMBALAJE', 32.05, 35.00, 9],
            ['TÉCNICOS', 32.05, 39.60, 24],
            ['MONTAJE EN OBRA', 32.05, 39.60, 24],
            ['MONTAJE ELÉCTRICO E HIDRÁULICO', 32.05, 39.60, 24],
            ['SUMATORIO DE TIEMPOS (SI NO HAY DESGLOSE)', 31.90, 37.50, 18],
        ];

        foreach ($trabajos as [$nombre, $coste, $venta, $beneficio]) {
            TrabajoProduccion::create([
                'nombre' => $nombre,
                'coste_unitario' => $coste,
                'precio_venta_unitario' => $venta,
                'beneficio' => $beneficio,
            ]);
        }
    }
}
