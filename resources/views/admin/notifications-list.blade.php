@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Notifications List</h1>

    <!-- Filter Section -->
    <form action="{{ route('admin.notifications.list') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control">
                    <option value="">All</option>
                    <option value="marketing" {{ request('type') == 'marketing' ? 'selected' : ''}} >Marketing</option>
                    <option value="invoices" {{ request('type') == 'invoices' ? 'selected' : ''}} >Invoices</option>
                    <option value="system" {{ request('type') == 'system' ? 'selected' : ''}} >System</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="target">Target</label>
                <select id="target" name="target" class="form-control">
                    <option value="">All</option>
                    <option value="all" {{ request('target') == 'all' ? 'selected' : '' }}>All Users</option>
                    <option value="specific" {{ request('target') == 'specific' ? 'selected' : ''}}>Specific Users</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="expiration">Expiration</label>
                <input id="expiration" name="expiration" type="date" class="form-control" value="{{ request('expiration') }}">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <!-- Notifications Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Short Text</th>
                <th>Expiration</th>
                <th>Target</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $notification)
                <tr>
                    <td>{{ $notification->type }}</td>
                    <td>{{ $notification->text }}</td>
                    <td>{{ $notification->expiration ? \Carbon\Carbon::parse($notification->expiration)->format('Y-m-d') : 'No Expiration' }}</td>
                    <td>
                        @if ($notification->destination == 'all')
                            All Users
                        @else
                            <select class="form-control" multiple disabled>
                                @foreach($notification->users as $user)
                                    <option>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="justify-content-center">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
