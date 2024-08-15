<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        // Creating Rules for Email and Password
        $this->validate($request, [
            'email' => "required|email",
            "password" => "required|min:6"
        ]);

        $credentials = $request->only("email", "password");
        // attempt to do the login

        if (Auth::attempt($credentials)) {
            return redirect()->intended("home");
        }
        // validation not successful, send back to form

        return back()->withErrors(['email' => 'Invalid credentials']);

    }

    public function logout()
    {
        Auth::logout(); // logging out user
        return redirect()->route('login');
    }
}
