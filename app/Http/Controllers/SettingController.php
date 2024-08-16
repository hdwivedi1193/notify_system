<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SettingController extends Controller
{
    public function edit(User $user)
    {
        // Authorize that the user can edit settings
        $this->authorize("edit", $user);
        return view("settings.edit", compact("user"));
    }

    public function update(Request $request, User $user)
    {
        // Authorize that the user can update settings
        $this->authorize("edit", $user);

        // Validate the incoming request data

        $validator = $this->validate($request, [
            "email" => "required|email",
            "phone_number" => "nullable|phone:mobile",
            "phone_number_country" => 'required_with:phone_number',
            "notification_switch" => "nullable|boolean"
        ], [
            "phone_number.phone" => "Please provide valid phone number and extension"
        ]);

        // Update the user's settings
        $user->update([
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'notification_switch' => $request->notification_switch ?? false,
        ]);

        return redirect()->back()->with('success', 'Settings updated successfully.');


    }
}
