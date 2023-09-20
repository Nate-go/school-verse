<?php

namespace App\Http\Livewire\Table;

use App\Constant\UserRole;
use App\Models\User;
use DB;

class Teachertable extends Table
{
    protected function getData()
    {
        $filterValues = $this->getFilterValues();

        $filters = $filterValues['filters'];
        $sort = $filterValues['sort'];
        $search = $filterValues['search'];

        $schoolYears = $filters['school year'];

        $results = User::select(
            'users.id',
            'users.username',
            'users.image_url as username_image_url',
            'school_years.name as school_year',
            DB::raw('COUNT(DISTINCT teachers.id) as number_of_subjects'),
            DB::raw('COUNT(DISTINCT room_teachers.room_id) as number_of_rooms'),
            DB::raw('(SELECT COUNT(DISTINCT rooms.id) FROM rooms WHERE rooms.homeroom_teacher_id = users.id) as number_of_homerooms'),
        )
            ->join('teachers', 'users.id', '=', 'teachers.user_id')
            ->join('room_teachers', 'room_teachers.teacher_id', '=', 'teachers.id')
            ->join('rooms', 'rooms.id', '=', 'room_teachers.room_id')
            ->join('school_years', 'school_years.id', '=', 'rooms.school_year_id')
            ->where('users.role', UserRole::TEACHER)
            ->whereAllDeletedNull(['teachers', 'room_teachers', 'rooms', 'school_years'])
            ->groupBy('users.id', 'rooms.school_year_id')
            ->filter($this->getElementFilters(['rooms.school_year_id'], [$schoolYears]))
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);
        return $results;
    }
}
