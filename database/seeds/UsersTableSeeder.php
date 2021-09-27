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
        $data = [
		[ 
			'name' => 'Денис Петров',
			'email' => 'denispetrov@email.ru',
			'password' => bcrypt(Str::random(16)),
		],
		
		[
			'name' => 'Петр Иванов',
			'email' => 'petrivanov@email.ru',
			'password' => bcrypt('123123'),
		]
	];
	DB::table('users')->insert($data);
    }
}
