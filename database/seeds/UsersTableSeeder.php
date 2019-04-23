<?php

use Illuminate\Database\Seeder;
use App\User;
Use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'tester admin',
                'email' => 'tester-admin@email.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
            ],
            [
                'name' => 'tester editor',
                'email' => 'tester-editor@email.com',
                'password' => bcrypt('123456'),
                'role' => 'editor',
            ],
            [
                'name' => 'tester user',
                'email' => 'tester-user@email.com',
                'password' => bcrypt('123456'),
                'role' => 'user',
            ]
        ];

        foreach ($users as $user){
            $_user = new User();
            $_user->name = $user['name'];
            $_user->email = $user['email'];
            $_user->password = $user['password'];

            $_user->save();
            $_role = new Role();
            $_role->user()->associate($_user);
            $_role->role = $user['role'];
            $_role->save();
        }
    }
}
