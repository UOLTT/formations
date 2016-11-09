<?php

use App\Fleet;
use \App\Organization;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class FleetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Faker = Faker::create();
        foreach (Organization::with('users')->get() as $Organization) {
            foreach ($Organization->users as $user) {
                if (random_int(0,4) === 0) {
                    Fleet::create([
                        'admiral_id' => $user->id,
                        'name' => implode(' ',$Faker->words(rand(1,3))),
                        'organization_id' => $Organization->id,
                        'status_id' => random_int(4,6),
                        'manifesto' => implode('\r\n',$Faker->paragraphs(rand(1,3)))
                    ]);
                }
            }
        }
    }
}
