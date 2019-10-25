<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrador';
        $role->save();

        $role = new Role();
        $role->name = 'soci';
        $role->description = 'Soci Comú';
        $role->save();

        $role = new Role();
        $role->name = 'colaborador';
        $role->description = 'Soci que organitza activitats';
        $role->save();

        $role = new Role();
        $role->name = 'promotor';
        $role->description = 'Empresa que promociona l\'ateneu';
        $role->save();
    }
}
