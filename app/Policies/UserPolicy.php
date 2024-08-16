<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    // Determine if the authenticated user can edit the settings
    public function edit(User $authUser, User $user)
    {
        return $authUser->user_type === 'admin' || $authUser->id === $user->id;
    }

    // Determine if the authenticated user can impersonate another user
    public function impersonate(User $authUser, User $user)
    {
        return $authUser->user_type === 'admin';
    }

    public function post(User $user)
    {
        return $user->user_type === 'admin'; // Only admins can create notifications
    }
}
