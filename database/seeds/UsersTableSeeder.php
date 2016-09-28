<?php

use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Faker = Faker::create();
        foreach (range(1,100) as $id) {
            User::create([
                'name' => $Faker->name,
                'email' => $Faker->safeEmail,
                'password' => \Hash::make($Faker->password()),
            ]);
        }
    }
}