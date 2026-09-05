<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $rolAdministrador = Rol::query()->firstOrCreate(
            ['nombre' => 'Administrador'],
            ['descripcion' => 'Rol administrativo inicial']
        );

        $usuarioAdministrador = Usuario::query()->firstOrCreate(
            ['correoElectronico' => env('ADMIN_CORREO', 'ebocm2@gmail.com')],
            [
                'nombre' => env('ADMIN_NOMBRE', 'Administrador'),
                'clave' => Hash::make(env('ADMIN_CLAVE', 'Temporal123!')),
                'cambiarClave' => true,
                'dobleFactorHabilitado' => false,
            ]
        );

        $usuarioAdministrador->roles()->syncWithoutDetaching([$rolAdministrador->id]);
    }
}
