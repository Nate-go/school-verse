<?php

namespace App\Http\Livewire\Table;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Profile;
use App\Models\SchoolYear;
use App\Models\User;
use App\Services\ConstantService;
use DB;

class Schoolyeartable extends Table
{
    protected function getData()
    {
        $filterValues = $this->getFilterValues();

        $sort = $filterValues['sort'];
        $search = $filterValues['search'];

        $results = SchoolYear::select('school_years.name', 'school_years.start_at', 'school_years.end_at', 'school_years.id', 
            DB::raw('(SELECT COUNT(id) FROM rooms WHERE school_years.id = rooms.school_year_id) as total_rooms'), 
            DB::raw('(SELECT COUNT(id) FROM students WHERE school_years.id = students.school_year_id) as total_students'))
            ->groupBy('school_years.name', 'school_years.start_at', 'school_years.end_at', 'school_years.id')
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);


        return $results;
    }

    public function delete($userId)
    {

    }
}
