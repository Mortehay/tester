<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Domain;
use App\AddMail;
use Faker\Factory as Faker;

class AddDataToAddMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('add_mails')->truncate();
    }
}
