<?php

use Illuminate\Database\Seeder;
use App\Domain;
use App\AddDomain;
use Faker\Factory as Faker;
use App\ImageUploads;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $type = [
            'h_',
            '_d',
            'hd',
        ];
        $faker = Faker::create();
        $fakeDomains = [];
        for ($i = 1; $i <= 10; $i++) {
            array_push($fakeDomains,[
                'name' => $faker->company,
                'link' => $faker->url,
                'hosting_name' => $faker->streetName,
                'hosting_link' => $faker->url,
                'type' => $type[rand(0,2)],
                'login' => $faker->firstNameMale,
                'password' => $faker->password,
                'description' => $faker->text(200),
            ]);
        }

        foreach ($fakeDomains as $fakeDomain){
            $_domain = new Domain();
            $_domain->name = $fakeDomain['name'];
            $_domain->link = $fakeDomain['link'];
            $_domain->hosting_name = $fakeDomain['hosting_name'];
            $_domain->hosting_link = $fakeDomain['hosting_link'];
            $_domain->type = $fakeDomain['type'];
            $_domain->login = $fakeDomain['login'];
            $_domain->password = $fakeDomain['password'];
            $_domain->description = $fakeDomain['description'];

            $_domain->save();

            $domain_counter = rand(1,5);

            for ($dc = 1; $dc <= $domain_counter; $dc++){
                $_addDomain = new AddDomain();
                $_addDomain->domain()->associate($_domain);
                $_addDomain->name = $faker->domainName;
                $_addDomain->save();
            }

            $domain_screen = new ImageUploads();
            $domain_screen->domain()->associate($_domain);
            $domain_screen->image_path  = 'screen\test.jpg';
            $domain_screen->save();

        }
    }
}
