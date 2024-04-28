<?php

namespace Database\Seeders;

use App\Models\ContratType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeContratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Define data to be seeded
         $contratTypes = [
            ['nom' => 'Contrats Mobile'],
            ['nom' => 'Contrats Fixe et Internet'],
        ];

        foreach ($contratTypes as $contratType) {
            ContratType::create($contratType);
        }
    }
}
