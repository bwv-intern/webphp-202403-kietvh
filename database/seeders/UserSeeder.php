<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        // user_flag = 1: ADMIN, 2: DIRECTOR, 3: GROUP_LEADER, 4: LEADER, 5: MEMBER
        for ($i = 1; $i <= 5; $i++) {
            $data[] = [
                'email' => 'admin' . $i . '@test.com',
                'password' => Hash::make('123456'),
                'name' => 'Admin Test ' . $i,
                'user_flag' => $i,
                'del_flg' => 0,
                'created_at' => new \DateTime(),
                'created_by' => 0,
                'updated_at' => new \DateTime(),
                'updated_by' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
            ];
        }

        DB::table('user')->insert($data);
    }
}
