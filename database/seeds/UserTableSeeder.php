<?php

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
        $aData = [
    [
        'name' => 'admin',
        'email' => 'admin@dynamicform.com',
        'password' => Hash::make('12345678'),

    ],
];

DB::statement('SET FOREIGN_KEY_CHECKS=0;');

DB::table('users')->truncate();

DB::table('users')->insert($aData);

    }
}
