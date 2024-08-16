<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        $user=Auth::user();
        return view('users.index', compact('user'));
    }
}
