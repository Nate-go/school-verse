<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class AuthenController extends Controller
{
    public function __construct() {

    }

    public function index(){
        return view('login');
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $validator->validate();

        if (Auth::attempt($credentials)) {
            if($request->session()->has('previousUrl')){
                $previousUrl = $request->session()->get('previousUrl');
                $request->session()->forget('previousUrl');
                $request->session()->regenerate();
                return redirect($previousUrl);
            }
            $request->session()->regenerate();
            return redirect()->route('welcome');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout() {
        auth()->logout();
        return route('login.index');
    }
}
