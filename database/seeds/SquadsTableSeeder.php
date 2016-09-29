<?php

use App\Fleet;
use \App\Organization;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SquadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Faker = Faker::create();
        foreach (Fleet::all() as $Fleet) {
            foreach (range(1,rand(1,3)) as $id) {
                $Fleet->squads()->create([
                    'fleet_id' => $Fleet->id,
                    'name' => implode(' ',$Faker->words(rand(1,2))),
                    'status_id' => rand(7,8)
                ]);
            }
        }
        foreach (Organization::with('squads','users')->get() as $Organization) {
            $Squads = [];
            foreach ($Organization->squads as $Squad) {
                $Squads[] = $Squad->id;
                unset($Squad);
            }
            $this->command->info($Organization->id.' has '.implode(', ',$Squads).' squads');
            foreach ($Organization->users as $User) {
                $User->squad_id = $Squads[rand(0,sizeof($Squads) - 1)];
                $User->save();
            }
        }
    }
}
