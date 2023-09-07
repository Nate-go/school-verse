<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\RoomService;
use Auth;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->middleware('author:'.json_encode([UserRole::ADMIN]))->except('show');
        $this->roomService = $roomService;
    }

    public function index()
    {
        switch(Auth::user()->role) {
            case UserRole::ADMIN:
                return $this->roomService->getPageForAdmin();
            case UserRole::TEACHER:
                return $this->roomService->getPageForTeacher();
            default:
                return $this->roomService->getPageForStudent();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->roomService->getInitizationForm();
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
