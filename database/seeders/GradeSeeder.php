<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            ['name' => '10th grade'],
            ['name' => '11th grade'],
            ['name' => '12th grade']
        ];

        foreach ($grades as $grade) {
            Grade::create($grade);
        }
    }
}
