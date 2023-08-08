<?php

namespace Database\Seeders;

use App\Models\RoomTeachers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomTeachers::factory()->count(100)->create();
    }
}
