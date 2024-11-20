<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::insert([
            [
                "name" => "matrimonio", "imagen_url" => 'sad',
                "titulo" => "¿Estas proximo a casarte?",
                "sub_titulo" => "Rellena los datos solicitados para solicitar el envío de nuestro catálogo de tortas de Delivery Tortitas, ideal para parejas de novios."
            ],
            [
                "name" => "cumpleaños", "imagen_url" => 'sad',
                "titulo" => "¿Estas proximo a cumplir años?",
                "sub_titulo" => "Completa la información requerida para solicitar el envío de nuestro catálogo de tortas de Delivery Tortitas, perfecto para celebraciones de cumpleaños."
            ],
            [
                "name" => "baby shower", "imagen_url" => 'sad',
                "titulo" => "¿Estas proximo a nacer?",
                "sub_titulo" => "Completa la información requerida para solicitar el envío de nuestro catálogo de tortas de Delivery Tortitas, perfecto para celebraciones de baby showers."
            ],
        ]);
    }
}
