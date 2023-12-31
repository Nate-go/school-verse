<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->middleware('author:'.str(UserRole::ADMIN));
        $this->roomService = $roomService;
    }

    public function index()
    {
        return $this->roomService->getPageForAdmin();
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
        return $this->roomService->getDetailPageForAdmin($id);
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
