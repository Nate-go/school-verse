<?php

namespace App\Constant;

class ExamTypeCoefficient
{
    const COEFFICIENT = [
        ExamType::ORAL => 1,

        ExamType::FIFTEEN_MINUTES => 1,

        ExamType::LESSON => 2,

        ExamType::MIDTERM => 3,

        ExamType::FINAL_SEMESTER => 3,
    ];

    const LIMIT_EXAM = [
        ExamType::ORAL => 2,

        ExamType::FIFTEEN_MINUTES => 2,

        ExamType::LESSON => 2,

        ExamType::MIDTERM => 1,

        ExamType::FINAL_SEMESTER => 1,
    ];
}
