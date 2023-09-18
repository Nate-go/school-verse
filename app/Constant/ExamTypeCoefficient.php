<?php

namespace App\Constant;

class ExamTypeCoefficient
{
    const COEFFICIENT = [
        ExamType::ORAL => 5 / 100,

        ExamType::FIFTEEN_MINUTES => 10 / 100,

        ExamType::LESSON => 15 / 100,

        ExamType::MIDTERM => 20 / 100,

        ExamType::FINAL_SEMESTER => 50 / 100
    ];
}
