<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users_data = array(
            // Admin
            ['email' => 'admin@gmail.com', 'password' => encrypt('123456'), 'role' => 0, 'status' => 1],
            // Teachers
            ['email' => 'math1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'physics1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'chemistry1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'literature1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'history1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'geography1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'civiceducation1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'physicaleducation1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'computerscience1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'english1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'technology1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'biology1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'citizenship1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            ['email' => 'career1@gmail.com', 'password' => encrypt('123456'), 'role' => 1, 'status' => 1],
            // Students
            ['email' => 'student1@gmail.com', 'password' => encrypt('123456'), 'role' => 2, 'status' => 1],
            ['email' => 'student2@gmail.com', 'password' => encrypt('123456'), 'role' => 2, 'status' => 1],
            ['email' => 'student3@gmail.com', 'password' => encrypt('123456'), 'role' => 2, 'status' => 1],
            ['email' => 'student4@gmail.com', 'password' => encrypt('123456'), 'role' => 2, 'status' => 1],
            ['email' => 'student5@gmail.com', 'password' => encrypt('123456'), 'role' => 2, 'status' => 1],
        );

        foreach ($users_data as $user) {
            User::create($user);
        }
        
        User::factory()->count(100)->create();
    }
}
