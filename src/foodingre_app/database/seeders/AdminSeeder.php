<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'admin01',
                'is_available' => 1,
                'authority' => 1,
                'created_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 11, 1, 2023)),
                'updated_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 11, 1, 2023)),
                'deleted_at' => null,
            ],
            [
                'name' => 'Liner Brawn',
                'email' => 'admin_02@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'admin02',
                'is_available' => 1,
                'authority' => 0,
                'created_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 11, 1, 2023)),
                'updated_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 11, 1, 2023)),
                'deleted_at' => null,
            ],
            [
                'name' => 'Levi Ackerman',
                'email' => 'admin_03@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'admin03',
                'is_available' => 0,
                'authority' => 0,
                'created_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 11, 1, 2023)),
                'updated_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 11, 1, 2023)),
                'deleted_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 12, 1, 2023)),
            ],
            [
                'name' => 'Tanjiro Kamado',
                'email' => 'admin_04@test.com',
                'password' => Hash::make('password'),
                'nickname' => 'admin04',
                'is_available' => 0,
                'authority' => 0,
                'created_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 11, 1, 2023)),
                'updated_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 11, 1, 2023)),
                'deleted_at' => date("Y-m-d H:i:s", mktime(0, 0, 0, 12, 1, 2023)),
            ],
        ]);
    }
}
