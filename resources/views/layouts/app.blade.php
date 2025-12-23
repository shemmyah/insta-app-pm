<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Modern App Styles */
        body {
            background: #000;
            min-height: 100vh;
        }

        /* Container styling */
        .pagination {
            gap: 8px;
            margin-top: 20px;
        }

        /* Base link styling */
        .page-link {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: rgba(255, 255, 255, 0.6) !important;
            border-radius: 10px !important;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        /* Hover state */
        .page-link:hover {
            background: rgba(102, 126, 234, 0.2) !important;
            color: #fff !important;
            border-color: #667eea !important;
            transform: translateY(-2px);
        }

        /* Active page styling */
        .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
            border: none !important;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        /* Disabled state */
        .page-item.disabled .page-link {
            background: rgba(255, 255, 255, 0.02) !important;
            color: rgba(255, 255, 255, 0.2) !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        /* Modern Navbar */
        .navbar-modern {
            background: rgba(10, 10, 10, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 12px 0;
        }

        /* Logo Styles */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .logo-container:hover {
            transform: translateY(-2px);
        }

        .ig-logo-icon {
            font-size: 32px;
            line-height: 1;
            background: radial-gradient(circle at 30% 30%, #ffdc80, transparent 45%),
                radial-gradient(circle at 70% 30%, #fcaf45, transparent 40%),
                radial-gradient(circle at 30% 70%, #f77737, transparent 40%),
                radial-gradient(circle at 70% 70%, #833ab4, transparent 45%),
                linear-gradient(135deg, #f56040, #833ab4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            filter: drop-shadow(0 4px 12px rgba(131, 58, 180, 0.4));
            transition: filter 0.3s ease;
        }

        .logo-container:hover .ig-logo-icon {
            filter: drop-shadow(0 6px 16px rgba(131, 58, 180, 0.6));
        }

        .ig-logo-text {
            font-family: 'Great Vibes', cursive;
            font-size: 28px;
            color: #fff;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        /* Nav Icons */
        .nav-icon-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-icon-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(102, 126, 234, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }

        .nav-icon-btn:hover::before {
            width: 100%;
            height: 100%;
        }

        .nav-icon-btn:hover {
            background: rgba(102, 126, 234, 0.15);
            border-color: rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
        }

        .nav-icon-btn i {
            position: relative;
            z-index: 1;
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .nav-icon-btn:hover i {
            color: #fff;
            transform: scale(1.1);
        }

        /* Avatar in Nav */
        .nav-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-avatar:hover {
            border-color: rgba(102, 126, 234, 0.6);
            transform: scale(1.05);
        }

        /* Dropdown Menu */
        .dropdown-menu-modern {
            background: rgba(15, 15, 15, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 8px;
            margin-top: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            min-width: 200px;
        }

        .dropdown-item-modern {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .dropdown-item-modern i {
            width: 30px;
            color: rgba(255, 255, 255, 0.6);
            transition: color 0.2s ease;
        }

        .dropdown-item-modern:hover {
            background: rgba(102, 126, 234, 0.15);
            color: #fff;
        }

        .dropdown-item-modern:hover i {
            color: #667eea;
        }

        .dropdown-divider-modern {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 6px 0;
        }

        /* Admin Sidebar */
        .admin-sidebar-modern {
            background: rgba(10, 10, 10, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 8px;
            position: sticky;
            top: 80px;
        }

        .admin-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 4px;
        }

        .admin-menu-item i {
            width: 20px;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .admin-menu-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            transform: translateX(4px);
        }

        .admin-menu-item:hover i {
            color: #667eea;
        }

        .admin-menu-item.active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
            border: 1px solid rgba(102, 126, 234, 0.3);
            color: #fff;
        }

        .admin-menu-item.active i {
            color: #667eea;
        }

        /* Search Modal */
        .modal-modern {
            backdrop-filter: blur(10px);
        }

        .modal-content-modern {
            background: rgba(15, 15, 15, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            color: #fff;
        }

        .modal-header-modern {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
        }

        .modal-title-modern {
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-close-modern {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            opacity: 1;
            width: 32px;
            height: 32px;
            padding: 0;
            transition: all 0.2s ease;
        }

        .btn-close-modern:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }

        .modal-body-modern {
            padding: 20px;
        }

        .search-input-modern {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 14px 16px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input-modern:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(102, 126, 234, 0.5);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-input-modern::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .btn-search-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-search-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        /* Main Content Area */
        .main-content-modern {
            padding: 24px 0;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .ig-logo-text {
                display: none;
            }

            .ig-logo-icon {
                font-size: 28px;
            }

            .nav-icon-btn {
                width: 40px;
                height: 40px;
            }

            .nav-icon-btn i {
                font-size: 16px;
            }

            .admin-sidebar-modern {
                margin-bottom: 20px;
            }
        }

        /* Badge Inside Icon Styling */
        .badge-nav-overlay {
            position: absolute;
            top: 8px;
            /* Adjusted to sit near the top-right of the inner icon */
            right: 8px;
            background: #ff3b30;
            /* Vibrant red */
            color: white;
            font-size: 9px;
            /* Smaller font to fit inside */
            font-weight: 800;
            min-width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid rgba(10, 10, 10, 0.95);
            /* Matches navbar bg to create a gap */
            z-index: 2;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Ensure the parent can contain the absolute badge */
        .nav-icon-btn {
            position: relative;
            overflow: visible !important;
            /* Allow badge to pop slightly if needed */
        }
    </style>
</head>

<body>
    <div id="app">
        {{-- Modern Navbar --}}
        @if (!View::hasSection('hideNavbar'))
            <nav class="navbar navbar-expand-md navbar-dark navbar-modern shadow-sm">
                <div class="container">
                    <a class="logo-container" href="{{ url('/') }}">
                        <i class="fa-brands fa-instagram ig-logo-icon"></i>
                        <span class="ig-logo-text">Instagram</span>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto align-items-center" style="gap: 8px;">
                            @auth
                                @if (!request()->is('admin/*'))
                                    {{-- Search --}}
                                    <li class="nav-item">
                                        <button class="nav-icon-btn" data-bs-toggle="modal" data-bs-target="#searchModal"
                                            title="Search">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </li>
                                @endif
                            @endauth

                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('login', ['mode' => 'register']) }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                {{-- Home --}}
                                <li class="nav-item">
                                    <a href="{{ route('index') }}" class="nav-icon-btn text-decoration-none"
                                        title="Home">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>

                                {{-- Message --}}
                                {{-- Message --}}
                                <li class="nav-item">
                                    <a href="{{ route('messages.index') }}" class="nav-icon-btn text-decoration-none"
                                        title="Messages">
                                        <i class="fa-solid fa-message"></i>
                                        @php
                                            $unreadCount = auth()
                                                ->user()
                                                ->unreadNotifications->where(
                                                    'type',
                                                    'App\Notifications\NewMessageNotification',
                                                )
                                                ->count();
                                        @endphp

                                        @if ($unreadCount > 0)
                                            <span class="badge-nav-overlay">
                                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                            </span>
                                        @endif
                                    </a>
                                </li>


                                {{-- Create Post --}}
                                <li class="nav-item">
                                    <a href="{{ route('post.create') }}" class="nav-icon-btn text-decoration-none"
                                        title="Create Post">
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </a>
                                </li>

                                {{-- Account --}}
                                <li class="nav-item dropdown">
                                    <button id="account-dropdown" class="btn shadow-none p-0" data-bs-toggle="dropdown">
                                        @if (Auth::user()->avatar)
                                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                                class="nav-avatar">
                                        @else
                                            <div class="nav-icon-btn">
                                                <i class="fa-solid fa-circle-user"></i>
                                            </div>
                                        @endif
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-modern"
                                        aria-labelledby="account-dropdown">
                                        @can('admin')
                                            <a href="{{ route('admin.users') }}" class="dropdown-item-modern">
                                                <i class="fa-solid fa-user-gear fs-4"></i>
                                                <span>Admin</span>
                                            </a>
                                            <div class="dropdown-divider-modern"></div>
                                        @endcan

                                        <a href="{{ route('profile.show', Auth::user()->id) }}"
                                            class="dropdown-item-modern">
                                            <i class="fa-solid fa-circle-user fs-4"></i>
                                            <span>Profile</span>
                                        </a>

                                        <a class="dropdown-item-modern" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa-solid fa-right-from-bracket fs-3"></i>
                                            <span>{{ __('Logout') }}</span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endif

        {{-- Main Content --}}
        <main class="main-content-modern">
            <div class="container">
                <div class="row justify-content-center">
                    {{-- Admin Sidebar --}}
                    @if (request()->is('admin/*'))
                        <div class="col-lg-3 col-md-4 mb-4">
                            <div class="admin-sidebar-modern">
                                <a href="{{ route('admin.users') }}"
                                    class="admin-menu-item {{ request()->is('admin/users') ? 'active' : '' }}">
                                    <i class="fa-solid fa-users"></i>
                                    <span>Users</span>
                                </a>
                                <a href="{{ route('admin.posts') }}"
                                    class="admin-menu-item {{ request()->is('admin/posts') ? 'active' : '' }}">
                                    <i class="fa-solid fa-newspaper"></i>
                                    <span>Posts</span>
                                </a>
                                <a href="{{ route('admin.categories') }}"
                                    class="admin-menu-item {{ request()->is('admin/categories') ? 'active' : '' }}">
                                    <i class="fa-solid fa-tags"></i>
                                    <span>Categories</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Main Content Column --}}
                    <div class="{{ request()->is('admin/*') ? 'col-lg-9 col-md-8' : 'col-12' }}">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Search Modal --}}
    <div class="modal fade modal-modern" id="searchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <div class="modal-header modal-header-modern border-0">
                    <h6 class="modal-title-modern">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <circle cx="11" cy="11" r="8" stroke-width="2" />
                            <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        Discover People
                    </h6>
                    <button type="button" class="btn-close btn-close-white btn-close-modern"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modal-body-modern">
                    <form action="{{ route('search') }}" method="GET">
                        <input type="search" name="search" class="form-control search-input-modern mb-3"
                            placeholder="Search users...">
                        <button type="submit" class="btn btn-search-modern w-100">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" style="margin-right: 8px;">
                                <circle cx="11" cy="11" r="8" stroke-width="2" />
                                <path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
