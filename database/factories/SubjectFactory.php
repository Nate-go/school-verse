<?php

namespace Database\Factories;

use App\Services\UtilService;
use App\Traits\ServiceInjection\InjectionService;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class SubjectFactory extends Factory
{
    use InjectionService;
    protected $utilService;

    public function definition(): array
    {
        $this->setInjection([UtilService::class]);

        $cofficient = $this->utilService->randValues([2, 1, 1, 1, 1, 1]);

        return [
            'grade_id' => DB::table('grades')->inRandomOrder()->value('id'),
            'name' => Str::random(random_int(5, 7)),
            'number_lesson' => $cofficient * 75,
            'coefficient' => $cofficient,
        ];
    }
}
