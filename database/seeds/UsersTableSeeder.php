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
        //
         DB::table('users')->insert([
            'fullname' => 'Admin Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'login' => 'admin',
            'birthday' => '1983-05-25',
            'address' => 'Тинка 19',
            'city' => 'Кривой Рог',
            'state' => 'Днепропетровская',
            'country' => 'Украина',
            'zip' => '50063'
        ]);
    }
}
