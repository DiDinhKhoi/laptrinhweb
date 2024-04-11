<!DOCTYPE html>
<html>
<head>
    <title>CRUD User Group A</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/scripts.js') }}"></script>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg mb-1" style="background-color: #81a1b8;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ml-auto" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logOut') }}">Logout</a>
                    </li>
                    @php
                    if(Auth::check()) {
                    $user = Auth::user();
                    }
                    @endphp
                    <li class="nav-item">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle"
                            href="{{ route('user.show',['id' => $user->id]) }}" role="button" data-bs-toggle="dropdown"
                            v-pre>
                            {{ Auth::user()->name }}
                        </a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</body>

</html>