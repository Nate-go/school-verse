<?php

namespace App\Http\Controllers;

use App\Services\AuthenService;
use Illuminate\Http\Request;

class AuthenController extends Controller
{
    protected $authenService;

    public function __construct(AuthenService $authenService)
    {
        $this->authenService = $authenService;
    }

    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        return $this->authenService->login($request);
    }

    public function logout()
    {
        return $this->authenService->logout();
    }
}
