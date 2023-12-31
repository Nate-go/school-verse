<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\GradeService;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    protected $gradeService;

    public function __construct(GradeService $gradeService)
    {
        $this->middleware('author:'.str(UserRole::ADMIN));
        $this->gradeService = $gradeService;
    }

    public function index()
    {
        return $this->gradeService->getPageForAdmin();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->gradeService->getInitizationForm();
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
        return $this->gradeService->getDetailPageForAdmin($id);
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
