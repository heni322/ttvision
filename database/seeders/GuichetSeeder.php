<?php

namespace Database\Seeders;

use App\Models\Guichet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuichetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define sample data for Guichet
        $guichetData = [
            ['nom' => 'Guichet 1'],
            ['nom' => 'Guichet 2'],
            ['nom' => 'Guichet 3'],
            ['nom' => 'Guichet 4'],
            // Add more sample data as needed
        ];

        // Insert sample data into the database
        foreach ($guichetData as $data) {
            Guichet::create($data);
        }
    }
}
