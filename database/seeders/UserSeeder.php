<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users_data = [
            // Admin
            ['email' => 'admin@gmail.com', 'password' => Hash::make('123456'), 'role' => 0, 'status' => 1, 'username' => 'admin', 'profile_id' => 1],
        ];

        Profile::factory()->count(1)->create();
        foreach ($users_data as $user) {
            User::create($user);
        }

        User::factory()->count(150)->create();
    }
}
