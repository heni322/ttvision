<?php

namespace Database\Seeders;

use App\Models\Contrat;
use App\Models\ContratType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstContrat = ContratType::first()?->id ;
        $lastContrat = ContratType::latest()->first()?->id;
         // Define data to be seeded
         $contrats = [
            ['nom' => 'Contrats GSM prépayé', 'type_contrat_id' => $firstContrat],
            ['nom' => 'Contrats GSM postpayé', 'type_contrat_id' => $firstContrat],
            ['nom' => 'Contrats Mobile à facture', 'type_contrat_id' => $firstContrat],
            ['nom' => 'Contrats Portabilité', 'type_contrat_id' => $firstContrat],
            ['nom' => 'Contrats ADSL', 'type_contrat_id' => 2],
            ['nom' => 'Contrats VDSL', 'type_contrat_id' => 2],
            ['nom' => 'Contrats GPON', 'type_contrat_id' => 2],
        ];

        // Seed the data into the database
        foreach ($contrats as $contrat) {
            Contrat::create($contrat);
        }
    }
}
