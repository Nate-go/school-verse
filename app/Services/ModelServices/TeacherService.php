<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Constant\UserRole;
use App\Models\Teacher;
use App\Models\User;
use Auth;

class TeacherService extends BaseService
{
    protected function getModel()
    {
        return Teacher::class;
    }

    public function getPageForAdmin()
    {
        $data = TableData::TEACHERS;
        $this->tableService->setTableForm($data);

        return view('admin/teacher/teachers', ['tableSource' => $data]);
    }

    public function getInitizationForm()
    {
        return view('admin/teacher/teachers-initialization');
    }

    public function getDetailPageForAdmin($id)
    {
        if (! $this->isUserTeacher($id)) {
            return redirect()->route('notFound');
        }

        return view('admin/teacher/teachers-detail', ['id' => $id]);
    }

    public function getPageForTeacher($id)
    {
        if (! $this->isUserTeacher($id)) {
            return redirect()->route('notFound');
        }
        if (Auth::user()->id != $id) {
            return redirect()->route('notPermission');
        }

        return view('admin/teacher/teachers-detail', ['id' => $id]);
    }

    private function isTeacherExist($teacherId)
    {
        return Teacher::where('id', $teacherId)->exists();
    }

    private function isUserTeacher($userId)
    {
        return User::where('id', $userId)
            ->where('role', UserRole::TEACHER)
            ->exists();
    }
}
