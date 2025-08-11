<?php

namespace Database\Seeders;

use App\Models\Users\UserPosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PosicionesUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            // Dirección
            ['name' => 'Director General'],
            ['name' => 'Director Técnico'],
            ['name' => 'Director Comercial'],
            ['name' => 'Director de Producción'],

            // Administración
            ['name' => 'Administrador'],
            ['name' => 'Contable'],
            ['name' => 'Auxiliar Administrativo'],
            ['name' => 'Responsable de Recursos Humanos'],

            // Comercial
            ['name' => 'Comercial Senior'],
            ['name' => 'Comercial'],
            ['name' => 'Técnico Comercial'],
            ['name' => 'Auxiliar Comercial'],

            // Ingeniería
            ['name' => 'Ingeniero Jefe'],
            ['name' => 'Ingeniero de Proyectos'],
            ['name' => 'Delineante'],
            ['name' => 'Técnico de Diseño'],

            // Producción
            ['name' => 'Jefe de Taller'],
            ['name' => 'Maestro Calderero'],
            ['name' => 'Calderero'],
            ['name' => 'Operario de Corte Láser'],
            ['name' => 'Mecanizador'],
            ['name' => 'Montador Industrial'],
            ['name' => 'Soldador'],

            // Calidad
            ['name' => 'Responsable de Calidad'],
            ['name' => 'Técnico de Calidad'],
            ['name' => 'Inspector de Calidad'],

            // Mantenimiento
            ['name' => 'Jefe de Mantenimiento'],
            ['name' => 'Técnico de Mantenimiento'],
            ['name' => 'Mecánico'],

            // Logística
            ['name' => 'Responsable de Almacén'],
            ['name' => 'Almacenero'],
            ['name' => 'Conductor'],

            // Otros
            ['name' => 'Auxiliar de Producción'],
            ['name' => 'Becario'],
        ];

        foreach ($positions as $position) {
            UserPosition::create($position);
        }
    }
}
