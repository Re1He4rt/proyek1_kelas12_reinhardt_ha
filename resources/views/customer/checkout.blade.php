@extends('layouts.customer')

@section('title', 'Checkout')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('customer.shop.index') }}"
           class="text-decoration-none">

            Belanja

        </a>
    </li>

    <li class="breadcrumb-item">
        <a href="{{ route('customer.cart.index') }}"
           class="text-decoration-none">

            Keranjang

        </a>
    </li>

    <li class="breadcrumb-item active">
        Checkout
    </li>
@endsection

@section('content')

<style>

    .checkout-card{
        border:none;
        border-radius:28px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,.05);
    }

    .checkout-header{
        padding:18px 24px;
        font-weight:700;
        font-size:1rem;
    }

    .address-card{
        border:2px solid #edf2f7;
        border-radius:22px;
        transition:.25s ease;
        height:100%;
    }

    .address-card:hover{
        border-color:#2563eb;
        transform:translateY(-4px);
    }

    .form-check-input:checked{
        background-color:#2563eb;
        border-color:#2563eb;
    }

    .summary-item{
        padding:10px 0;
        border-bottom:1px dashed #e5e7eb;
    }

    .summary-item:last-child{
        border-bottom:none;
    }

    .modern-btn{
        border-radius:16px;
        padding:12px 20px;
        font-weight:600;
    }

    .info-box{
        background:#f8fafc;
        border-radius:22px;
        padding:24px;
    }

</style>

<div class="container py-4">

    <!-- TITLE -->
    <div class="row mb-4">

        <div class="col-md-12">

            <h2 class="fw-bold">
                <i class="bi bi-credit-card me-2"></i>
                Checkout
            </h2>

        </div>

    </div>

    <!-- PROGRESS -->
    <div class="row mb-4">

        <div class="col-md-12">

            <div class="card checkout-card">

                <div class="card-body py-4">

                    <div class="d-flex justify-content-between text-center">

                        <div>
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                ✓
                            </span>

                            <div class="small mt-2">
                                Keranjang
                            </div>
                        </div>

                        <div>
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                2
                            </span>

                            <div class="small mt-2 fw-semibold">
                                Checkout
                            </div>
                        </div>

                        <div>
                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                3
                            </span>

                            <div class="small mt-2">
                                Pembayaran
                            </div>
                        </div>

                        <div>
                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                4
                            </span>

                            <div class="small mt-2">
                                Selesai
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <form action="{{ route('customer.checkout.store') }}"
          method="POST">

        @csrf

        <div class="row">

            <!-- ALAMAT -->
            <div class="col-lg-7 mb-4">

                <div class="card checkout-card">

                    <div class="checkout-header bg-primary text-white">

                        <i class="bi bi-geo-alt me-2"></i>
                        Alamat Pengiriman

                    </div>

                    <div class="card-body p-4">

                        @if($addresses->count() > 0)

                            <div class="row">

                                @foreach($addresses as $address)

                                    <div class="col-md-6 mb-4">

                                        <div class="address-card p-3">

                                            <div class="form-check">

                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="shipping_address_id"
                                                    id="address_{{ $address->id }}"
                                                    value="{{ $address->id }}"
                                                    {{ old('shipping_address_id', $addresses->first()->id) == $address->id ? 'checked' : '' }}
                                                    required
                                                >

                                                <label class="form-check-label w-100"
                                                       for="address_{{ $address->id }}">

                                                    <div class="fw-bold mb-2">

                                                        {{ $address->recipient_name }}

                                                    </div>

                                                    <div class="small text-muted mb-1">

                                                        {{ $address->phone }}

                                                    </div>

                                                    <div class="small text-muted mb-1">

                                                        {{ $address->address }}

                                                    </div>

                                                    <div class="small text-muted">

                                                        {{ $address->city }},
                                                        {{ $address->province }}
                                                        {{ $address->postal_code }}

                                                    </div>

                                                </label>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                            <!-- BUTTON TAMBAH -->
                            <a href="{{ route('customer.addresses.create') }}"
                               class="btn btn-outline-primary modern-btn">

                                <i class="bi bi-plus-circle me-1"></i>
                                Tambah Alamat Baru

                            </a>

                        @else

                            <div class="alert alert-warning rounded-4">

                                <i class="bi bi-exclamation-triangle me-2"></i>

                                Anda belum memiliki alamat pengiriman.

                            </div>

                            <a href="{{ route('customer.addresses.create') }}"
                               class="btn btn-primary modern-btn">

                                <i class="bi bi-plus-circle me-1"></i>
                                Tambah Alamat

                            </a>

                        @endif

                    </div>

                </div>

            </div>

            <!-- RINGKASAN -->
            <div class="col-lg-5">

                <div class="card checkout-card">

                    <div class="checkout-header bg-success text-white">

                        <i class="bi bi-receipt me-2"></i>
                        Ringkasan Pesanan

                    </div>

                    <div class="card-body p-4">

                        <!-- PRODUK -->
                        <div class="mb-4">

                            @foreach($cart->cartItems as $item)

                                <div class="summary-item d-flex justify-content-between">

                                    <div>

                                        <div class="fw-semibold">

                                            {{ $item->product->name }}

                                        </div>

                                        <small class="text-muted">

                                            Qty: {{ $item->qty }}

                                        </small>

                                    </div>

                                    <div class="fw-semibold">

                                        {{ $item->formatted_subtotal }}

                                    </div>

                                </div>

                            @endforeach

                        </div>

                        <!-- TOTAL -->
                        <div class="d-flex justify-content-between mb-2">

                            <span>Subtotal</span>

                            <strong>
                                Rp {{ number_format($cart->total, 0, ',', '.') }}
                            </strong>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span>Biaya Kirim</span>

                            <span class="text-muted">
                                Menyesuaikan
                            </span>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <h5 class="mb-0 fw-bold">
                                Total
                            </h5>

                            <h4 class="text-primary fw-bold mb-0">

                                Rp {{ number_format($cart->total, 0, ',', '.') }}

                            </h4>

                        </div>

                        <!-- PAYMENT INFO -->
                        <div class="mb-4">

                            <div class="alert alert-info rounded-4 mb-0">

                                <i class="bi bi-wallet2 me-2"></i>

                                <strong>Pembayaran via Midtrans</strong>

                                <br>

                                <small>

                                    Setelah pesanan dibuat, Anda akan diarahkan ke halaman pembayaran

                                    untuk memilih metode (Transfer Bank / GoPay / ShopeePay).

                                </small>

                            </div>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn btn-success modern-btn w-100">

                            <i class="bi bi-check-circle me-1"></i>
                            Buat Pesanan & Bayar

                        </button>

                        <a href="{{ route('customer.cart.index') }}"
                           class="btn btn-outline-secondary modern-btn w-100 mt-2">

                            <i class="bi bi-arrow-left me-1"></i>
                            Kembali ke Keranjang

                        </a>

                    </div>

                </div>

                <!-- INFO -->
                <div class="info-box mt-4">

                    <h6 class="fw-bold mb-3">

                        <i class="bi bi-info-circle me-1"></i>
                        Informasi

                    </h6>

                    <ul class="mb-0 text-muted">

                        <li class="mb-2">
                            Pembayaran diproses otomatis melalui Midtrans
                        </li>

                        <li class="mb-2">
                            Estimasi pengiriman 2-3 hari kerja
                        </li>

                        <li>
                            Pesanan akan diproses setelah pembayaran berhasil
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection