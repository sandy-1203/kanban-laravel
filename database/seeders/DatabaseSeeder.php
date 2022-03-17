<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'id' => 1,
            "email" => "admin@gmail.com",
            "name" => "admin",
            "password" => Hash::make(123456),
        ]);

        $board = \App\Models\Board::create([
            'name' => 'First Board',
            'user_id' => $user->id
        ]);
    }
}
