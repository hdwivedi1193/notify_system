<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Check if the user is already authenticated
        if (auth()->check()) {
            // Get the authenticated user
            $user = auth()->user();

            // Redirect based on user type (admin or individual)
            return redirect()->route($user->user_type . '.index');
        }
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
            $request->session()->regenerate(); // to handle session fixation

            $user = Auth::user();
            return redirect()->route($user->user_type . '.index');


        }
        // validation not successful, send back to form

        return back()->withErrors(['email' => 'Invalid credentials']);

    }

    public function logout(Request $request)
    {
        $request->session()->invalidate(); // invalidate user session

        $request->session()->regenerateToken(); // regenerate csrf token
        Auth::logout(); // logging out user
        return redirect()->route('login');
    }
}
