<?php

namespace Tests\Unit\Services\ModelServices\GradeServiceTest;

use App\Services\ModelServices\GradeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetGradesJsonTest extends BaseTest
{
    use RefreshDatabase;

    public function testGetExistGrade()
    {
        $data = $this->setUpInitData();

        $gradeService = app()->make(GradeService::class);
        $result = $gradeService->getGradesJson();

        $this->assertIsArray($result);

        foreach ($result as $item) {
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('value', $item);
        }
    }
}
