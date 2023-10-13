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
            InsistenceSeeder::class,
            //NotificationSeeder::class,
            GradeSeeder::class,
            SchoolYearSeeder::class,
            SubjectSeeder::class,
            TeacherSeeder::class,
            RoomSeeder::class,
            RoomTeacherSeeder::class,
            StudentSeeder::class,
            ExamSeeder::class,
            ExamStudentsSeeder::class,
            ParentSeeder::class,
            ChangeDataSeeder::class,
            TotalScoreForStudent::class
        ]);
    }
}
