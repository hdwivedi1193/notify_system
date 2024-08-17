@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section("content")
<div class="container mt-4">
    <h1>Users</h1>
    <!-- Display Success Message -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!-- Filter Section -->
    <form action="{{ route('admin.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="emaail">Email</label>
                <input id="email" name="email" type="email" class="form-control" value="{{ request('email') }}" placeholder="Search User By Email">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Unread Notifications</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- <a href="{{ route('userNotifications', $user->id) }}">
                        </a> -->
                        {{ $user->unreadNotifications->count() }}

                    </td>
                    <td>
                        <a href="{{ route('settings.edit', $user->id) }}" class="btn btn-info">Edit</a>
                        <a href="{{ route('admin.impersonate', $user->id) }}" class="btn btn-warning">Impersonate</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection