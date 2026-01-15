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
                'denominacion' => 'Palacio Municipal Antiguo',
                'ubicacion' => 'Av. Hidalgo #1, Centro',
                'comunidad' => 'Cabecera Municipal',
                'clave_catastral' => '001-002-003',
                'coordenadas' => '19.4326, -99.1332',
                'superficie_total' => '1200 m2',
                'uso_destino' => 'Oficinas Administrativas',
                'habitado' => true,
                'propio' => true,
                'comodato' => false,
                'adscrito_a' => 'Secretaría General',
                'resguardo_servidor' => 'Juan Pérez',
                'fecha_contrato' => '2020-01-15',
                'luz' => true,
                'agua' => true,
                'oficinas_admin' => '5',
                'actividades' => 'Sede principal del gobierno municipal.',
            ],
            [
                'denominacion' => 'Biblioteca Pública Zona Norte',
                'ubicacion' => 'Calle Reforma S/N',
                'comunidad' => 'San Pedro',
                'clave_catastral' => '055-100-200',
                'coordenadas' => '19.5000, -99.2000',
                'superficie_total' => '450 m2',
                'uso_destino' => 'Cultural',
                'habitado' => true,
                'propio' => true,
                'comodato' => false,
                'adscrito_a' => 'Dirección de Cultura',
                'resguardo_servidor' => 'María González',
                'fecha_contrato' => '2022-05-20',
                'luz' => true,
                'agua' => true,
                'modulos_sanitarios' => '2',
                'actividades' => 'Préstamo de libros y talleres infantiles.',
            ],
            [
                'denominacion' => 'Terreno Baldío Los Sauces',
                'ubicacion' => 'Carretera Federal Km 10',
                'comunidad' => 'Los Sauces',
                'clave_catastral' => '888-999-000',
                'coordenadas' => '19.6000, -99.3000',
                'superficie_total' => '5000 m2',
                'uso_destino' => 'Sin uso actual',
                'habitado' => false,
                'propio' => true,
                'comodato' => false,
                'adscrito_a' => 'Patrimonio Municipal',
                'resguardo_servidor' => 'Lic. Roberto Sánchez',
                'fecha_contrato' => null,
                'luz' => false,
                'agua' => false,
                'malla' => true,
                'actividades' => 'Terreno en reserva para futuro proyecto deportivo.',
            ]
        ];
             foreach ($inmuebles as $inmueble) {
            Property::create($inmueble);
        }
    }
}
