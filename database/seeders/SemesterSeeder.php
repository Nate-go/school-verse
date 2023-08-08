<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters_data = array(
            ['name' => 'Semester 1 - 2018-2019', 'start_from' => '2018-09-01', 'end_at' => '2019-02-01', 'type' => 1],
            ['name' => 'Semester 2 - 2018-2019', 'start_from' => '2019-02-16', 'end_at' => '2019-05-16', 'type' => 2],
            ['name' => 'Semester 3 - 2018-2019', 'start_from' => '2019-06-16', 'end_at' => '2019-08-16', 'type' => 3],
        
            ['name' => 'Semester 1 - 2019-2020', 'start_from' => '2019-09-01', 'end_at' => '2020-02-01', 'type' => 1],
            ['name' => 'Semester 2 - 2019-2020', 'start_from' => '2020-02-16', 'end_at' => '2020-05-16', 'type' => 2],
            ['name' => 'Semester 3 - 2019-2020', 'start_from' => '2020-06-16', 'end_at' => '2020-08-16', 'type' => 3],
        
            ['name' => 'Semester 1 - 2020-2021', 'start_from' => '2020-09-01', 'end_at' => '2021-02-01', 'type' => 1],
            ['name' => 'Semester 2 - 2020-2021', 'start_from' => '2021-02-16', 'end_at' => '2021-05-16', 'type' => 2],
            ['name' => 'Semester 3 - 2020-2021', 'start_from' => '2021-06-16', 'end_at' => '2021-08-16', 'type' => 3],
        
            ['name' => 'Semester 1 - 2021-2022', 'start_from' => '2021-09-01', 'end_at' => '2022-02-01', 'type' => 1],
            ['name' => 'Semester 2 - 2021-2022', 'start_from' => '2022-02-16', 'end_at' => '2022-05-16', 'type' => 2],
            ['name' => 'Semester 3 - 2021-2022', 'start_from' => '2022-06-16', 'end_at' => '2022-08-16', 'type' => 3],
        
            ['name' => 'Semester 1 - 2022-2023', 'start_from' => '2022-09-01', 'end_at' => '2023-02-01', 'type' => 1],
            ['name' => 'Semester 2 - 2022-2023', 'start_from' => '2023-02-16', 'end_at' => '2023-05-16', 'type' => 2],
            ['name' => 'Semester 3 - 2022-2023', 'start_from' => '2023-06-16', 'end_at' => '2023-08-16', 'type' => 3],
        
            ['name' => 'Semester 1 - 2023-2024', 'start_from' => '2023-09-01', 'end_at' => '2024-02-01', 'type' => 1],
            ['name' => 'Semester 2 - 2023-2024', 'start_from' => '2024-02-16', 'end_at' => '2024-05-16', 'type' => 2],
            ['name' => 'Semester 3 - 2023-2024', 'start_from' => '2024-06-16', 'end_at' => '2024-08-16', 'type' => 3],
        );

        foreach ($semesters_data as $semester) {
            Semester::create($semester);
        }
    }
}
