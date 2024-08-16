@extends('layouts.app')

@section('title', 'Edit Settings')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h2>Edit Settings</h2>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Settings Form -->
        <form action="{{ route('settings.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone Field -->
            <label for="phone" class="form-label">Phone Number</label>

            <div class="mb-3">
                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                    name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Phone Extension Field -->
            <div class="mb-3">
                <input type="hidden" class="form-control" id="phone_extension" name="phone_number_country">

            </div>


            <!-- Notification Switch -->
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="notification_switch" name="notification_switch" {{ $user->notification_switch ? 'checked' : '' }}>
                <label class="form-check-label" for="notification_switch">Enable Notifications</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update Settings</button>
        </form>
    </div>
</div>
@endsection
@section('tel-script')

<script>

    $(document).ready(function () {
        var input = document.querySelector("#phone_number");
        var iti = window.intlTelInput(input, {
            initialCountry: "in",
            separateDialCode:true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });

        // If there's an old value (after validation failure), set it as the initial value
        var oldPhoneNumber = "{{ old('phone_number', $user->phone_number) }}";
        if (oldPhoneNumber) {
            iti.setNumber(oldPhoneNumber);
        }

        // Show error message if it exists
        var errorMessage = "{{ $errors->first('phone_number') }}";
        if (errorMessage) {
            $('.invalid-feedback').show();  // Ensure the error message is displayed
        }

        $('form').on('submit', function () {
            var extension = iti.getSelectedCountryData()["iso2"].toUpperCase(); // gets the country code
            $('#phone_extension').val(extension); // update input with formatted number
            
            // Set the checkbox value to 1 if checked, otherwise 0
            $('#notification_switch').val($('#notification_switch').is(':checked') ? 1 : 0);

        });

       


    });
</script>





@endsection