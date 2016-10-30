<?php

use App\Ship;
use App\User;
use Illuminate\Database\Seeder;

class ShipsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Ships = json_decode(file_get_contents(storage_path('ships.json')));
        foreach ($Ships as $ship) {
            $NewShip = new Ship();
            foreach ($ship as $item => $value) {
                if ($item == 'shipUID') {
                    continue;
                }
                $NewShip->$item = $value;
            }
            $NewShip->save();
        }

        $Ships_Positions = json_decode(file_get_contents(storage_path('ships_positions.json')));
        foreach ($Ships_Positions as $Ship_Position) {
            Ship::with('positions')
                ->findOrFail($Ship_Position->shipUID)
                ->positions()
                ->attach($Ship_Position->positions);
        }

        $Ships = Ship::all();
        $Users = User::all();

        foreach ($Users as $User) {

            // each user averages 1 ship
            foreach ($Ships as $Ship) {
                if (rand(0,$Ships->count()) == 0) {
                    $User->ships()->attach($Ship);
                }
            }

            // 1/4 users are active

        }
    }
}
