@extends('layouts.app')
@section('title', 'Post Notification')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Create Notification</h1>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Display Success Message -->
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.notifications.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select id="type" name="type" class="form-select" required>
                        <option value="marketing" {{ old('type') == 'marketing' ? 'selected' : ''}}>Marketing</option>
                        <option value="invoices" {{ old('type') == 'invoices' ? 'selected' : ''}}>Invoices</option>
                        <option value="system" {{ old('type') == 'system' ? 'selected' : ''}}>System</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="short_text" class="form-label">Short Text</label>
                    <textarea id="short_text" name="short_text" class="form-control" rows="3" required></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="expiration" class="form-label">Expiration</label>
                    <input id="expiration" name="expiration" type="date" class="form-control" value="{{old("expiration")}}" required min="{{date("Y-m-d")}}">
                </div>

                <div class="form-group mb-3">
                    <label for="target_type" class="form-label">Target Type</label>
                    <select id="target_type" name="target_type" class="form-select" required>
                        <option value="all">All</option>
                        <option value="specific">Specific</option>
                    </select>
                </div>

                <div class="form-group mb-3 d-none" id="target_users_group">
                    <label for="target_users" class="form-label">Target Users</label>
                    <select id="target_users" name="target_users[]" class="form-select" multiple>
                        <!-- Populate with users who have notifications switched on -->
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Create Notification</button>
                </div>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('target_type').addEventListener('change', function () {
        document.getElementById('target_users_group').classList.toggle('d-none', this.value !== 'specific');
        if(this.value=="specific"){
            $("#target_users").attr("required","required");
        }else{
            $("#target_users").removeAttr("required");

        }
    });
</script>
@endsection
@endsection