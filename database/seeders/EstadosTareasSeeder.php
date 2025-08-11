<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tasks\TaskStatus;

class EstadosTareasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Pendiente'],
            ['name' => 'En Análisis'],
            ['name' => 'En Diseño'],
            ['name' => 'En Fabricación'],
            ['name' => 'En Corte'],
            ['name' => 'En Soldadura'],
            ['name' => 'En Mecanizado'],
            ['name' => 'En Montaje'],
            ['name' => 'En Acabados'],
            ['name' => 'En Verificación'],
            ['name' => 'En Embalaje'],
            ['name' => 'En Obra'],
            ['name' => 'Completado'],
            ['name' => 'Cancelado'],
            ['name' => 'En Pausa'],
            ['name' => 'Urgente'],
        ];

        foreach ($statuses as $status) {
            TaskStatus::create($status);
        }
    }
}
