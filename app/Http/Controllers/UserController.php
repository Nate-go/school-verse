<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('author:' . json_encode([UserRole::ADMIN]))->only('index', 'create', 'store', 'destroy');
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->getPageForAdmin();
    }

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
        $this->userService->softDelete($id);
    }
}
