<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['name' => 'Administrador', 'email' => 'admin@lab.test', 'rol' => 'administrador'],
            ['name' => 'Ana López', 'email' => 'ana@lab.test', 'rol' => 'estudiante'],
            ['name' => 'Luis Ramírez', 'email' => 'luis@lab.test', 'rol' => 'estudiante'],
            ['name' => 'María Torres', 'email' => 'maria@lab.test', 'rol' => 'estudiante'],
        ];

        foreach ($usuarios as $datos) {
            // forceFill: el campo "rol" no es asignable en masa desde formularios (a propósito).
            (new User())->forceFill($datos + [
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ])->save();
        }

        $equipos = [
            ['LAP-001', 'Laptop HP 01', 'Laptop', 'Core i5, 8 GB RAM, 256 GB SSD'],
            ['LAP-002', 'Laptop HP 02', 'Laptop', 'Core i5, 8 GB RAM, 256 GB SSD'],
            ['LAP-003', 'Laptop Lenovo 03', 'Laptop', 'Ryzen 5, 16 GB RAM, 512 GB SSD'],
            ['PC-001', 'Computadora Lab A-01', 'Computadora de escritorio', 'Core i7, 16 GB RAM, monitor 24"'],
            ['PC-002', 'Computadora Lab A-02', 'Computadora de escritorio', 'Core i7, 16 GB RAM, monitor 24"'],
            ['PC-003', 'Computadora Lab A-03', 'Computadora de escritorio', 'Core i5, 8 GB RAM, monitor 22"'],
            ['TAB-001', 'Tablet Samsung 01', 'Tablet', '10", 64 GB'],
            ['TAB-002', 'Tablet Samsung 02', 'Tablet', '10", 64 GB'],
        ];

        foreach ($equipos as [$codigo, $nombre, $tipo, $descripcion]) {
            Equipo::create(compact('codigo', 'nombre', 'tipo', 'descripcion'));
        }
    }
}
