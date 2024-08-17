<?php

namespace App\Http\Controllers;
use App\Criteria\UserSearch;
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
    public function index(Request $request)
    {
        // Check if the current user has permission to access admin dashboard.
        $this->authorize('adminAccess', User::class);

        // Retrieve all users who are not admins, eager loading their unread notifications to minimize database queries.

        $users = User::with("unreadNotifications")->where('user_type', '!=', config('site.user.admin'));
        // Apply a filter based on the notification search if provided in the request

        if ($request->has('email') && $request->email) {
            (new UserSearch('email', trim($request->email)))->apply($users);
        }
        $users = $users->get();

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
        // Check if the current user has permission to impersonate the target user.
        $this->authorize('adminAccess', User::class);
        // Store the original user ID in the session

        session()->put('original_user_id', Auth::id());
        // Store the ID of the user being impersonated in the session.

        session()->put('impersonate', $user->id);
        // Log in as the specified user.

        Auth::login($user);

        return redirect()->route('individual.index');
    }
    /**
     * Stop impersonating and revert to the original user.
     *
     * This method ends the impersonation session and logs the admin
     * back in as the original user. It retrieves the original user ID
     * from the session, performs the login. On success, it redirects to the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function stopImpersonate()
    {
        // Remove the impersonation session.

        session()->forget('impersonate');
        $originalUserId = session()->get('original_user_id');
        // Find the original user based on the stored ID.

        $originalUser = User::findOrFail($originalUserId);
        if ($originalUser && $originalUser->user_type == 'admin') {
            Auth::logout();
            // Log in as the original user(admin).

            $user = Auth::loginUsingId($originalUser->id);
            return redirect()->route($user->user_type . '.index');
        }
        return redirect()->back()->with("error", "Oops!! Unable to impersonate. Please try again");

    }
}
