<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::create([
        'ten'=>'Huy',
        'sdt'=>'963852741',
        'password'=>Hash::make('password'),
        'remember_token'=>Str::random(10),
        'is_active'=>'0',
        'level'=>'1',
      ]);
    }
}
