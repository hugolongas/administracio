<?php

use Illuminate\Database\Seeder;
use App\Section;
use App\User;
use App\Role;

class SectionTableSeeder extends Seeder
{
    public function run()
    {
        $section = new Section();
        $section->section_name = 'Junta';
        $section->description = 'Administrador y Junta';
        $section->save();
        $role = Role::find(1);
        $section->roles()->attach($role);        
        $user = User::where('username','administracio')->get();
        $section->users()->attach($user);

        $section = new Section();
        $section->section_name = 'Soci';
        $section->description = 'Soci Comú';
        $section->save();
        $role = Role::find(2);
        $section->roles()->attach($role);        
        $user = User::where('username','47811275W')->get();
        $section->users()->attach($user);
    }
}
