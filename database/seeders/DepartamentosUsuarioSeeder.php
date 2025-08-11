<?php

namespace Database\Seeders;

use App\Models\Users\UserDepartament;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentosUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departaments = [
            ['name' => 'Dirección General'],
            ['name' => 'Administración y Contabilidad'],
            ['name' => 'Comercial y Ventas'],
            ['name' => 'Ingeniería y Diseño'],
            ['name' => 'Calderería'],
            ['name' => 'Corte Láser'],
            ['name' => 'Mecanizados'],
            ['name' => 'Montaje Industrial'],
            ['name' => 'Calidad y Control'],
            ['name' => 'Mantenimiento'],
            ['name' => 'Logística y Almacén'],
            ['name' => 'Recursos Humanos'],
        ];

        foreach ($departaments as $departament) {
            UserDepartament::create($departament);
        }
    }
}
