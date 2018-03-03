<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 Model::unguard();
    	 
    	$name = str_random(10);
         DB::table('users')->insert([
            'name' => $name,
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('password'),
            'slug' 		=> (new App\User())->slug($name),
            'login_enabled' => 1,
            'role_id' =>1
        ]);
    }
}
