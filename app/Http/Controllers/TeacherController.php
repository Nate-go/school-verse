<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->middleware('author:'.json_encode([UserRole::ADMIN]));
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        return $this->teacherService->getPageForAdmin();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->teacherService->getInitizationForm();
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
