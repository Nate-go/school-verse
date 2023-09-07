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

        $grades = [0, 1, 2];

        $results = Room::select(
            'rooms.id',
            DB::raw('CONCAT(grades.name, "", rooms.name) as room_name'),
            'rooms.image_url as room_name_image_url',
            'school_years.name as school_year',
            'school_year_id',
            'users.username',
            'rooms.grade_id as grade_id', 
            'users.image_url as username_image_url',
            DB::raw('(SELECT COUNT(id) FROM students WHERE room_id = rooms.id) as number_of_members'),
            DB::raw('(SELECT COUNT(id) FROM room_teachers WHERE room_id = rooms.id) - (SELECT COUNT(id) FROM subjects WHERE grade_id = grades.id) as missed_teachers')
        )
            ->join('grades', 'rooms.grade_id', '=', 'grades.id')
            ->join('school_years', 'rooms.school_year_id', '=', 'school_years.id')
            ->join('users', 'rooms.homeroom_teacher_id', '=', 'users.id')
            ->groupBy('room_name', 'rooms.image_url', 'grades.name', 'school_year', 'users.username', 'users.image_url', 'grade_id', 'rooms.id')
            ->filter($this->getElementFilters(['grade_id', 'school_year_id'], [$grades, $schoolYears]))
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);

        return $results;
    }

    public function delete($userId)
    {

    }
}
