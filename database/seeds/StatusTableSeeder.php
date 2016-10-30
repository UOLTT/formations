<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Fills out the available statuses
     *
     * @return void
     */
    public function run()
    {
        $Statuses = [
            'Organization' => [
                'Open' => 'This organization is open to new users',
                'Accepting Applicants' => 'This organization is accepting applications to join',
                'Closed' => 'The organization is not accepting any new applicants'
            ],
            'Fleet' => [
                'Forming' => 'This fleet is in preparation',
                'Flying' => 'The fleet is currently engaged',
                'Offline' => 'The fleet is offline for now'
            ],
            'Squadron' => [
                'Open' => 'Open for player to join',
                'Closed' => 'Fleet is closed to new members'
            ]
        ];

        foreach ($Statuses as $Type => $Status) {
            foreach ($Status as $Name => $Description) {
                Status::create([
                    'name' => $Name,
                    'description' => $Description,
                    'type' => $Type
                ]);

            }
        }
    }
}
