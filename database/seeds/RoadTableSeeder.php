<?php

use Illuminate\Database\Seeder;
use App\Road;
class RoadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $road = new Road();
        $road->road = 'Avinguda';
        $road->save();
        $road = new Road();
        $road->road = 'Cami';
        $road->save();
        $road = new Road();
        $road->road = 'Carrer';
        $road->save();
        $road = new Road();
        $road->road = 'Plaça';
        $road->save();
    }
}
