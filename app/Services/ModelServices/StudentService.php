<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Constant\UserRole;
use App\Models\Student;
use App\Models\User;

class StudentService extends BaseService
{
    public function getModel()
    {
        return Student::class;
    }

    public function getPageForAdmin()
    {
        $data = TableData::STUDENTS;
        $this->tableService->setTableForm($data);

        return view('admin/student/students', ['tableSource' => $data]);
    }

    public function getInitizationForm()
    {
        return view('admin/student/students-initialization');
    }

    public function getDetailPageForAdmin($id)
    {
        if (! $this->isUserStudent($id)) {
            return redirect()->route('notFound');
        }

        return view('admin/student/students-detail', ['id' => $id]);
    }

    private function isStudentExist($studentId)
    {
        return Student::where('id', $studentId)->exists();
    }

    private function isUserStudent($userId)
    {
        return User::where('id', $userId)
            ->where('role', UserRole::STUDENT)
            ->exists();
    }

    public function getPageForStudent($userId)
    {
        if (! $this->isUserStudent($userId)) {
            return redirect()->route('notFound');
        }

        return view('admin/student/students-detail', ['id' => $userId]);
    }
}
