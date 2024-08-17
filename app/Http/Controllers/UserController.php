<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Individual Dashboard.
     *
     * Retrieve the currently authenticated user and pass it to the 'users.index' view.
     * This view is expected to display user-specific information, such as profile details.
     *
     */
    public function index()
    {
        $user = Auth::user();
        return view('users.index', compact('user'));
    }
}
