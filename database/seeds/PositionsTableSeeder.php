<?php

use \App\Position;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
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
            Position::create([
                'name' => $Name,
                'description' => $Description
            ]);
        }
    }
}
