<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'toni',
            'email' => 'test@mail.com',
            'password' => bcrypt('secret'),
            'isAdmin'=> true,
        ]);
    }
}
