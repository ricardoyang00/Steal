<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
        <main>
            <header>
                <h1>
                    <a href="{{ url('/home') }}">
                        <img src="{{ asset('images/logo.svg') }}" alt="Steal!" /*style="filter: invert(1) brightness(100%);"*/>
                    </a>
                </h1>
                @if (Auth::check() || Auth::guard('admin')->check())
                    <div class="profile">
                        @if (is_admin())
                            <a class="button" href="{{ route('admin.users.search') }}">Manage Users</a>
                        @endif
                        <a class="button" href="{{ url('/logout') }}"> Logout </a>
                        <a class="profile-link" href="{{ url('/profile') }}">
                            <i class="fas fa-user"></i> <span>{{ auth_user()->username }}</span>
                        </a>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a class="button" href="{{ url('/login') }}">Login</a>
                        <a class="button" href="{{ url('/register') }}">Sign Up</a>
                    </div>
                @endif
            </header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <a class="btn btn-link" href="{{ url('/home') }}">Home</a>
                        <a class="btn btn-link" href="{{ url('/explore') }}">Explore</a>
                        <a class="btn btn-link" href="#help-footer">Help</a>
                    </div>

                    <form action="{{ url('/explore') }}" method="GET" class="d-flex">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search Games..." aria-label="Search" value="{{ request('query') }}">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
            </nav>
            <section id="content">
                @yield('content')
            </section>
        </main>
    </body>
    <footer id="help-footer" class="bg-light py-5">
        <div class="container text-center">
            <h2>HELP</h2>
            <div class="d-flex flex-column align-items-center">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('/contact') }}" class="btn btn-link">Contact</a></li>
                    <li class="list-group-item"><a href="{{ url('/faqs') }}" class="btn btn-link">FAQs</a></li>
                    <li class="list-group-item"><a href="{{ url('/about') }}" class="btn btn-link">About</a></li>
                </ul>
            </div>
        </div>
    </footer>
</html>