<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Admin Dashboard')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 20px;
        }

        .menu-item {
            transition: all 0.2s ease;
        }

        .menu-item:hover {
            transform: translateX(4px);
        }

        .active-menu {
            background: linear-gradient(to right, #2563eb, #3b82f6);
            color: white;
            box-shadow: 0 4px 10px rgba(59,130,246,.3);
        }

        .card-dashboard {
            transition: all .25s ease;
        }

        .card-dashboard:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
        }
    </style>
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-slate-900 text-white flex flex-col shadow-2xl">

        <!-- LOGO -->
        <div class="px-7 py-7 border-b border-slate-800">

            <div class="flex items-center gap-3">

                <div class="bg-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg">

                    <i class="bi bi-shop text-2xl"></i>

                </div>

                <div>

                    <h1 class="text-2xl font-bold leading-none">
                        MediaBook
                    </h1>

                    <p class="text-slate-400 text-sm mt-1">
                        Admin Panel
                    </p>

                </div>

            </div>

        </div>

        <!-- USER -->
        <div class="px-6 py-5 border-b border-slate-800">

            <div class="flex items-center gap-4">

                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-xl font-bold">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

                <div>

                    <h4 class="font-semibold">
                        {{ auth()->user()->name }}
                    </h4>

                    <p class="text-slate-400 text-sm">
                        Administrator
                    </p>

                </div>

            </div>

        </div>

        <!-- MENU -->
        <nav class="flex-1 px-4 py-5 overflow-y-auto sidebar-scroll">

            <p class="text-slate-500 text-xs uppercase tracking-widest px-3 mb-3">
                Main Menu
            </p>

            <div class="space-y-2">

                <!-- DASHBOARD -->
                <a href="{{ route('admin.dashboard') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.dashboard') ? 'active-menu' : 'hover:bg-slate-800' }}">

                    <i class="bi bi-grid-fill"></i>

                    <span>
                        Dashboard
                    </span>

                </a>

                <!-- CATEGORY -->
                <a href="{{ route('admin.categories.index') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.categories.*') ? 'active-menu' : 'hover:bg-slate-800' }}">

                    <i class="bi bi-tags-fill"></i>

                    <span>
                        Categories
                    </span>

                </a>

                <!-- PRODUCT -->
                <a href="{{ route('admin.products.index') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.products.*') ? 'active-menu' : 'hover:bg-slate-800' }}">

                    <i class="bi bi-box-seam-fill"></i>

                    <span>
                        Products
                    </span>

                </a>

            </div>

            <!-- STOCK -->
            <p class="text-slate-500 text-xs uppercase tracking-widest px-3 mt-8 mb-3">
                Inventory
            </p>

            <div class="space-y-2">

                <!-- STOCK IN -->
                <a href="{{ route('admin.stock-ins.index') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.stock-ins.*') ? 'active-menu' : 'hover:bg-slate-800' }}">

                    <i class="bi bi-box-arrow-in-down"></i>

                    <span>
                        Stock In
                    </span>

                </a>

                <!-- STOCK OUT -->
                <a href="{{ route('admin.stock-outs.index') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.stock-outs.*') ? 'active-menu' : 'hover:bg-slate-800' }}">

                    <i class="bi bi-box-arrow-up"></i>

                    <span>
                        Stock Out
                    </span>

                </a>

            </div>

            <!-- TRANSACTION -->
            <p class="text-slate-500 text-xs uppercase tracking-widest px-3 mt-8 mb-3">
                Transaction
            </p>

            <div class="space-y-2">

                <!-- ORDERS -->
                <a href="{{ route('admin.orders.index') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.orders.*') ? 'active-menu' : 'hover:bg-slate-800' }}">

                    <i class="bi bi-cart-check-fill"></i>

                    <span>
                        Orders
                    </span>

                </a>

            </div>

            <!-- REPORT -->
            <p class="text-slate-500 text-xs uppercase tracking-widest px-3 mt-8 mb-3">
                Reports
            </p>

            <div class="space-y-2">

                <!-- STOCK REPORT -->
                <a href="{{ route('admin.reports.stock') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.reports.stock') ? 'active-menu' : 'hover:bg-slate-800' }}">

                    <i class="bi bi-bar-chart-fill"></i>

                    <span>
                        Stock Report
                    </span>

                </a>

                <!-- SALES REPORT -->
                <a href="{{ route('admin.reports.sales') }}"
                   class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.reports.sales') ? 'active-menu' : 'hover:bg-slate-800' }}">

                    <i class="bi bi-graph-up-arrow"></i>

                    <span>
                        Sales Report
                    </span>

                </a>

            </div>

        </nav>

        <!-- BOTTOM -->
        <div class="p-4 border-t border-slate-800">

            <form action="{{ route('logout') }}"
                  method="POST">

                @csrf

                <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 transition rounded-xl px-4 py-3 font-semibold">

                    <i class="bi bi-box-arrow-right"></i>
                    Logout

                </button>

            </form>

        </div>

    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white shadow-sm border-b border-slate-200 px-10 py-5">

            <div class="flex justify-between items-center">

                <div>

                    <h2 class="text-3xl font-bold text-slate-800">
                        @yield('title', 'Dashboard')
                    </h2>

                    <p class="text-slate-500 mt-1">
                        Selamat datang di panel administrator.
                    </p>

                </div>

                <div class="flex items-center gap-3">

                    <!-- HOME -->
                    <a href="{{ route('home') }}"
                       class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl transition">

                        <i class="bi bi-house-door-fill"></i>
                        Home

                    </a>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="p-8">

            @if(session('success'))

                <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl mb-6">

                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}

                </div>

            @endif

            @if(session('error'))

                <div class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl mb-6">

                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}

                </div>

            @endif

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>
