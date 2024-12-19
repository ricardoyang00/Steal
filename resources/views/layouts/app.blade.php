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
        <link href="{{ url('css/seller/seller_page.css') }}" rel="stylesheet">
        <link href="{{ url('css/seller/new_game.css') }}" rel="stylesheet">
        <link href="{{ url('css/seller/add_cdks.css') }}" rel="stylesheet">
        <link href="{{ url('css/seller/purchase_history.css') }}" rel="stylesheet">
        <link href="{{ url('css/purchase_history.css') }}" rel="stylesheet">
        <link href="{{ url('css/static_info.css') }}" rel="stylesheet">
        <link href="{{ url('css/game_details.css') }}" rel="stylesheet">
        <link href="{{ url('css/admin/manage_users.css') }}" rel="stylesheet">
        <link href="{{ url('css/admin/manage_game_fields.css') }}" rel="stylesheet">
        <link href="{{ url('css/admin/blocked_games.css') }}" rel="stylesheet">
        <link href="{{ url('css/shopping_cart.css') }}" rel="stylesheet">
        <link href="{{ url('css/home_page.css') }}" rel="stylesheet">
        <link href="{{ url('css/wishlist.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/notifications.css') }}" rel="stylesheet">
        <link href="{{ url('css/forgot_password.css') }}" rel="stylesheet">
        <link href="{{ url('css/password_reset.css') }}" rel="stylesheet">
        <link href="{{ url('css/modal.css') }}" rel="stylesheet">
        <link href="{{ url('css/scoins.css') }}" rel="stylesheet">
        <link href="{{ url('css/select_payment_method.css') }}" rel="stylesheet">
        <link href="{{ url('css/order_completed.css') }}" rel="stylesheet">
        <link href="{{ url('css/orderHistory.css') }}" rel="stylesheet">
        <link href="{{ url('css/orderDetails.css') }}" rel="stylesheet">
        <link href="{{ url('css/age_info.css') }}" rel="stylesheet">

        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
        @if (auth_user())
            <script src="{{ asset('js/notifications/notifications.js') }}" defer></script>
            @if (auth_user()->buyer)
                <script src="{{ asset('js/wishlist/wishlist_count.js') }}" defer></script>
            @endif
        @endif
    </head>
    <body>
        <main>
            @if (session('success'))
                <div class="alert alert-success notification-popup">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error notification-popup">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="header-navbar-container">
                <header>
                    <h1>
                        <a href="{{ url('/home') }}">
                            <img src="{{ asset('images/logo.svg') }}" alt="Steal!" class="logo-icon">
                        </a>
                    </h1>
                    @if (auth_user())
                        <div class="profile-buttons">
                            @if (auth_user()->buyer)
                                <a class="button" id="scoins" href="{{ url('/scoins') }}"><i class="fa-solid fa-coins"></i> <strong>{{ auth_user()->buyer->coins }}</strong></a>
                            @endif
                            
                            <div class="dropdown">
                                <a class="profile-link" href="{{ url('/profile') }}" role="button" id="profileDropdown">
                                    <i class="fas fa-user"></i> <span><strong>{{ auth_user()->username }}</strong></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="{{ url('/profile') }}">View Profile</a>
                                    @if (is_admin())
                                        <a class="dropdown-item" href="{{ url('/register') }}">Create Accounts</a>
                                        <a class="dropdown-item" href="{{ route('admin.users.search') }}">Manage Users</a>
                                        <a class="dropdown-item" href="{{ route('admin.indexGameField') }}">Manage Game Fields</a>
                                        <a class="dropdown-item" href="{{ route('admin.games.blocked-games') }}">Manage Blocked Games</a>
                                        <a class="dropdown-item" href="{{ route('admin.salesReport') }}">Sales Report</a>
                                    @endif
                                    @if (auth_user()->seller)
                                        <a class="dropdown-item" href="{{ url('/seller/products') }}">My Products</a>
                                    @endif
                                    @if (auth_user()->buyer)
                                        <a class="dropdown-item" href="{{ route('purchaseHistory', ['id' => auth_user()->id]) }}">My Orders</a>
                                    @endif
                                    <a class="dropdown-item" id="logout" href="{{ url('/logout') }}">Logout</a>
                                </div>
                            </div>

                            @if (auth_user()->buyer)
                                <a class="icon-button" href="{{ url('/cart') }}">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span id="cart-count" class="badge"></span>
                                </a>
                            @endif
                            @if (auth_user()->buyer || auth_user()->seller)
                                <a class="icon-button" href="{{ url('/notifications') }}">
                                    <i class="fas fa-bell"></i>
                                    <span id="notification-count" class="badge"></span>
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="auth-buttons">
                            <a class="button" href="{{ url('/login') }}">Login</a>
                            <a class="button" href="{{ url('/register') }}">Sign Up</a>
                            <a class="icon-button" href="{{ url('/cart') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span id="cart-count" class="badge"></span>
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
                    @if (auth_user() && auth_user()->buyer)
                        <div class="wishlist">
                            <a class="btn btn-link {{ request()->is('wishlist') ? 'active' : '' }}" href="{{ url('/wishlist') }}">
                                <div>Wishlist</div>
                                <div id="w_count_div"><span id="wishlist-count" class="badge" style="display: none;"></span></div>
                            </a>
                        </div>
                    @endif
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