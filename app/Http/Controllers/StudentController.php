<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->middleware('author:'.json_encode([UserRole::ADMIN]))->except('destroy');
        $this->studentService = $studentService;
    }

    public function index()
    {
        return $this->studentService->getPageForAdmin();
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
