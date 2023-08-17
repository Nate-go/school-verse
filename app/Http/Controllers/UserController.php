<?php

namespace App\Http\Controllers;

use App\Constant\Table;
use App\Constant\UserRole;
use App\DTO\TableForm;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService){
        // $this->middleware('author:' . json_encode([UserRole::ADMIN]))->only('index', 'create', 'store', 'destroy');
        $this->userService = $userService;
    }

    public function index()
    {
        // $tableForm = new TableForm(Table::USER_TABLE);
        return view('index', ['tableName' => 'USER_TABLE']);
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
