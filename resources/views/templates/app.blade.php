<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growith Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f2;
            margin: 0;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 240px;
            background-color: #3b6140;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem 1rem;
        }

        .sidebar-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            font-weight: 700;
            font-size: 1.4rem;
            color: #f9fff9;
            margin-bottom: 2rem;
        }

        .sidebar-header i {
            font-size: 1.8rem;
            color: #cdeac0;
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #e9f7e9;
            background-color: transparent;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-links a .label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links a .badge {
            font-size: 0.75rem;
            background-color: #ffc107;
            color: #222;
            padding: 2px 8px;
            border-radius: 12px;
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .nav-links a.active {
            background-color: #a4c3a2;
            color: #2e4730;
            font-weight: 600;
        }

        .sidebar h3 {
            font-weight: 700;
            font-size: 1.6rem;
            margin-bottom: 2.5rem;
            color: #f9fff9;
        }

        .nav-links {
            width: 100%;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e9f7e9;
            padding: 10px 20px;
            border-radius: 10px;
            margin-bottom: 8px;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-links a i {
            font-size: 1.1rem;
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .nav-links a.active {
            background-color: #a4c3a2;
            color: #2e4730;
            font-weight: 600;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
        }

        .content {
            margin-left: 240px;
            padding: 2rem;
            flex: 1;
        }

        .topbar {
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .topbar h5 {
            margin: 0;
            font-weight: 600;
            color: #2e4730;
        }

        footer {
            text-align: center;
            padding: 10px;
            color: #555;
            font-size: 0.9rem;
            margin-top: auto;
            background-color: #fff;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <i class="fa-solid fa-leaf"></i>
                <h4 class="mb-0">Growith</h4>
            </div>

            <div class="nav-links">
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <span class="label"><i class="fa-solid fa-house"></i> Dashboard</span>
                    </a>

                    <div class="dropdown w-100">
                        <a class="dropdown-toggle label px-3 py-2 text-white text-decoration-none" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 10px;">
                            <i class="fa-solid fa-database"></i> Data Master
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark w-100">
                            <li><a class="dropdown-item" href="{{ route('admin.category.index') }}">Data Category</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('admin.product.index') }}">Data Produk</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Data Petugas</a></li>
                        </ul>
                    </div>
                @elseif(Auth::check() && Auth::user()->role == 'staff')
                    <a href="{{ route('staff.dashboard') }}"
                        class="{{ Request::is('staff/dashboard') ? 'active' : '' }}">
                        <span class="label"><i class="fa-solid fa-house"></i> Dashboard</span>
                    </a>
                    <a href="{{ route('staff.orders.index') }}">
                        <span class="label"><i class="fa-solid fa-calendar"></i> Kelola Pesanan</span>
                        <span class="badge">5</span>
                    </a>
                    <a href="{{ route('staff.promos.index') }}">
                        <span class="label"><i class="fa-solid fa-tag"></i> Promo</span>
                    </a>
                @else
                    <a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active' : '' }}">
                        <span class="label"><i class="fa-solid fa-house"></i> Home</span>
                    </a>
                    <a href="{{ route('home') }}#products">
                        <span class="label"><i class="fa-solid fa-shop"></i> Shop</span>
                    </a>
                    <a href="{{ route('orders.liked') }}">
                        <span class="label"><i class="fa-solid fa-heart"></i> Favorite</span>
                        @if ($favoriteCount > 0)
                            <span class="badge">{{ $favoriteCount }}</span>
                        @endif
                    </a>
                @endif

                @if (Auth::check())
                    <a href="{{ route('logout') }}">
                        <span class="label"><i class="fa-solid fa-right-from-bracket"></i> Logout</span>
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        <span class="label"><i class="fa-solid fa-right-to-bracket"></i> Login</span>
                    </a>
                    <a href="{{ route('signup') }}">
                        <span class="label"><i class="fa-solid fa-user-plus"></i> Sign Up</span>
                    </a>
                @endif
            </div>
        </div>

        {{-- User profile section --}}
        <div class="mt-auto text-center text-white small">
            <hr class="text-white">
            <div><strong>{{ Auth::user()->nama_lengkap ?? 'Guest' }}</strong></div>
            <div>{{ Auth::user()->email ?? '' }}</div>
        </div>
    </div>

    {{-- Main content --}}
    <div class="content">
        <div class="topbar">
            <h5>{{ $pageTitle ?? 'Dashboard' }}</h5>
        </div>

        <main>
            @yield('content')
        </main>
    </div>

    @if (session('alert'))
        <script>
            alert("{{ session('alert') }}");
        </script>
    @endif

    <!-- Scripts -->
     <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>

    {{--CDN chartJS--}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('script')
</body>

</html>
