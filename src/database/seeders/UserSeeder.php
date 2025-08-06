<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
                'full_name'    => 'Test User 1',
                'date_of_birth'=> null,
                'phone_number' => null,
                'mail'         => 'test1@example.com',
                'user_name'    => 'test1',
                'password'     => Hash::make('password1'),
                'cccd'         => null,
                'role'         => '1',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'full_name'    => 'Test User 2',
                'date_of_birth'=> null,
                'phone_number' => null,
                'mail'         => 'test2@example.com',
                'user_name'    => 'test2',
                'password'     => Hash::make('password2'),
                'cccd'         => null,
                'role'         => '2',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'full_name'    => 'Test User 3',
                'date_of_birth'=> null,
                'phone_number' => null,
                'mail'         => 'test3@example.com',
                'user_name'    => 'test3',
                'password'     => Hash::make('password3'),
                'cccd'         => null,
                'role'         => '3',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);
    }
}
