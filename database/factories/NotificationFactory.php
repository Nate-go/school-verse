<?php

namespace Database\Factories;

use App\Services\FactoryService;
use App\Services\UtilService;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    public $statuses = [];

    public $statusRanges = [[20, 35], [65, 80]];

    public function definition(): array
    {
        $status = FactoryService::getValidValue($this->statuses, $this->statusRanges, range(0, 1));
        $this->statuses[] = $status;

        return [
            'content' => Str::random(20),
            'status' => $status,
            'link' => Str::random(15),
            'user_id' => DB::table('users')->inRandomOrder()->value('id'),
            'from_user_id' => UtilService::randValues([null, DB::table('users')->inRandomOrder()->value('id')]),
        ];
    }
}
