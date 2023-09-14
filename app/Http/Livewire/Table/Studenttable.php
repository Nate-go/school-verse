<?php

namespace App\Http\Livewire\Table;

use App\Constant\UserRole;
use App\Models\User;
use DB;

class Studenttable extends Table
{
    protected function getData()
    {
        $filterValues = $this->getFilterValues();

        $filters = $filterValues['filters'];
        $grade = $filters['grade'];
        $sort = $filterValues['sort'];
        $search = $filterValues['search'];

        $schoolYears = $filters['school year'];

        $results = User::select(
            'users.id',
            'users.username',
            'users.image_url as username_image_url',
            'school_years.name as school_year',
            'rooms.school_year_id',
            'students.grade_id',
            DB::raw('CONCAT(grades.name, "", rooms.name) as room'),
        )
            ->join('students', 'users.id', '=', 'students.user_id')
            ->join('rooms', 'rooms.id', '=', 'students.room_id')
            ->join('grades', 'grades.id', '=', 'rooms.grade_id')
            ->join('school_years', 'school_years.id', '=', 'rooms.school_year_id')
            ->where('users.role', UserRole::STUDENT)
            ->filter($this->getElementFilters(['rooms.school_year_id', 'students.grade_id'], [$schoolYears, $grade]))
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);

        return $results;
    }
}
