<?php

namespace Database\Factories;

use App\Services\FactoryService;
use App\Services\UtilService;
use App\Traits\ServiceInjection\InjectionService;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class NotificationFactory extends Factory
{
    use InjectionService;
    public $statuses = [];

    public $statusRanges = [[20, 35], [65, 80]];

    protected $factoryService;

    protected $utilService;

    public function definition(): array
    {
        $this->setInjection([FactoryService::class, UtilService::class]);
        
        $status = $this->factoryService->getValidValue($this->statuses, $this->statusRanges, range(0, 1));
        $this->statuses[] = $status;

        return [
            'content' => Str::random(20),
            'status' => $status,
            'link' => Str::random(15),
            'user_id' => DB::table('users')->inRandomOrder()->value('id'),
            'from_user_id' => $this->utilService->randValues([null, DB::table('users')->inRandomOrder()->value('id')]),
        ];
    }
}
