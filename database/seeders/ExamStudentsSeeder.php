<?php

namespace Database\Seeders;

use App\Models\ExamStudents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamStudents::factory()->count(100)->create();
    }
}
