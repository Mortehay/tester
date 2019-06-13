<?php

use Illuminate\Database\Seeder;
use App\Domain;
use Faker\Factory as Faker;
use App\AddMail;

class AddMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $domains = Domain::all();
        foreach($domains as $_domain){
            $alert_mail_counter = rand(1,5);
            for ($amc = 1; $amc <= $alert_mail_counter; $amc++){
                $_addMail = new AddMail();
                $_addMail->domain()->associate($_domain);
                $_addMail->alert_mail = $faker->email;
                $_addMail->save();
            }
        }
    }
}
