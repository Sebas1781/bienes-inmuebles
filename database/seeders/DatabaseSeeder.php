<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear Super Administrador
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_administrador',
        ]);

        // Crear Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'administrador',
        ]);

        // Crear Usuario Normal
        User::create([
            'name' => 'Usuario Demo',
            'email' => 'usuario@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
        ]);

        // Crear inmuebles de ejemplo
        $inmuebles = [
            [
                'nombre' => 'Casa Colonial Centro',
                'tipo' => 'Casa',
                'direccion' => 'Calle Principal #123, Centro Histórico',
                'area' => 250.00,
                'numero_habitaciones' => 4,
                'numero_banos' => 3,
                'precio' => 350000.00,
                'estado_ocupacion' => 'Disponible',
                'estado_mantenimiento' => 'Excelente',
                'descripcion' => 'Hermosa casa colonial en el centro histórico de la ciudad',
                'propietario' => 'Juan Pérez',
                'telefono_contacto' => '555-1234',
                'email_contacto' => 'juan@example.com',
            ],
            [
                'nombre' => 'Apartamento Moderno',
                'tipo' => 'Apartamento',
                'direccion' => 'Av. Libertad #456, Piso 5',
                'area' => 85.00,
                'numero_habitaciones' => 2,
                'numero_banos' => 2,
                'precio' => 120000.00,
                'estado_ocupacion' => 'Ocupado',
                'estado_mantenimiento' => 'Bueno',
                'descripcion' => 'Apartamento moderno con excelente ubicación',
                'propietario' => 'María García',
                'telefono_contacto' => '555-5678',
                'email_contacto' => 'maria@example.com',
            ],
            [
                'nombre' => 'Local Comercial Plaza',
                'tipo' => 'Local Comercial',
                'direccion' => 'Plaza Central, Local 12',
                'area' => 120.00,
                'numero_habitaciones' => null,
                'numero_banos' => 2,
                'precio' => 200000.00,
                'estado_ocupacion' => 'Reservado',
                'estado_mantenimiento' => 'Bueno',
                'descripcion' => 'Local comercial en plaza con alto tráfico',
                'propietario' => 'Carlos López',
                'telefono_contacto' => '555-9012',
                'email_contacto' => 'carlos@example.com',
            ],
            [
                'nombre' => 'Oficina Ejecutiva',
                'tipo' => 'Oficina',
                'direccion' => 'Torre Corporativa, Piso 10',
                'area' => 60.00,
                'numero_habitaciones' => null,
                'numero_banos' => 1,
                'precio' => 80000.00,
                'estado_ocupacion' => 'Disponible',
                'estado_mantenimiento' => 'Excelente',
                'descripcion' => 'Oficina ejecutiva con vista panorámica',
                'propietario' => 'Ana Martínez',
                'telefono_contacto' => '555-3456',
                'email_contacto' => 'ana@example.com',
            ],
            [
                'nombre' => 'Terreno Urbano',
                'tipo' => 'Terreno',
                'direccion' => 'Zona Residencial Norte',
                'area' => 500.00,
                'numero_habitaciones' => null,
                'numero_banos' => null,
                'precio' => 150000.00,
                'estado_ocupacion' => 'Disponible',
                'estado_mantenimiento' => 'Bueno',
                'descripcion' => 'Terreno plano ideal para construcción',
                'propietario' => 'Luis Rodríguez',
                'telefono_contacto' => '555-7890',
                'email_contacto' => 'luis@example.com',
            ],
            [
                'nombre' => 'Bodega Industrial',
                'tipo' => 'Bodega',
                'direccion' => 'Zona Industrial, Sector B',
                'area' => 400.00,
                'numero_habitaciones' => null,
                'numero_banos' => 2,
                'precio' => 180000.00,
                'estado_ocupacion' => 'Ocupado',
                'estado_mantenimiento' => 'Regular',
                'descripcion' => 'Bodega amplia con acceso para camiones',
                'propietario' => 'Empresa XYZ',
                'telefono_contacto' => '555-2468',
                'email_contacto' => 'contacto@xyz.com',
            ],
        ];

        foreach ($inmuebles as $inmueble) {
            Property::create($inmueble);
        }
    }
}
