<?php

namespace App\Http\Controllers;

use App\Services\AuthenService;
use Illuminate\Http\Request;

class AuthenController extends Controller
{
    public function __construct() {

    }

    public function index(){
        return view('login');
    }

    public function login(Request $request){
    	return AuthenService::login($request);
    }

    public function logout() {
        return AuthenService::logout();
    }
}
