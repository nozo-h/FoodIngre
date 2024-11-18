<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'guest',
                'email' => 'guest@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'guest_nickname_01',
                'is_available' => 1,
                'authority' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted_at' => null,
            ],
            [
                'name' => 'Shota Morishita',
                'email' => 'test_u1@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'shoNo1',
                'is_available' => 1,
                'authority' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted_at' => null,
            ],
            [
                'name' => 'Teruaki Sato',
                'email' => 'test_u2@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'Sato8',
                'is_available' => 1,
                'authority' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted_at' => null,
            ],
            [
                'name' => 'Sheldon Neuse',
                'email' => 'test_u3@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'Sheldon',
                'is_available' => 1,
                'authority' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted_at' => null,
            ],
            [
                'name' => 'user04',
                'email' => 'test_u4@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'user_nickname_04',
                'is_available' => 0,
                'authority' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted_at' => null,
            ],
            [
                'name' => 'user05',
                'email' => 'test_u5@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'user_nickname_05',
                'is_available' => 0,
                'authority' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'user06',
                'email' => 'test_u6@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'user_nickname_06',
                'is_available' => 0,
                'authority' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}