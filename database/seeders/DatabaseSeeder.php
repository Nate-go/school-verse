<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SubjectSeeder::class,
            SemesterSeeder::class,
            GradeSeeder::class,
            ProfileSeeder::class,
            NotificationSeeder::class,
            SubjectTeachersSeeder::class,
            GradeSubjectsSeeder::class,
            RoomSeeder::class,
            RoomTeacherSeeder::class,
            RoomStudentSeeder::class,
            ExamSeeder::class,
            InsistenceSeeder::class,
            ExamStudentsSeeder::class
        ]);
    }
}
