<?php

namespace Database\Seeders;

use App\Models\GradeSubjects;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i <=3; $i++ ){
            for($j=1; $j<=14; $j++) {
                if(($i===1 or $i===3) and $j===14) {
                    continue;
                }
                GradeSubjects::create(['grade_id' => $i, 'subject_id' => $j]);
            }
        }
    }
}
