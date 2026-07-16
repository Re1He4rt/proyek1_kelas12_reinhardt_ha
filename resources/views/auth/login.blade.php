@extends('layouts.guest')

@section('title', 'Login - MediaBook')

@section('content')

<style>
    body{
        background: linear-gradient(135deg, #f5f0e8, #e8e0d5);
        min-height: 100vh;
    }

    .login-wrapper{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
    }

    .login-card{
        width: 100%;
        max-width: 1000px;
        border-radius: 30px;
        overflow: hidden;
        background: white;
        box-shadow:
            0 20px 50px rgba(0,0,0,0.15);
    }

    .login-left{
        background:
            linear-gradient(rgba(139, 92, 246, 0.85), rgba(59, 130, 246, 0.85)),
            url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1200');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px;
        height: 100%;
    }

    .login-left h1{
        font-weight: 800;
        font-size: 2.5rem;
    }

    .login-left p{
        color: rgba(255,255,255,.85);
        margin-top: 20px;
        line-height: 1.8;
    }

    .login-right{
        padding: 60px;
    }

    .form-control{
        height: 52px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding-left: 16px;
    }

    .form-control:focus{
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139,92,246,.15);
    }

    .btn-login{
        height: 52px;
        border-radius: 14px;
        font-weight: 600;
        background: #0f172a;
        border: none;
    }

    .btn-login:hover{
        background: #8b5cf6;
    }

    .logo-circle{
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,.15);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
    }

    .feature-item{
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 18px;
    }

    .feature-icon{
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255,255,255,.15);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media(max-width: 991px){

        .login-left{
            display: none;
        }

        .login-right{
            padding: 40px 30px;
        }
    }

    /* Text styling for book theme */
    .book-quote {
        font-style: italic;
        border-left: 3px solid rgba(255,255,255,0.4);
        padding-left: 15px;
        margin-top: 20px;
        font-size: 0.9rem;
    }
</style>

<div class="login-wrapper">

    <div class="login-card">

        <div class="row g-0">

            <!-- LEFT SIDE - BUKU THEME -->
            <div class="col-lg-6">

                <div class="login-left">

                    <div class="logo-circle">
                        <i class="bi bi-book-fill fs-2"></i>
                    </div>

                    <h1>
                        Media<span style="font-weight:400">Book</span>
                    </h1>

                    <p>
                        Platform toko buku digital & fisik terpercaya dengan ribuan koleksi bacaan berkualitas dari berbagai penerbit ternama.
                    </p>

                    <div class="book-quote">
                        <i class="bi bi-quote"></i> Buku adalah jendela dunia, mari jelajahi bersama MediaBook.
                    </div>

                    <div class="mt-5">

                        <div class="feature-item">

                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                Login aman & terpercaya
                            </div>

                        </div>

                        <div class="feature-item">

                            <div class="feature-icon">
                                <i class="bi bi-truck"></i>
                            </div>

                            <div>
                                Pengiriman cepat ke seluruh Indonesia
                            </div>

                        </div>

                        <div class="feature-item">

                            <div class="feature-icon">
                                <i class="bi bi-patch-check-fill"></i>
                            </div>

                            <div>
                                Buku original 100% dari penerbit resmi
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT SIDE - FORM LOGIN (TIDAK BERUBAH) -->
            <div class="col-lg-6">

                <div class="login-right">

                    <div class="mb-5">

                        <h2 class="fw-bold">
                            Selamat Datang 👋
                        </h2>

                        <p class="text-muted mb-0">
                            Silahkan login ke akun MediaBook Anda
                        </p>

                    </div>

                    <!-- SESSION STATUS -->
                    @if(session('status'))

                        <div class="alert alert-success rounded-4">
                            {{ session('status') }}
                        </div>

                    @endif

                    <!-- VALIDATION ERRORS -->
                    @if($errors->any())

                        <div class="alert alert-danger rounded-4">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <!-- FORM LOGIN (TETAP SAMA, TIDAK BERUBAH) -->
                    <form method="POST"
                          action="{{ route('login') }}">

                        @csrf

                        <!-- EMAIL -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="Masukkan email Anda"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>

                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Password
                            </label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Masukkan password"
                                   required>

                        </div>

                        <!-- REMEMBER ME & FORGOT PASSWORD -->
                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div class="form-check">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="remember"
                                       id="remember_me">

                                <label class="form-check-label"
                                       for="remember_me">

                                    Remember me

                                </label>

                            </div>

                            @if (Route::has('password.request'))

                                <a href="{{ route('password.request') }}"
                                   class="text-decoration-none">

                                    Lupa password?

                                </a>

                            @endif

                        </div>

                        <!-- BUTTON LOGIN -->
                        <button type="submit"
                                class="btn btn-primary btn-login w-100">

                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Login

                        </button>

                    </form>

                    <!-- REGISTER LINK -->
                    <div class="text-center mt-4">

                        <p class="text-muted mb-0">

                            Belum punya akun?

                            <a href="{{ route('register') }}"
                               class="text-decoration-none fw-semibold"
                               style="color:#8b5cf6;">

                                Daftar Sekarang

                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
