<?php

namespace Database\Seeders;

use App\Models\ExamStudent;
use Illuminate\Database\Seeder;

class ExamStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamStudent::factory()->count(500)->create();
    }
}
