<?php

namespace App\Http\Livewire\Table;
use App\Models\Grade;
use DB;

class Gradetable extends Table
{
    protected function getData() {
        $filterValues = $this->getFilterValues();

        $sort = $filterValues['sort'];
        $search = $filterValues['search'];

        $results = Grade::select(
            'name',
            'id',
            DB::raw('(SELECT COUNT(id)  FROM subjects WHERE grades.id = subjects.grade_id) as number_of_subjects'),
            DB::raw('(SELECT COUNT(teachers.id) FROM subjects join teachers ON subjects.id = teachers.subject_id WHERE grades.id = subjects.grade_id) as number_of_teachers'),
        )
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);


        return $results;
    }

    public function delete($userId) {
        
    }
}
