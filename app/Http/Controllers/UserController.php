<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\UserService;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('author:' . str(UserRole::ADMIN) . '|' . str(UserRole::TEACHER) . '|' . str(UserRole::STUDENT))->only('index', 'create', 'store', 'destroy');
        $this->userService = $userService;
    }

    public function index()
    {
        if(Auth::user()->role == UserRole::ADMIN) {
            return $this->userService->getPageForAdmin();
        }
        return $this->userService->getDetailPage(Auth::user()->id);
    }

    public function create()
    {
        if (Auth::user()->role == UserRole::ADMIN) {
            return $this->userService->getInitizationForm();
        }
        return redirect()->route('notPermission');
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
        if(Auth::user()->role == UserRole::ADMIN) {
            return $this->userService->getDetailPage($id);
        }
        return redirect()->route('notPermission');
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
