<?php

namespace Database\Seeders;

use App\Models\RoomTeacher;
use Illuminate\Database\Seeder;

class RoomTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomTeacher::factory()->count(500)->create();
    }
}
