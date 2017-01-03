<?php

use App\Formation;
use Illuminate\Database\Seeder;

class FormationsTableSeeder extends Seeder
{
    private $formations = [
        [
            'name' => 'one',
            'description' => 'Formation 1',
            'minimum_users' => 1,
            'filename' => '1.jpg'
        ],            [
            'name' => 'two',
            'description' => 'Formation 2',
            'minimum_users' => 2,
            'filename' => '2.jpg'
        ],            [
            'name' => 'three',
            'description' => 'Formation 3',
            'minimum_users' => 3,
            'filename' => '3.jpg'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->getOutput()->writeln('Seeding Formations Table');
        $this->command->getOutput()->progressStart(sizeof($this->formations));

        foreach ($this->formations as $formation) {
            Formation::create($formation);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
