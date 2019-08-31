<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();


        DB::table('users')->insert([
            [
                'name'=>"John",
                 'email'=>"john@test.com",
                'password'=>bcrypt('secret')
            ],

            [
                'name'=>"admin",
                'email'=>"admin@test.com",
                'password'=>bcrypt('secret')
            ],

            [
                'name'=>"Noor",
                'email'=>"noor@test.com",
                'password'=>bcrypt('secret')
            ]

        ]);

    }
}
