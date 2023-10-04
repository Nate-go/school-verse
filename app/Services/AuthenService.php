<?php

namespace App\Services;

use Auth;
use Illuminate\Http\Request;
use Validator;

class AuthenService
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $email = $request->get('email');

        if ($validator->fails()) {
            return view('login', ['email' => $email, 'errors' => $validator->errors()->all()]);
        }

        $credentials = $validator->validate();

        $rememberme = $request->has('rememberme');

        if (Auth::attempt($credentials, $rememberme)) {
            if ($request->session()->has('previousUrl')) {
                $previousUrl = $request->session()->get('previousUrl');
                $request->session()->forget('previousUrl');
                $request->session()->regenerate();

                return redirect($previousUrl);
            }

            return redirect()->route('homepage');
        }

        return view('login', ['email' => $email, 'errors' => ['Login information is incorrect']]);
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login.index');
    }
}
