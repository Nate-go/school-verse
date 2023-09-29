<?php

namespace Tests\Unit\Services\ModelServices\GradeServiceTest;

use App\Models\Grade;
use App\Services\ModelServices\GradeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetGradesJsonTest extends TestCase
{
    use RefreshDatabase;

    public function testGetExistGrade()
    {
        $grade = Grade::create([
            'name' => 10,
        ]);

        $gradeService = app()->make(GradeService::class);
        $result = $gradeService->getGradesJson();

        $this->assertIsArray($result);

        foreach ($result as $item) {
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('value', $item);
        }
    }
}
