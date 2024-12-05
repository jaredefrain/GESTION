<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'age' => 30,
            ]);
        }

        if (!User::where('email', 'referee@example.com')->exists()) {
            User::create([
                'name' => 'Referee John',
                'email' => 'referee@example.com',
                'password' => bcrypt('password'),
                'role' => 'referee',
                'age' => 40,
            ]);
        }

        if (!User::where('email', 'player@example.com')->exists()) {
            User::create([
                'name' => 'Player Jane',
                'email' => 'player@example.com',
                'password' => bcrypt('password'),
                'role' => 'player',
                'age' => 25,
            ]);
        }
    }
}
