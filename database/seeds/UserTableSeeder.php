<?php

use App\Auth\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'username' => 'admin',
	        'first_name' => 'Admin',
	        'last_name' => 'Person',
	        'email' => 'test@gmail.com',
	        'password' => bcrypt('password')
        ]);
    }
}
