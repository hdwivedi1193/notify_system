<?php

namespace App\Http\Controllers;
use App\Models\User;

use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with user list and unread notification counts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('adminAccess', User::class);
        $users = User::with("unreadNotifications")->where('user_type', '!=', config('site.user.admin'))->get();

        return view('admin.index', compact('users'));
    }

    /**
     * Impersonate a specified user.
     *
     * This impersonate method allows the currently authenticated admin to impersonate
     * another user. It checks if the admin has permission to impersonate
     * the specified user, store the original user ID in the session,sets the impersonation session, and logs in
     * as the specified user. On success, it redirects to the user's homepage.
     *
     */

    public function impersonate(User $user)
    {
        $this->authorize('adminAccess', User::class);
        session()->put('original_user_id', Auth::id());
        session()->put('impersonate', $user->id);
        Auth::login($user);

        return redirect()->route('individual.index');
    }

    public function stopImpersonate()
    {
        session()->forget('impersonate');
        $originalUserId = session()->get('original_user_id');
        $originalUser = User::findOrFail($originalUserId);
        if ($originalUser && $originalUser->user_type == 'admin') {
            Auth::logout();
            $user = Auth::loginUsingId($originalUser->id);
            return redirect()->route($user->user_type . '.index');
        }
        return back() - with("error", "Oops!! Unable to impersonate. Please try again");

    }










}
