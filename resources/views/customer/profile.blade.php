@extends('layouts.customer')

@section('title', 'Profile Saya')

@section('content')

<div class="container py-4">

    <!-- TITLE -->
    <div class="mb-4">

        <h2 class="fw-bold">
            Profile Saya
        </h2>

        <p class="text-muted">
            Kelola informasi akun Anda
        </p>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    <div class="row">

        <!-- PROFILE CARD -->
        <div class="col-lg-4 mb-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center p-4">

                    <div class="mb-3">

                        <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width:90px;height:90px;font-size:36px;background:#8b5cf6;">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                    </div>

                    <h4 class="fw-bold mb-1">
                        {{ auth()->user()->name }}
                    </h4>

                    <p class="text-muted mb-0">
                        {{ auth()->user()->email }}
                    </p>

                </div>

            </div>

        </div>

        <!-- FORM -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-person-fill me-2"></i>
                        Informasi Akun

                    </h5>

                </div>

                <div class="card-body p-4">

                    <form action="{{ route('customer.profile.update') }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <!-- NAME -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Nama Lengkap
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control rounded-3"
                                   value="{{ auth()->user()->name }}"
                                   required>

                        </div>

                        <!-- EMAIL -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control rounded-3"
                                   value="{{ auth()->user()->email }}"
                                   required>

                        </div>

                        <!-- ROLE -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Role
                            </label>

                            <input type="text"
                                   class="form-control rounded-3"
                                   value="{{ auth()->user()->role }}"
                                   disabled>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn rounded-3 px-4 py-2" style="background:#8b5cf6;color:#fff;">

                            <i class="bi bi-save-fill me-2"></i>
                            Simpan Perubahan

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection