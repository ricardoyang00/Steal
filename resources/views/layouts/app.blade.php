<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('images/icon.svg') }}" type="image/svg+xml">

        <!-- Styles -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/register_login.css') }}" rel="stylesheet">
        <link href="{{ url('css/explore_page.css') }}" rel="stylesheet">
        <link href="{{ url('css/game_details.css') }}" rel="stylesheet">
        <link href="{{ url('css/admin/manage_users.css') }}" rel="stylesheet">
        <link href="{{ url('css/shopping_cart.css') }}" rel="stylesheet">
        <link href="{{ url('css/wishlist.css') }}" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
        <main>
            <div class="header-navbar-container">
                <header>
                    <h1>
                        <a href="{{ url('/home') }}">
                            <img src="{{ asset('images/logo.svg') }}" alt="Steal!" class="logo-icon">
                        </a>
                    </h1>
                    @if (auth_user())
                        <div class="profile-buttons">
                            @if (is_admin())
                                <a class="button" href="{{ url('/register') }}">Create Account</a>
                                <a class="button" href="{{ route('admin.users.search') }}">Manage Users</a>
                            @endif
                            <a class="button" href="{{ url('/logout') }}"> Logout </a>
                            <a class="profile-link" href="{{ url('/profile') }}">
                                <i class="fas fa-user"></i> <span>{{ auth_user()->username }}</span>
                            </a>
                            @if (auth_user()->buyer)
                                <a class="icon-button" href="{{ url('/cart') }}">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a class="icon-button" href="{{ route('purchaseHistory', ['id' => auth_user()->id]) }}">
                                    <i class="fas fa-wallet"></i>
                                </a>
                            @endif
                            <a class="icon-button">
                                <i class="fa-regular fa-bell"></i>
                            </a>
                        </div>
                    @else
                        <div class="auth-buttons">
                            <a class="button" href="{{ url('/login') }}">Login</a>
                            <a class="button" href="{{ url('/register') }}">Sign Up</a>
                            <a class="icon-button" href="{{ url('/cart') }}">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                            <a class="icon-button">
                                <i class="fa-regular fa-bell"></i>
                            </a>
                        </div>
                    @endif
                </header>
                <nav class="navbar">
                    <div class="links">
                        <a class="btn btn-link {{ request()->is('home') ? 'active' : '' }}" href="{{ url('/home') }}">Home</a>
                        <a class="btn btn-link {{ request()->is('explore') ? 'active' : '' }}" href="{{ url('/explore?sort=all') }}">Explore</a>
                        <a class="btn btn-link" href="#help" onclick="scrollToSection(event, 'help')">Help</a>
                    </div>

                    <div class="search-container">
                        <form action="{{ url('/explore') }}" method="GET" class="d-flex">
                            <button class="btn-outline-primary" type="submit">
                                <i class="fas fa-search search-icon"></i>
                            </button>
                            <input class="form-control" type="search" name="query" placeholder="Search games..." aria-label="Search" value="{{ request('query') }}">
                        </form>
                    </div>

                    <div class="wishlist">
                        <a class="btn btn-link" href="{{ url('/wishlist') }}">
                            Wishlist
                        </a>
                    </div>
                </nav>
            </div>
            <section id="content">
                @yield('content')
            </section>
        </main>
    </body>
    <footer id="help">
        <div class="container text-center">
            <h2>HELP</h2>
            <div class="d-flex flex-column align-items-center">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('/contact') }}" class="btn btn-link">Contact Us</a></li>
                    <li class="list-group-item"><a href="{{ url('/faqs') }}" class="btn btn-link">FAQs</a></li>
                    <li class="list-group-item"><a href="{{ url('/about') }}" class="btn btn-link">About</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; Copyright {{ date('Y') }} Steal! All rights reserved.
        </div>
    </footer>
</html>