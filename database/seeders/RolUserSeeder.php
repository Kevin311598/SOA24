<?php

namespace Database\Seeders;

use App\Models\RolUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RolUser::insert([
            ["denominacion" => 'administrador'],
            ["denominacion" => 'cliente']
        ]);
    }
}
