<?php

namespace App\Http\Livewire\Table;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Profile;
use App\Models\Subject;
use App\Models\User;
use App\Services\ConstantService;
use DB;

class Subjecttable extends Table
{
    protected function getData()
    {
        $filterValues = $this->getFilterValues();

        $filters = $filterValues['filters'];
        $grades = $filters['grade'];
        $sort = $filterValues['sort'];
        $search = $filterValues['search'];

        $results =Subject::select(
            'subjects.id',
            'number_lesson',
            DB::raw('CONCAT(subjects.name, " ", grades.name) as subject_name'),
            'subjects.image_url as subject_name_image_url',
            'grades.name as grade_name',
            'coefficient',
            DB::raw('(SELECT COUNT(id) FROM teachers WHERE subject_id = subjects.id) as number_of_teachers'),
        )
            ->join('grades', 'subjects.grade_id', '=', 'grades.id')
            ->groupBy('subject_name', 'subjects.id')
            ->filter($this->getElementFilters(['grades.id'], [$grades]))
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);


        return $results;
    }

    public function delete($userId)
    {

    }
}
