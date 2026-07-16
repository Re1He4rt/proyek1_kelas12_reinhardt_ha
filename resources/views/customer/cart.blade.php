
@extends('layouts.customer')

@section('title', 'Keranjang Belanja')

@section('content')

<style>

    .cart-title{
        font-weight:800;
        color:#0f172a;
    }

    .cart-card{
        border:none;
        border-radius:28px;
        overflow:hidden;
        background:#fff;
        box-shadow:0 10px 30px rgba(15,23,42,.06);
    }

    .cart-header{
        padding:24px 28px;
        border-bottom:1px solid #eef2f7;
        background:#fff;
    }

    .cart-item{
        padding:24px 28px;
        border-bottom:1px solid #f1f5f9;
    }

    .cart-item:last-child{
        border-bottom:none;
    }

    .product-image{
        width:90px;
        height:90px;
        border-radius:20px;
        object-fit:cover;
        background:#f8fafc;
        padding:8px;
    }

    .product-name{
        font-weight:700;
        color:#0f172a;
        margin-bottom:6px;
    }

    .product-stock{
        font-size:.9rem;
        color:#64748b;
    }

    .price{
        font-weight:700;
        color:#2563eb;
    }

    .qty-box{
        display:flex;
        align-items:center;
        gap:8px;
    }

    .qty-input{
        width:70px;
        border-radius:12px;
        border:1px solid #dbe4ee;
        text-align:center;
        min-height:42px;
    }

    .btn-update{
        border:none;
        width:42px;
        height:42px;
        border-radius:12px;
        background:#2563eb;
        color:white;
    }

    .btn-delete{
        border:none;
        width:42px;
        height:42px;
        border-radius:12px;
        background:#ef4444;
        color:white;
    }

    .summary-card{
        border:none;
        border-radius:28px;
        overflow:hidden;
        background:#0f172a;
        color:white;
        box-shadow:0 10px 30px rgba(15,23,42,.15);
        position:sticky;
        top:100px;
    }

    .summary-header{
        padding:24px 28px;
        border-bottom:1px solid rgba(255,255,255,.08);
    }

    .summary-body{
        padding:28px;
    }

    .summary-row{
        display:flex;
        justify-content:space-between;
        margin-bottom:18px;
        color:#cbd5e1;
    }

    .summary-total{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-top:24px;
        padding-top:24px;
        border-top:1px solid rgba(255,255,255,.1);
    }

    .summary-total h4{
        margin:0;
        font-weight:800;
    }

    .checkout-btn{
        width:100%;
        border:none;
        border-radius:18px;
        background:#2563eb;
        color:white;
        padding:16px;
        font-weight:700;
        margin-top:24px;
        transition:.3s;
    }

    .checkout-btn:hover{
        background:#1d4ed8;
    }

    .secondary-btn{
        width:100%;
        border-radius:18px;
        padding:14px;
        font-weight:600;
    }

    .empty-cart{
        background:#fff;
        border-radius:32px;
        padding:90px 20px;
        text-align:center;
        box-shadow:0 10px 30px rgba(0,0,0,.05);
    }

    .empty-icon{
        width:130px;
        height:130px;
        margin:auto;
        border-radius:50%;
        background:#eff6ff;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:55px;
    }

    @media(max-width:768px){

        .cart-item{
            padding:20px;
        }

        .product-image{
            width:75px;
            height:75px;
        }

    }

</style>

