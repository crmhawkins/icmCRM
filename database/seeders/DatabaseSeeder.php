<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders organizados por orden de dependencias
        $this->call([
            // 1. Estados y configuraciones básicas
            EstadosAlertasSeeder::class,
            TiposConceptosPresupuestoSeeder::class,
            EstadosPresupuestoSeeder::class,
            EstadosVacacionesSeeder::class,
            EstadosIncidenciasSeeder::class,
            EstadosFacturaSeeder::class,
            MetodosPagoSeeder::class,
            EtapasSeeder::class,
            EstadosTareasSeeder::class,

            // 2. Configuraciones de usuarios
            NivelesAccesoUsuarioSeeder::class,
            DepartamentosUsuarioSeeder::class,
            PosicionesUsuarioSeeder::class,

            // 3. Datos de producción y trabajo
            // TrabajosProduccionSeeder::class, // Comentado temporalmente

            // 4. Sistema de maquinaria y cola de trabajo
            TiposTrabajoSeeder::class,
            MaquinariaSeeder::class,

            // 5. Usuarios administradores (debe ir al final)
            AdminUserSeeder::class,
        ]);
    }
}
