<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\TeacherService;
use Auth;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->middleware('author:' . str(UserRole::ADMIN) . '|' . str(UserRole::TEACHER));
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        if(Auth::user()->role == UserRole::ADMIN) {
            return $this->teacherService->getPageForAdmin();
        }
        return $this->teacherService->getPageForTeacher(Auth::user()->id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role == UserRole::ADMIN) {
            return $this->teacherService->getInitizationForm();
        }
        return redirect()->route('notPermission');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::user()->role != UserRole::ADMIN) {
            return redirect()->route('notPermission');
        }
        return $this->teacherService->getDetailPageForAdmin($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