<div class="container py-4">

    <!-- TITLE -->
    <div class="mb-4">

        <h2 class="cart-title">
            <i class="bi bi-cart3 me-2"></i>
            Keranjang Belanja
        </h2>

        <p class="text-muted mb-0">
            Kelola produk yang ingin Anda beli
        </p>

    </div>

    @if($cart->cartItems->isEmpty())

        <!-- EMPTY -->
        <div class="empty-cart">

            <div class="empty-icon mb-4">
                <i class="bi bi-cart-x"></i>
            </div>

            <h3 class="fw-bold mb-3">
                Keranjang Masih Kosong
            </h3>

            <p class="text-muted mb-4">
                Yuk mulai belanja sparepart dan aksesoris motor terbaik.
            </p>

            <a href="{{ route('customer.shop.index') }}"
               class="btn btn-primary btn-lg rounded-pill px-5">

                <i class="bi bi-grid me-2"></i>
                Mulai Belanja

            </a>

        </div>

    @else

        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-lg-8">

                <div class="cart-card">

                    <div class="cart-header d-flex justify-content-between align-items-center">

                        <h5 class="fw-bold mb-0">
                            Produk Pilihan
                        </h5>

                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            {{ $cart->total_items }} Item
                        </span>

                    </div>

                    @foreach($cart->cartItems as $item)

                        <div class="cart-item">

                            <div class="row align-items-center g-3">

                                <!-- IMAGE -->
                                <div class="col-md-2 col-3">

                                    @if($item->product->image)

                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                             class="product-image"
                                             alt="{{ $item->product->name }}">

                                    @else

                                        <img src="https://via.placeholder.com/300x300?text=No+Image"
                                             class="product-image">

                                    @endif

                                </div>

                                <!-- INFO -->
                                <div class="col-md-4 col-9">

                                    <div class="product-name">
                                        {{ $item->product->name }}
                                    </div>

                                    <div class="product-stock">
                                        Stock tersedia:
                                        {{ $item->product->stock }}
                                    </div>

                                </div>

                                <!-- PRICE -->
                                <div class="col-md-2">

                                    <div class="price">
                                        {{ $item->product->formatted_price }}
                                    </div>

                                </div>

                                <!-- QTY -->
                                <div class="col-md-3">

                                    <form action="{{ route('customer.cart.update', $item) }}"
                                          method="POST">

                                        @csrf
                                        @method('PUT')

                                        <div class="qty-box">

                                            <input type="number"
                                                   name="qty"
                                                   value="{{ $item->qty }}"
                                                   min="1"
                                                   max="{{ $item->product->stock }}"
                                                   class="form-control qty-input">

                                            <button type="submit"
                                                    class="btn-update">

                                                <i class="bi bi-arrow-repeat"></i>

                                            </button>

                                        </div>

                                    </form>

                                </div>

                                <!-- DELETE -->
                                <div class="col-md-1 text-end">

                                    <form action="{{ route('customer.cart.destroy', $item) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus item ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn-delete">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <div class="summary-card">

                    <div class="summary-header">

                        <h5 class="fw-bold mb-0">
                            Ringkasan Pesanan
                        </h5>

                    </div>

                    <div class="summary-body">

                        <div class="summary-row">

                            <span>Total Item</span>

                            <strong>{{ $cart->total_items }}</strong>

                        </div>

                        <div class="summary-row">

                            <span>Biaya Kirim</span>

                            <span>Checkout</span>

                        </div>

                        <div class="summary-total">

                            <h6>Total</h6>

                            <h4>
                                Rp {{ number_format($cart->total, 0, ',', '.') }}
                            </h4>

                        </div>

                        <a href="{{ route('customer.checkout.index') }}"
                           class="btn checkout-btn">

                            <i class="bi bi-credit-card me-2"></i>
                            Checkout Sekarang

                        </a>

                        <a href="{{ route('customer.shop.index') }}"
                           class="btn btn-outline-light secondary-btn mt-3">

                            <i class="bi bi-arrow-left me-2"></i>
                            Lanjut Belanja

                        </a>

                        <form action="{{ route('customer.cart.clear') }}"
                              method="POST"
                              onsubmit="return confirm('Kosongkan keranjang?')">

                            @csrf

                            <button type="submit"
                                    class="btn btn-outline-danger secondary-btn mt-3">

                                <i class="bi bi-trash me-2"></i>
                                Kosongkan Keranjang

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection

