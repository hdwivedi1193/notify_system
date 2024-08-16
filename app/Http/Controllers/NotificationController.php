<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //

    public function create()
    {
        $this->authorize("post", User::class);
        // Fetch users with notifications switch on

        $users = User::where('notification_switch', true)->where('user_type', "!=", config("site.user.admin"))->get();
        return view('admin.create-notification', compact('users'));
    }
    public function store(Request $request)
    {
        $this->authorize("post", User::class);
        // Validate the request data

        $request->validate([
            'type' => 'required|in:marketing,invoices,system',
            'short_text' => 'required|string',
            'expiration' => 'required|date',
            'target_type' => 'required|in:all,specific',
            'target_users.*' => 'exists:users,id'
        ]);

        // Create a new notification
        $notification = new Notification();
        $notification->type = $request->type;
        $notification->text = $request->short_text;
        $notification->expiration = $request->expiration;
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
}
