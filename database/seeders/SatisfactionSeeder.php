<?php

namespace Database\Seeders;

use App\Models\Satisfaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatisfactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Satisfaction::create(['nombre'=> 0]);
    }
}
