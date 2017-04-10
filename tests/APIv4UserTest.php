<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

class APIv4UserTest extends TestCase
{

    use DatabaseTransactions;

    private $Faker;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->Faker = Faker::create();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * Create new user.
     *
     * @return void
     */
    public function testCreateUser()
    {

        $Faker = $this->Faker;

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

    /**
     * Show a user
     *
     * @return void
     */
    public function testShowUser() {

        $this->get('/api/v4/users/'.User::inRandomOrder()->first()->id)
            ->seeJson()
            ->seeStatusCode(200);

    }

    /**
     * Update a user
     */
    public function testUserUpdate() {

    }

}
