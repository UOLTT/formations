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
        $Users = User::all();

        $this->command->info("Seeding Organizations Table");
        $progress = $this->command->getOutput()->createProgressBar($Statuses->count());

        foreach ($Statuses as $status) {
            foreach (range(1,random_int(3,5)) as $id) {
                Organization::create([
                    'name' => implode(' ',$Faker->words(random_int(1,3))),
                    'domain' => strtolower($Faker->word),
                    'admin_user_id' => random_int(1,$Users->count()),
                    'status_id' => $status->id,
                    'manifesto' => implode('\r\n',$Faker->paragraphs(rand(1,3)))
                ]);
            }
            $progress->advance();
        }
        $progress->finish();

        $this->command->getOutput()->writeln('');
        $this->command->info("Assigning Users to Organizations");
        $progress = $this->command->getOutput()->createProgressBar($Users->count());

        $OrgCount = Organization::count();
        foreach ($Users as $user) {
            $progress->advance();
            if (random_int(0,3) === 0) {
                continue;
            }
            $user->organization_id = random_int(1,$OrgCount);
            $user->save();
        }
        $progress->finish();
        $this->command->getOutput()->writeln('');
    }
}