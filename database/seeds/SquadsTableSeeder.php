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
        $Fleets = Fleet::with(['organization'=>function($query) {
            $query->with('users');
        }])->get();

        $this->command->getOutput()->writeln("Seeding Squads Table");
        $this->command->getOutput()->progressStart($Fleets->count());

        foreach ($Fleets as $Fleet) {
            foreach ($Fleet->organization->users as $user) {
                if (random_int(0,3) === 0) {
                    $Fleet->squads()->create([
                        'fleet_id' => $Fleet->id,
                        'name' => implode(' ',$Faker->words(rand(1,2))),
                        'squad_leader_id' => $user->id,
                        'status_id' => rand(7,8)
                    ]);
                }
            }
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();

        foreach (Organization::with('squads','users')->get() as $Organization) {
            if (count($Organization->squads) == 0) {
                continue;
            }
            $Squads = [];
            foreach ($Organization->squads as $Squad) {
                $Squads[] = $Squad->id;
                unset($Squad);
            }
            foreach ($Organization->users as $User) {
                $User->squad_id = $Squads[rand(0,sizeof($Squads) - 1)];
                $User->save();
            }
        }
    }
}
