<?php

namespace Database\Seeders;

use App\Models\Insistence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsistenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Insistence::factory()->count(100)->create();
    }
}
