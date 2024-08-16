<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - My Laravel App</title>
    <!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css"/>

<!-- Bootstrap CSS (if not already included) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">My Laravel App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{auth()->user()->user_type=="admin"? route('admin.index'): route('individual.index') }}">DashBoard</a>
                        </li>
                        @if(auth()->user()->user_type==config('site.user.admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.notifications.create')}}">Post Notification</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('settings.edit', Auth::user()->id) }}">Settings</a>
                        </li>
                        @if (session("impersonate"))
                        <li class="nav-item">
                            <a class="nav-link" href="{{route("admin.stopImpersonate") }}">Stop Impersonation</a>
                        </li>    
                        @endif
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-auto py-3">
        <div class="container text-center">
            <span class="text-muted">&copy; 2024 My Laravel App. All rights reserved.</span>
        </div>
    </footer>
    <!-- jQuery (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- intl-tel-input JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    @yield("scripts")
    @yield('tel-script')
    <script>
        $('.alert-danger').delay(3000).fadeOut();
        $('.alert-success').delay(3000).fadeOut();
    </script>

</html>