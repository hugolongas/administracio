<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Administració';
        $user->username='administracio';
        $user->email = 'bustia@lalianca.cat';
        $user->password = bcrypt('sauna92alianca');
        $user->save();
    }
}
