<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resource;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Resource::create([
            'name' => 'Servidor Principal',
            'description' => 'Servidor DELL R740 para aplicaciones críticas',
        ]);

        Resource::create([
            'name' => 'Router Core',
            'description' => 'Router Cisco 2901 para la red principal',
        ]);

        Resource::create([
            'name' => 'Laptop de Desarrollo',
            'description' => 'MacBook Pro 16" para el equipo de desarrollo',
        ]);
    }
}
