<!-- resources/views/admin/view-user-notifications.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Notifications for {{ $user->name }}</h1>
        <i class="fa fa-bell" aria-hidden="true" style="font-size: 32px;"></i>
    </div>

    @if($user->unreadNotifications->isEmpty())
        <div class="alert alert-info" id="no-notifications">
            No unread notifications.
        </div>
    @else
        <div class="alert alert-info d-none" id="no-notifications">
        </div>
        <table class="table table-bordered table-striped" id="notifications-table">

            <thead class="thead-dark">
                <tr>
                    <th>Type</th>
                    <th>Text</th>
                    <th>Expiration</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->unreadNotifications as $notification)
                    <tr id="notification-{{ $notification->pivot->id }}">
                        <td>{{ $notification->type }}</td>
                        <td>{{ $notification->text }}</td>
                        <td>{{ \Carbon\Carbon::parse($notification->expiration)->format('Y-m-d') }}</td>
                        <td>
                            <span class="badge bage-pill badge-dark" style="color:red">Unread</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary mark-as-read" data-id="{{ $notification->id }}"
                                onclick="markAsRead({{$notification->pivot->id}},{{$notification->pivot->user_id}})">
                                Mark as Read
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

<script>
    async function markAsRead(notificationId, userId) {
        let options = {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Content-Type': 'application/json',
            },
        }
        let markAsRead = await fetch(`/users/${userId}/notifications/${notificationId}/mark-as-read`, options)
        let response = await markAsRead.json();
        // if failed to mark as read
        let alert = document.getElementById("no-notifications");
        if (response.status == 400) {
            alert.classList.remove("d-none") // show alert message
            alert.innerHTML = response.message
        }else{
            // Remove the notification row
            document.getElementById(`notification-${notificationId}`).remove();
            alert.classList.remove("d-none") // show alert message
            alert.innerHTML = response.message
        }
        setTimeout(() => {
                alert.classList.add("d-none")
            }, 2000)

    }
</script>