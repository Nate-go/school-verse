<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\StudentService;
use Auth;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->middleware('author:' . str(UserRole::ADMIN) . '|' . str(UserRole::STUDENT))->except('destroy');
        $this->studentService = $studentService;
    }

    public function index()
    {
        if (Auth::user()->role == UserRole::ADMIN) {
            return $this->studentService->getPageForAdmin();
        }
        return $this->studentService->getPageForStudent(Auth::user()->id);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->studentService->getInitizationForm();
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
        if (Auth::user()->role != UserRole::ADMIN) {
            return redirect()->route('notPermission');
        }
        return $this->studentService->getDetailPageForAdmin($id);
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
