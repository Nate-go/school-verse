<?php

namespace Database\Factories;

use App\Services\FactoryService;
use App\Traits\ServiceInjection\InjectionService;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class InsistenceFactory extends Factory
{
    use InjectionService;
    public $statuses = [];

    public $statusRanges = [[30, 35], [20, 25], [45, 50]];

    protected $factoryService;

    public function definition(): array
    {
        $this->setInjection([FactoryService::class]);

        $status = $this->factoryService->getValidValue($this->statuses, $this->statusRanges, range(0, 2));
        $this->statuses[] = $status;

        return [
            'user_id' => DB::table('users')->inRandomOrder()->value('id'),
            'content' => Str::random(50),
            'feedback' => Str::random(50),
            'status' => $status,
        ];
    }
}
