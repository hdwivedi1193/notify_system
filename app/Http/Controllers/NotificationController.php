<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Criteria\search;

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
        $this->validate($request, [
            'type' => 'required|in:marketing,invoices,system',
            'short_text' => 'required|string|max:255',
            'expiration' => 'required|date',
            'target_type' => 'required|in:all,specific',
            'target_users.*' => 'exists:users,id' // Ensure each target user ID exists in the users table.
        ]);
        // Create a new notification

        $notification = new Notification();
        $notification->type = $request->type;
        $notification->text = $request->short_text;
        // Append the time to expiration date to ensure it lasts until the end of the day.

        $notification->expiration = $request->expiration . " " . "23:59:59";
        $notification->destination = $request->target_type;
        $notification->save(); // Save the notification to the database.

        // If target type is specific, attach users

        if ($request->target_type === 'specific') {
            // Attach selected users to the notification.

            $notification->users()->attach($request->target_users);
        } else {
            // Dispatch job for attaching notifications to all users
            dispatch(new SendNotificationJob($notification))->onConnection('database');
        }
        return redirect()->route('admin.notifications.create')->with('success', 'Notification created successfully.');

    }

    public function show(User $user)
    {
        // Authorize the user for the "edit" action, ensuring only authorized users can view the notifications
        $this->authorize("edit", $user);
        return view('users.user-notifications', compact('user'));
    }

    public function markAsRead(User $user, $id)
    {
        $this->authorize("edit", $user);
        // Get the currently authenticated user

        $authUser = Auth::user();
        // Check if the authenticated user is an admin, who is not allowed to mark notifications as read for others

        if ($authUser->user_type === config("site.user.admin")) {
            return response()->json([
                'status' => 400,
                "message" => "Unauthorized Action: You can only mark your own notifications as read"
            ]);
        }
        // Update the pivot table, setting the 'is_read' field to true for the specific notification
        $userNotifications = UserNotification::where('id', $id)
            ->where('user_id', $user->id)
            ->update(['is_read' => true]);

        return response()->json([
            'status' => 200,
            "message" => "Notification marked as read successfully."
        ]);
    }

    public function list(Request $request)
    {
        $this->authorize("adminAccess", User::class);
        // Retrieve all notifications, eager loading the associated users and ordering them by creation date

        $notifications = Notification::with("users")->orderBy("created_at", "desc");
        // Apply a filter based on the notification search request if provided in the request

        if ($request->has('type') && $request->type) {
            (new search('type', $request->type))->apply($notifications);
        }

        if ($request->has('target') && $request->target) {
            (new search('destination', $request->target))->apply($notifications);
        }

        if ($request->has('expiration') && $request->expiration) {
            (new search('expiration', $request->expiration))->apply($notifications);
        }
        // Paginate the filtered notifications, showing 10 per page

        $notifications = $notifications->paginate(10);

        return view("admin.notifications-list", compact("notifications"));
    }

}
