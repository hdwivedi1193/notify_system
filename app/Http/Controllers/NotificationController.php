<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //

    public function create()
    {
        $this->authorize('adminAccess', User::class);
        // Fetch users with notifications switch on

        $users = User::where('user_type', "!=", config("site.user.admin"))->get();
        return view('admin.create-notification', compact('users'));
    }
    public function store(Request $request)
    {
        $this->authorize('adminAccess', User::class);
        // Validate the request data
        $this->validate($request,[
            'type' => 'required|in:marketing,invoices,system',
            'short_text' => 'required|string|max:255',
            'expiration' => 'required|date',
            'target_type' => 'required|in:all,specific',
            'target_users.*' => 'exists:users,id'
        ]);
        // Create a new notification
        $notification = new Notification();
        $notification->type = $request->type;
        $notification->text = $request->short_text;
        $notification->expiration = $request->expiration." "."23:59:59";
        $notification->destination = $request->target_type;
        $notification->save();

        // If target type is specific, attach users

        if ($request->target_type === 'specific') {
            $notification->users()->attach($request->target_users);
        } else {
            // Dispatch job for sending notifications to all users
            dispatch(new SendNotificationJob($notification))->onConnection('database');
        }
        return redirect()->route('admin.notifications.create')->with('success', 'Notification created successfully.');

    }

    public function show(User $user)
    {
        $this->authorize("edit", $user);
        return view('users.user-notifications', compact('user'));
    }

    public function markAsRead(User $user, $id)
    {
        $this->authorize("edit", $user);
        $authUser = Auth::user();
        if ($authUser->user_type === config("site.user.admin")) {
            return response()->json([
                'status' => 400,
                "message"=>"Unauthorized Action: You can only mark your own notifications as read"
            ]);
        }
        // Update pivot table
        $userNotifications=UserNotification::where('id', $id)
            ->where('user_id', $user->id)
            ->update(['is_read'=>true]);

        return response()->json([
            'status' => 200,
            "message"=>"Notification marked as read successfully."
        ]);
    }

}
