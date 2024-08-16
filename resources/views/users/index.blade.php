<!-- resources/views/profile.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-4">
@if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <!-- Profile Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <!-- Profile Icon -->
                    <img src="https://www.gravatar.com/avatar/16d8d90c4df3ae0c79a1d1c601d34675?s=128&d=identicon&r=PG&f=1" class="img-fluid rounded-circle mb-3" alt="Profile Icon">
                    <h3 class="card-title">{{ Auth::user()->name }}</h3>
                    <p class="card-text">{{ Auth::user()->email }}</p>
                    <p class="card-text">{{ Auth::user()->phone_number ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Notification Section -->
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Notification Icon with Counter -->
                <a href="{{ route('userNotifications',Auth::user()->id) }}" class="position-relative text-decoration-none">
                    <i class="bi bi-bell fs-3"></i>
                    @if(Auth::user()->unreadNotifications->count())
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ Auth::user()->unreadNotifications->count() }}
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    @endif
                </a>
                <!-- Profile Section -->
                <a href="{{ route('settings.edit',Auth::user()->id) }}" class="btn btn-primary">Edit Profile</a>
            </div>
            <!-- Additional Content -->
            <div class="card">
                <div class="card-body">
                    <!-- Add any additional profile-related content here -->
                    <h5 class="card-title">Additional Information</h5>
                    <p class="card-text">You can add more information about the user here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Optional: Include Bootstrap Icons if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
@endsection