<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Usuarios\Roles;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $sm = new Role();

        // Array de roles
        $roles = [
            [
                'nombre' => 'Super Administrador',
            ],
            [
                'nombre' => 'Administrador',
            ],
            [
                'nombre' => 'Usuario',
            ],
        ];

        // Using Query Builder
        $sm->insertBatch($roles);
        
    }
}
