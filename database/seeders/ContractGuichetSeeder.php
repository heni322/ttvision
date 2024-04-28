<?php

namespace Database\Seeders;

use App\Models\ContractGuichet;
use App\Models\Contrat;
use App\Models\Guichet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractGuichetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get random contrat and guichet IDs
        $contratIds = Contrat::pluck('id')->toArray();
        $guichetIds = Guichet::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            ContractGuichet::create([
                'contrat_id' => $contratIds[array_rand($contratIds)],
                'guichet_id' => $guichetIds[array_rand($guichetIds)],
                'nombre' => rand(1, 100),
                'recette' => rand(1000, 10000),
            ]);
        }
    }
}
