<?php

use App\Organization;
use App\Status;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Faker = Faker::create();
        $Statuses = Status::where('type','Organization')->get();
        $Users = User::count();
        foreach ($Statuses as $status) {
            foreach (range(1,random_int(3,5)) as $id) {
                Organization::create([
                    'name' => implode(' ',$Faker->words(random_int(1,3))),
                    'domain' => strtolower($Faker->word),
                    'admin_user_id' => random_int(1,$Users),
                    'status_id' => $status->id
                ]);
            }
        }
    }
}