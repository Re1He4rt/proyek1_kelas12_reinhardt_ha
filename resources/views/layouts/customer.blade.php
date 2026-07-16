<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        body{
            background:#f5f7fb;
            font-family:'Segoe UI', sans-serif;
        }

        /* =======================
            NAVBAR
        ======================= */

        .navbar-custom{
            background:#ffffff;
            border-bottom:1px solid #e5e7eb;
            box-shadow:0 2px 10px rgba(0,0,0,.03);
        }

        .navbar-brand{
            font-weight:700;
            font-size:1.3rem;
            color:#111827 !important;
        }

        .nav-link{
            color:#4b5563 !important;
            font-weight:500;
            transition:.2s;
            position:relative;
        }

        .nav-link:hover{
            color:#2563eb !important;
        }

        .nav-active{
            color:#2563eb !important;
        }

        .nav-active::after{
            content:'';
            position:absolute;
            left:0;
            bottom:-6px;
            width:100%;
            height:2px;
            background:#2563eb;
            border-radius:20px;
        }

        /* =======================
            CART
        ======================= */

        .cart-icon{
            position:relative;
            font-size:1.3rem;
        }

        .cart-badge{
            position:absolute;
            top:-8px;
            right:-10px;
            font-size:.7rem;
        }

        /* =======================
            PROFILE
        ======================= */

        .profile-circle{
            width:42px;
            height:42px;
            border-radius:50%;
            border:none;
            background:#2563eb;
            color:white;
            font-size:1rem;
            display:flex;
            align-items:center;
            justify-content:center;
            transition:.2s;
        }

        .profile-circle:hover{
            background:#1d4ed8;
            transform:scale(1.05);
        }

        .dropdown-menu{
            width:240px;
            border:none;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
            padding:10px;
        }

        .dropdown-item{
            border-radius:10px;
            transition:.2s;
        }

        .dropdown-item:hover{
            background:#f3f4f6;
        }

        /* =======================
            CONTENT
        ======================= */

        .main-content{
            min-height:80vh;
        }

        /* =======================
            FOOTER
        ======================= */

        footer{
            background:#111827;
            color:white;
        }

        footer a{
            color:#d1d5db;
            text-decoration:none;
        }

        footer a:hover{
            color:white;
        }

        /* =======================
            MOBILE
        ======================= */

        @media(max-width:991px){

            .navbar-collapse{
                margin-top:15px;
                background:white;
                padding:15px;
                border-radius:14px;
            }

            .nav-active::after{
                display:none;
            }

            .nav-link{
                padding:10px 0;
            }

            .navbar-nav{
                gap:10px !important;
            }

            .mobile-right{
                margin-top:15px;
                justify-content:space-between;
            }
        }

        /* =======================
            MEDIABOOK LOGO
        ======================= */

        .mediabook-logo{
            text-decoration:none;
            display:flex;
            align-items:center;
            font-size:2rem;
            font-weight:900;
            letter-spacing:1px;
            line-height:1;
            transition:.3s ease;
        }

        .mediabook-logo:hover{
            transform:translateY(-1px);
        }

        /* Media */
        .logo-main{
            color:#2563eb;
            position:relative;
        }

        /* Book */
        .logo-accent{
            color:#111827;
            margin-left:2px;
        }

        /* UNDERLINE EFFECT */
        .logo-main::after{
            content:'';
            position:absolute;
            left:0;
            bottom:-7px;
            width:100%;
            height:4px;
            border-radius:999px;
            background:linear-gradient(
                90deg,
                #2563eb,
                #60a5fa
            );
        }

        /* HOVER GLOW */
        .mediabook-logo:hover .logo-main{
            text-shadow:
                0 0 10px rgba(37,99,235,.25),
                0 0 25px rgba(37,99,235,.15);
        }

        /* MOBILE */
        @media(max-width:768px){

            .mediabook-logo{
                font-size:1.7rem;
            }

        }

        .main-content .container{
            max-width:1320px;
        }

        .navbar-custom{
            overflow:visible !important;
        }

        .dropdown{
            position:relative;
        }

        .dropdown-menu{
            z-index:99999;
        }

        body{
            overflow-x:hidden;
        }

    </style>
