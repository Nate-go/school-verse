<?php

namespace App\Constant;

class ExamTypeCoefficient
{
    const COEFFICIENT = [
        ExamType::ORAL => 1,

        ExamType::FIFTEEN_MINUTES => 1,

        ExamType::LESSON => 2,

        ExamType::MIDTERM => 3,

        ExamType::FINAL_SEMESTER => 3
    ];
}
