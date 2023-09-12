<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    public $grade = 5;

    public function definition(): array
    {
        $this->grade += 1;

        return [
            'name' => Str($this->grade),
        ];
    }
}
