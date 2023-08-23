<?php

namespace Database\Factories;

use App\Services\UtilService;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    public function definition(): array
    {
        $cofficient = UtilService::randValues([2, 1, 1, 1, 1, 1]);

        return [
            'grade_id' => DB::table('grades')->inRandomOrder()->value('id'),
            'name' => Str::random(random_int(5, 7)),
            'number_lesson' => $cofficient * 75,
            'coefficient' => $cofficient,
        ];
    }
}
