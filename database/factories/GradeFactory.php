<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class GradeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => Str::random(2),
        ];
    }
}
