<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->command->info('Role table seeded');        
        $this->call(RoadTableSeeder::class);
        $this->command->info('Road table seeded');
           
        $this->call(UserTableSeeder::class);
        $this->command->info('User table seeded');
        $this->call(SociTableSeeder::class);
        $this->command->info('Soci table seeded');
        $this->call(SectionTableSeeder::class);
        $this->command->info('Section table seeded');
    }
}