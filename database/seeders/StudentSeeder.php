<?php

namespace Database\Seeders;

use App\Constant\UserRole;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $randomGrades = $this->generate_increasing_combinations_with_repeats(range(1, 7), 5);
        $students = User::selectColumns('id')->where('role', UserRole::STUDENT)->get();
        $rooms = Room::selectColumns(['id', 'grade_id', 'school_year_id'])->get();

        $studentData = [];
        $data = $this->getTrueData($randomGrades, count($students));

        for ($i = 0; $i < count($students); $i++) {
            $studentData[] = [
                'userId' => $students[$i]->id,
                'gradeIds' => $data[$i],
            ];
        }

        $studentMap = [];

        foreach ($studentData as $item) {

            for ($i = 0; $i < 5; $i++) {
                $studentMap[$i + 1][$item['gradeIds'][$i]][] = $item['userId'];
            }
        }

        foreach (range(1, 5) as $schoolYear) {
            foreach (range(1, 7) as $grade) {
                if (! isset($studentMap[$schoolYear][$grade])) {
                    continue;
                }
                $currentStudents = $studentMap[$schoolYear][$grade];
                while (! empty($currentStudents)) {
                    foreach ($rooms as $room) {
                        if ($room->grade_id != $grade or $room->school_year_id != $schoolYear) {
                            continue;
                        }
                        if (empty($currentStudents)) {
                            break;
                        }
                        $studentId = array_shift($currentStudents);
                        Student::create([
                            'user_id' => $studentId,
                            'school_year_id' => $schoolYear,
                            'grade_id' => $grade,
                            'room_id' => $room->id,
                        ]);
                    }
                }
            }
        }

    }

    private function getTrueData($randomGrades, $number)
    {
        $success = false;

        $data = [];
        foreach (range(1, $number) as $index) {
            $randomIndex = random_int(0, count($randomGrades) - 1);
            $data[] = $randomGrades[$randomIndex];
        }

        return $data;
    }

    private function check_occurrences($array)
    {
        $required_numbers = range(1, 7);

        foreach ($array as $sub_array) {
            $counts = array_count_values($sub_array);

            foreach ($required_numbers as $number) {
                if (! isset($counts[$number]) || $counts[$number] < 1) {
                    return false;
                }
            }
        }

        return true;
    }

    private function generate_increasing_combinations_with_repeats($numbers, $k)
    {
        $combinations = [];
        $total_numbers = count($numbers);

        if ($k == 0 || $k > $total_numbers) {
            return $combinations;
        }

        for ($i = 0; $i <= $total_numbers - $k; $i++) {
            $combination = array_slice($numbers, $i, $k);
            $combinations[] = $combination;
        }

        return $combinations;
    }
}
