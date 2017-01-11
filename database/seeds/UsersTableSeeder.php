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
        $this->command->info("Seeding Users Table");
        $this->command->getOutput()->progressStart(300);
        foreach (range(1,300) as $id) {
            User::create([
                'name' => $Faker->name,
                'username' => $Faker->userName,
                'game_handle' => $Faker->userName,
                'email' => $Faker->safeEmail,
                'password' => '$2y$10$PnlSPK8L2vqb4WT5wUb3leuardRTiCt3U6ZpJLDYGDJROp1Z8dZWG',
            ]);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
    }
}