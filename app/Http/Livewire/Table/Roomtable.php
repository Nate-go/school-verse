<?php

namespace App\Http\Livewire\Table;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Profile;
use App\Models\Room;
use App\Models\User;
use App\Services\ConstantService;
use DB;

class Roomtable extends Table
{
    protected function getData()
    {
        $filterValues = $this->getFilterValues();

        $filters = $filterValues['filters'];
        $grades = $filters['grade'];
        $sort = $filterValues['sort'];
        $search = $filterValues['search'];

        $schoolYears = $filters['school year'];

        $results = Room::select(
            DB::raw('CONCAT(grades.name, "", rooms.name) as room_name'),
            'rooms.image_url as room_name_image_url',
            'grades.name as grade_name',
            'school_years.name as school_year',
            'users.username',
            'users.image_url as username_image_url',
            DB::raw('COUNT(students.id) as number_of_members'),
            DB::raw('(COUNT(subjects.id) - COUNT(room_teachers.id)) as missed_teachers')
        )
            ->join('grades', 'rooms.grade_id', '=', 'grades.id')
            ->join('school_years', 'rooms.school_year_id', '=', 'school_years.id')
            ->join('users', 'rooms.homeroom_teacher_id', '=', 'users.id')
            ->join('room_teachers', 'rooms.id', '=', 'room_teachers.room_id')
            ->join('subjects', 'rooms.grade_id', '=', 'subjects.grade_id')
            ->leftJoin('students', 'rooms.id', '=', 'students.room_id')
            ->groupBy('room_name', 'rooms.image_url', 'grades.name', 'school_year', 'users.username', 'users.image_url')
            ->filter('grades.id', $grades)
            ->filter('school_years.id', $schoolYears)
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);


        return $results;
    }

    public function delete($userId)
    {

    }
}
