<?php

namespace Database\Seeders;

use App\Models\Users\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador principal
        User::create([
            'access_level_id' => 1, // Super Administrador
            'admin_user_department_id' => 1, // Dirección General
            'admin_user_position_id' => 1, // Director General
            'commercial_id' => null,
            'name' => 'Administrador',
            'surname' => 'ICM Talleres',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'Super Administrador',
            'image' => null,
            'email' => 'admin.icm@icmtalleres.com',
            'email_verified_at' => now(),
            'device_token' => null,
            'seniority_years' => 5,
            'seniority_months' => 0,
            'holidays_days' => 22.0,
            'inactive' => 0, // Activo
            'is_dark' => 0, // Modo claro por defecto
        ]);

        // Crear usuario técnico para pruebas
        User::create([
            'access_level_id' => 2, // Administrador del Sistema
            'admin_user_department_id' => 4, // Ingeniería y Diseño
            'admin_user_position_id' => 13, // Ingeniero Jefe
            'commercial_id' => null,
            'name' => 'Técnico',
            'surname' => 'Sistema',
            'username' => 'tecnico',
            'password' => Hash::make('tecnico123'),
            'role' => 'Administrador del Sistema',
            'image' => null,
            'email' => 'tecnico.icm@icmtalleres.com',
            'email_verified_at' => now(),
            'device_token' => null,
            'seniority_years' => 3,
            'seniority_months' => 6,
            'holidays_days' => 22.0,
            'inactive' => 0, // Activo
            'is_dark' => 0, // Modo claro por defecto
        ]);

        // Crear usuario comercial para pruebas
        User::create([
            'access_level_id' => 12, // Comercial Senior (ajustado al número correcto)
            'admin_user_department_id' => 3, // Comercial y Ventas
            'admin_user_position_id' => 9, // Comercial Senior
            'commercial_id' => 1,
            'name' => 'Comercial',
            'surname' => 'Ventas',
            'username' => 'comercial',
            'password' => Hash::make('comercial123'),
            'role' => 'Comercial Senior',
            'image' => null,
            'email' => 'comercial.icm@icmtalleres.com',
            'email_verified_at' => now(),
            'device_token' => null,
            'seniority_years' => 2,
            'seniority_months' => 0,
            'holidays_days' => 22.0,
            'inactive' => 0, // Activo
            'is_dark' => 0, // Modo claro por defecto
        ]);

        $this->command->info('Usuarios administradores creados exitosamente:');
        $this->command->info('- admin/admin123 (Super Administrador)');
        $this->command->info('- tecnico/tecnico123 (Administrador del Sistema)');
        $this->command->info('- comercial/comercial123 (Comercial Senior)');
    }
} 