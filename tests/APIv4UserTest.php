<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

class APIv4UserTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCreation()
    {

        $Faker = Faker::create();

        $this->post('/api/v4/users', [
            'name' => $Faker->name,
            'username' => $Faker->userName,
            'game_handle' => $Faker->userName,
            'email' => $Faker->email,
            'password' => \Hash::make($Faker->password())
        ])
            ->seeJson()
            ->seeStatusCode(200);

    }
}
