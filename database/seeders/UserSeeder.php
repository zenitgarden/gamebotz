<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'=> 'Admin',
                'username'=>'Admin',
                'avatar'=>'none.jpg',
                'slug' => 'admin',
                'description' => 'I am the creator',
                'password'=> Hash::make('admin'),
                'email'=> 'admin@test.com',
                'email_verified_at'=> now(),
                'remember_token'=> Str::random(10),
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s"),
            ]
        ]);
    }
}
