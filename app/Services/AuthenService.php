<?php

namespace App\Services;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AuthenService{
    public static function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $validator->validate();

        if (Auth::attempt($credentials)) {
            if ($request->session()->has('previousUrl')) {
                $previousUrl = $request->session()->get('previousUrl');
                $request->session()->forget('previousUrl');
                $request->session()->regenerate();
                return redirect($previousUrl);
            }
            $request->session()->regenerate();
            return redirect()->route('homepage');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public static function logout(){
        auth()->logout();
        return route('login.index');
    } 
}