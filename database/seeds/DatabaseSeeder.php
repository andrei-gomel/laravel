<?php

//namespace Database\Seeds;

use Illuminate\Database\Seeder;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$this->call(UsersTableSeeder::class);
		$this->call(BlogCategoriesTableSeeder::class);
		factory(\App\Models\BlogPost::class, 100)->create();
	}
}
