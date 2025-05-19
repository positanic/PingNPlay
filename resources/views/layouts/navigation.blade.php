<div class="" style="width: 100px; position: absolute; left: 50%; margin-left: -50px; margin-top: -20px; z-index: 1">
    <img class="" src="{{ asset('img/soccer-ball.png') }}" width="100px" /></a>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary ps-5 pe-5 mb-5">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse me-2 ms-2" id="navbarCollapse">
        <div class="navbar-nav">
            <a href="{{ route('calendar') }}" class="nav-item nav-link active">Calendar</a>
        </div>
    @if (Route::has('login'))
        <div class="navbar-nav ms-auto">
        @auth
            <div class="dropdown show">
                <a class="dropdown-toggle nav-item nav-link active" href="#" role="button" id="UserMenu" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{Auth::user()->name}}
                </a>

                <div class="dropdown-menu" aria-labelledby="UserMenu">
                    <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>

            <!-- <a href="#" class="nav-item nav-link">{{Auth::user()->name}}</a> -->
        @else
            <a href="{{ route('login') }}#" class="nav-item nav-link">Login</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
            @endif

        @endauth
        </div>
    @endif
    </div>
</nav>
