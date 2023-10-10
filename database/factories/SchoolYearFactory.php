<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolYearFactory extends Factory
{
    public $year = 2020;

    public function definition(): array
    {
        $this->year += 1;

        return [
            'name' => str($this->year).' - '.str($this->year + 1),
            'start_at' => str($this->year).'-09-01',
            'end_at' => str($this->year + 1).'-08-31',
        ];
    }
}
