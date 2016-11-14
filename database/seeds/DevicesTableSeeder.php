<?php

use App\Device;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Faker = Faker::create();
        $Users = User::with('devices')->get();
        foreach ($Users as $User) {
            foreach (range(0,random_int(0,3)) as $item) {
                $token = "";
                foreach (range(1,6) as $char) {
                    $token .= $Faker->randomLetter;
                }
                $User->devices()->create([
                    'user_id' => $User->id,
                    'used' => (bool)random_int(0,1),
                    'token' => $token
                ]);
            }
        }
    }
}
