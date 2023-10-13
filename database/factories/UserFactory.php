<?php

namespace Database\Factories;

use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Profile;
use App\Services\FactoryService;
use App\Traits\ServiceInjection\InjectionService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    use InjectionService;

    public $roles = [];

    public $roleRange = [[], [30, 35], [70, 75]];

    public $statuses = [];

    public $statusRange = [[10, 15], [80, 85], [5, 10]];

    public $factoryService;

    public $count = 0;

    public function definition(): array
    {
        $this->setInjection([FactoryService::class]);

        $role = $this->factoryService->getValidValue($this->roles, $this->roleRange, [1, 2]);
        $this->roles[] = $role;

        $profile = Profile::factory()->create();

        $status = $this->factoryService->getValidValue($this->statuses, $this->statusRange, range(0, 2));
        $this->statuses[] = $status;

        $fullUrl = url('/');
        $this->count+=1;
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('123456'),
            'role' => $this->count%8 < 3 ? UserRole::TEACHER : UserRole::STUDENT,
            'username' => fake()->name(),
            'profile_id' => $profile->id,
            'status' => UserStatus::ACTIVE,
            'image_url' => $fullUrl.'/img/default-user-'.str(random_int(0, 5)).'.png',
        ];
    }
}