</head>

<body>

<!-- =======================
    NAVBAR
======================= -->

<nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top">

    <div class="container">

        <!-- LOGO - MediaBook -->
        <a class="mediabook-logo" href="{{ route('home') }}">

            <span class="logo-main">
                Media
            </span>

            <span class="logo-accent">
                Book
            </span>

        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContent">

            <i class="bi bi-list fs-2"></i>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navbarContent">

            <!-- LEFT MENU -->
            <ul class="navbar-nav mx-auto gap-lg-4">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'nav-active' : '' }}"
                       href="{{ route('home') }}">

                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.shop.*') ? 'nav-active' : '' }}"
                       href="{{ route('customer.shop.index') }}">

                        Belanja
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'nav-active' : '' }}"
                       href="{{ route('customer.orders.index') }}">

                        Pesanan Saya
                    </a>
                </li>

            </ul>

            <!-- RIGHT MENU -->
            <div class="d-flex align-items-center gap-3 mobile-right">

                <!-- CART -->
                <a class="nav-link cart-icon {{ request()->routeIs('customer.cart.*') ? 'nav-active' : '' }}"
                   href="{{ route('customer.cart.index') }}">

                    <i class="bi bi-cart3"></i>

                    @php
                        $cartCount = auth()->check()
                            ? \App\Models\CartItem::whereHas('cart', function ($q) {
                                $q->where('user_id', auth()->id());
                            })->sum('qty')
                            : 0;
                    @endphp

                    @if($cartCount > 0)
                        <span class="badge bg-danger rounded-pill cart-badge">
                            {{ $cartCount }}
                        </span>
                    @endif

                </a>

                @auth

                <!-- PROFILE -->
                <div class="dropdown">

                    <button class="profile-circle"
                            type="button"
                            data-bs-toggle="dropdown">

                        <i class="bi bi-person-fill"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li class="px-3 py-2 border-bottom">
                            <small class="text-muted">
                                Login sebagai
                            </small>

                            <div class="fw-semibold">
                                {{ auth()->user()->name }}
                            </div>
                        </li>

                        <li>
                            <a class="dropdown-item py-2"
                               href="{{ route('customer.profile.index') }}">

                                <i class="bi bi-person me-2"></i>
                                Profil
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item py-2"
                               href="{{ route('customer.orders.index') }}">

                                <i class="bi bi-bag-check me-2"></i>
                                Pesanan Saya
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item py-2"
                               href="{{ route('customer.addresses.index') }}">

                                <i class="bi bi-geo-alt me-2"></i>
                                Alamat
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit"
                                        class="dropdown-item text-danger py-2">

                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>

                </div>

                @else

                    <a href="{{ route('login') }}"
                       class="btn btn-dark rounded-pill px-4">

                        Login
                    </a>

                @endauth

            </div>

        </div>

    </div>

</nav>

<!-- =======================
    CONTENT
======================= -->

<div class="main-content py-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

</div>

<!-- =======================
    FOOTER - MediaBook
======================= -->

<footer class="py-5 mt-5">

    <div class="container">

        <div class="row">

            <div class="col-md-4 mb-4">

                <h5 class="fw-bold">

                    <span class="text-primary">
                        Media
                    </span>Book

                </h5>
                <p class="text-light-emphasis">
                    Platform media buku digital & fisik terpercaya untuk pecinta bacaan.
                </p>

            </div>

            <div class="col-md-4 mb-4">

                <h6 class="fw-bold">
                    Menu
                </h6>

                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('customer.shop.index') }}">Belanja</a>
                    <a href="{{ route('customer.orders.index') }}">Pesanan</a>
                </div>

            </div>

            <div class="col-md-4 mb-4">

                <h6 class="fw-bold">
                    Kontak
                </h6>

                <p class="mb-1">
                    <i class="bi bi-envelope"></i>
                    info@mediabook.com
                </p>

                <p class="mb-1">
                    <i class="bi bi-telephone"></i>
                    0812-3456-7890
                </p>

            </div>

        </div>

        <hr class="border-secondary">

        <div class="text-center text-light-emphasis">
            © {{ date('Y') }} MediaBook. All rights reserved.
        </div>

    </div>

</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>
