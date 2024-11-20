<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                "full_name" => "Yopi",
                "email" => "yopi@gmail.com",
                "password" => Hash::make("123456789"),
                "rol_user_id" => 1,
            ],
            [
                "full_name" => "Yopi2",
                "email" => "yopiscode@gmail.com",
                "password" => Hash::make("123456789"),
                "rol_user_id" => 2,
            ]
        ]);
    }
}
