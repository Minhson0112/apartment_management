<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('user')->insert([
            [
                'cccd'         => 123456,
                'full_name'    => 'Minh Sơn',
                'date_of_birth' => null,
                'phone_number' => null,
                'mail'         => 'test1@example.com',
                'user_name'    => 'test1',
                'password'     => Hash::make('password1'),
                'role'         => '1',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'cccd'         => 123457,
                'full_name'    => 'Minh Cò',
                'date_of_birth' => null,
                'phone_number' => null,
                'mail'         => 'test2@example.com',
                'user_name'    => 'test2',
                'password'     => Hash::make('password2'),
                'role'         => '2',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'cccd'         => 123458,
                'full_name'    => 'Xuân Hương',
                'date_of_birth' => null,
                'phone_number' => null,
                'mail'         => 'test3@example.com',
                'user_name'    => 'test3',
                'password'     => Hash::make('password3'),
                'role'         => '3',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);
    }
}
