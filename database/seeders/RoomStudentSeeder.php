<?php

namespace Database\Seeders;

use App\Models\RoomStudents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomStudents::factory()->count(200)->create();
    }
}
