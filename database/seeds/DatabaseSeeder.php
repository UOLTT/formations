<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(DevicesTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(FleetsTableSeeder::class);
        $this->call(SquadsTableSeeder::class);
        $this->call(FormationsTableSeeder::class);
    }
}
