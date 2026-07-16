@extends('layouts.guest')

@section('title', 'Register - MediaBook')

@section('content')

<style>
    body{
        background: linear-gradient(135deg, #f5f0e8, #e8e0d5);
        min-height: 100vh;
    }

    .register-wrapper{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
    }

    .register-card{
        width: 100%;
        max-width: 1000px;
        border-radius: 30px;
        overflow: hidden;
        background: white;
        box-shadow:
            0 20px 50px rgba(0,0,0,0.15);
    }

    .register-left{
        background:
            linear-gradient(rgba(139, 92, 246, 0.85), rgba(59, 130, 246, 0.85)),
            url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1200');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px;
        height: 100%;
    }

    .register-left h1{
        font-weight: 800;
        font-size: 2.5rem;
    }

    .register-left p{
        color: rgba(255,255,255,.85);
        margin-top: 20px;
        line-height: 1.8;
    }

    .register-right{
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

    .btn-register{
        height: 52px;
        border-radius: 14px;
        font-weight: 600;
        background: #0f172a;
        border: none;
    }

    .btn-register:hover{
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

        .register-left{
            display: none;
        }

        .register-right{
            padding: 40px 30px;
        }
    }

    .book-quote {
        font-style: italic;
        border-left: 3px solid rgba(255,255,255,0.4);
        padding-left: 15px;
        margin-top: 20px;
        font-size: 0.9rem;
    }
</style>

<div class="register-wrapper">

    <div class="register-card">

        <div class="row g-0">

            <!-- LEFT SIDE - BUKU THEME -->
            <div class="col-lg-6">

                <div class="register-left">

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
                                Pendaftaran aman & terpercaya
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

            <!-- RIGHT SIDE - FORM REGISTER -->
            <div class="col-lg-6">

                <div class="register-right">

                    <div class="mb-5">

                        <h2 class="fw-bold">
                            Daftar Akun Baru 📚
                        </h2>

                        <p class="text-muted mb-0">
                            Silahkan buat akun MediaBook Anda
                        </p>

                    </div>

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

                    <!-- FORM REGISTER -->
                    <form method="POST"
                          action="{{ route('register') }}">

                        @csrf

                        <!-- NAME -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Nama Lengkap
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control"
                                   placeholder="Masukkan nama lengkap Anda"
                                   required
                                   autofocus>

                        </div>

                        <!-- EMAIL -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control"
                                   placeholder="Masukkan email Anda"
                                   required>

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

                        <!-- CONFIRM PASSWORD -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Konfirmasi Password
                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   placeholder="Ulangi password"
                                   required>

                        </div>

                        <!-- BUTTON REGISTER -->
                        <button type="submit"
                                class="btn btn-primary btn-register w-100">

                            <i class="bi bi-person-plus me-2"></i>
                            Daftar Sekarang

                        </button>

                    </form>

                    <!-- LOGIN LINK -->
                    <div class="text-center mt-4">

                        <p class="text-muted mb-0">

                            Sudah punya akun?

                            <a href="{{ route('login') }}"
                               class="text-decoration-none fw-semibold"
                               style="color:#8b5cf6;">

                                Login

                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
