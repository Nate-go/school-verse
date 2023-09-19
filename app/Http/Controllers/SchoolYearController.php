<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\SchoolYearService;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    protected $schoolYearService;

    public function __construct(SchoolYearService $schoolYearService)
    {
        $this->middleware('author:'.json_encode([UserRole::ADMIN]))->only('index', 'create', 'store', 'destroy');
        $this->schoolYearService = $schoolYearService;
    }

    public function index()
    {
        return $this->schoolYearService->getPageForAdmin();
    }

    public function create()
    {
        return $this->schoolYearService->getInitizationForm();
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
        return $this->schoolYearService->getDetailPageForAdmin($id);
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

    }
}
