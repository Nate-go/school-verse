<?php

namespace App\Http\Livewire\Table;

use App\Models\Subject;
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

        $results = Subject::select(
            'subjects.id',
            'number_lesson',
            DB::raw('CONCAT(subjects.name, " ", grades.name) as subject_name'),
            'subjects.image_url as subject_name_image_url',
            'grades.name as grade_name',
            'grades.id as grade_id',
            'coefficient',
            DB::raw('(SELECT COUNT(teachers.id) FROM teachers WHERE teachers.subject_id = subjects.id) as number_of_teachers'),
        )
            ->join('grades', 'subjects.grade_id', '=', 'grades.id')
            ->groupBy('subject_name', 'subjects.id')
            ->filter($this->getElementFilters(['grade_id'], [$grades]))
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);

        return $results;
    }

    public function delete($id, $confirmed = false)
    {
        if (! $confirmed) {
            $this->confirmBox('delete this item', 'delete', ['id' => $id, 'confirmed' => true]);

            return;
        }

        $result = Subject::where('id', $id)->delelete();

        if ($result) {
            $this->notify('success', 'Delete user successfull');
        }
    }
}
