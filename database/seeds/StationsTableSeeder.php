<?php

use \App\Station;
use Illuminate\Database\Seeder;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Positions = json_decode(file_get_contents(storage_path('/positions.json')));

        foreach ($Positions as $Name => $Description) {
            Station::create([
                'name' => $Name,
                'description' => $Description
            ]);
        }
    }
}
