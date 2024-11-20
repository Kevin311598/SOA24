<?php

namespace Database\Seeders;

use App\Models\Torta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TortaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Torta::insert([
           ["nombre"=>"torata", "precio"=>12, "imagen_url"=>"sada"]
        ]);
    }
}
