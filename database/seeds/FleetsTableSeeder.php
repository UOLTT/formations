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
        foreach (Organization::all() as $Organization) {
            foreach (range(1,random_int(0,4)) as $id) {
                Fleet::create([
                    'name' => implode(' ',$Faker->words(rand(1,3))),
                    'organization_id' => $Organization->id,
                    'status_id' => random_int(4,6)
                ]);
            }
        }
    }
}
