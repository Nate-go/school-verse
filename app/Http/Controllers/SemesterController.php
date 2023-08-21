<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\SemesterService;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    protected $semesterService;

    public function __construct(SemesterService $semesterService){
        $this->middleware('author:' . json_encode([UserRole::ADMIN]))->except('show');
        $this->semesterService = $semesterService;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
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
