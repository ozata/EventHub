<?php

use Illuminate\Database\Seeder;
use App\User;
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
        //$this->call(EventsTableSeeder::class);
        //$this->call(GamesTableSeeder::class);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'role' => 2
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('secret'),
            'role' => 1
        ]);
    }
}
