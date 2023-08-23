<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Services\FactoryService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public $roles = [];
    public $roleRange = [[], [30, 35], [70, 75]];

    public $statuses = [];

    public $statusRange = [[10, 15], [80, 85], [5, 10]];
    
    public function definition(): array
    {
        $role = FactoryService::getValidValue($this->roles, $this->roleRange, [1, 2]);
        $this->roles[] = $role;

        $profile = Profile::factory()->create();

        $status = FactoryService::getValidValue($this->statuses, $this->statusRange, range(0,2));
        $this->statuses[] = $status;
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('123456'),
            'role' => $role,
            'username' => fake()->userName(),
            'profile_id' => $profile->id,
            'status' => $status
        ];
    }
}
