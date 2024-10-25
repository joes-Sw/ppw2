<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $user = collect([
            [
                'name' => 'Doe',
                'email' => 'doe@gmail.com',
                'age' => 30,
                'level' => 'superadmin',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Budi',
                'email' => 'budi@gmail.com',
                'age' => 20,
                'level' => 'admin',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'bapakbudi',
                'email' => 'budigeming@gmail.com',
                'age' => 22,
                'level' => 'manajemen',
                'password' => Hash::make('12345678'),
            ]
        ]);

        $user->each(fn ($put) => DB::table('users')->insert($put));
    }
}
