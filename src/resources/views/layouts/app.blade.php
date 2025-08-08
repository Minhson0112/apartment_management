@php
    use App\Enums\UserRole;

    $isAdmin = Auth::user()->role === UserRole::ADMIN->value;
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Link CSS -->
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <nav>
                <ul>
                    @if($isAdmin)
                        <li>
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <img src="{{ asset('images/dashboard.png') }}" alt="dashboard" class="menu-icon">
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('apartment') }}" class="{{ request()->routeIs('apartment') ? 'active' : '' }}">
                            <img src="{{ asset('images/apartment.png') }}" alt="apartment" class="menu-icon">
                            <span class="menu-text">Căn Hộ</span>
                        </a>
                    </li>
                    @if($isAdmin)
                        <li>
                            <a href="{{ route('owner') }}" class="{{ request()->routeIs('owner') ? 'active' : '' }}">
                                <img src="{{ asset('images/owner.png') }}" alt="owner" class="menu-icon">
                                <span class="menu-text">Chủ Nhà</span>
                            </a>
                        </li>
                    @endif
                    <!-- Thêm các mục khác tương tự -->
                </ul>
            </nav>
        </aside>

        <!-- Main area -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="user-info">
                    Xin chào, <strong>{{ Auth::user()->full_name }}</strong>
                </div>
                <div class="logout-btn">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Đăng xuất</button>
                    </form>
                </div>
            </header>

            <!-- Dynamic content -->
            <section class="content">
                @yield('content')
            </section>
        </div>
    </div>
</body>
</html>
