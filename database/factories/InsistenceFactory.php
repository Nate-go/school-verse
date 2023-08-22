<?php

namespace Database\Factories;

use App\Services\FactoryService;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Insistence>
 */
class InsistenceFactory extends Factory
{
    public $statuses = [];
    public $statusRanges = [[30, 35], [20, 25], [45, 50]];

    public function definition(): array
    {
        $status = FactoryService::getValidValue($this->statuses, $this->statusRanges, range(0, 2));
        $this->statuses[] = $status;
        
        return [
            'user_id' => DB::table('users')->inRandomOrder()->value('id'),
            'content' => fake()->sentence(50),
            'status' => $status
        ];
    }
}
