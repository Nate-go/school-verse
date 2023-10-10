<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\InsistenceService;
use Auth;
use Illuminate\Http\Request;

class InsistenceController extends Controller
{
    protected $insistenceService;

    public function __construct(InsistenceService $insistenceService)
    {
        $this->middleware('author:'.str(UserRole::ADMIN).'|'.str(UserRole::TEACHER).'|'.str(UserRole::STUDENT));
        $this->insistenceService = $insistenceService;
    }

    public function index()
    {
        if (Auth::user()->role === UserRole::ADMIN) {
            return $this->insistenceService->getPageForAdmin();
        }

        return $this->insistenceService->getPageForUser(Auth::user()->id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role == UserRole::ADMIN) {
            return redirect()->route('notPermission');
        }

        return $this->insistenceService->getCreatePage(Auth::user()->id);
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
        if (Auth::user()->role == UserRole::ADMIN) {
            return $this->insistenceService->getDetailPageForAdmin($id);
        }

        return $this->insistenceService->getDetailPageForUser($id);
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
