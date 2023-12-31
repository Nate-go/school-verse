<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->middleware('author:'.str(UserRole::ADMIN))->except('show');
        $this->subjectService = $subjectService;
    }

    public function index()
    {
        return $this->subjectService->getPageForAdmin();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->subjectService->getInitizationForm();
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
        return $this->subjectService->getDetailPageForAdmin($id);
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
