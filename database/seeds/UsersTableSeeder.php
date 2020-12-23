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
       DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'Admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'type' => 'Admin',
            'state' => 1,
        ]);
    }
}
