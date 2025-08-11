<?php

namespace Database\Seeders;

use App\Models\Budgets\BudgetConceptType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposConceptosPresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Proveedor'],
            ['name' => 'Propio'],
        ];

        foreach ($statuses as $status) {
            BudgetConceptType::create($status);
        }
    }
}
