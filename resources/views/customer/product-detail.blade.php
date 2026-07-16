@extends('layouts.customer')

@section('title', $product->name)

@section('content')

<style>

    body{
        background:#f8fafc;
    }

    .detail-card{
        border:none;
        border-radius:30px;
        overflow:hidden;
        box-shadow:0 15px 40px rgba(0,0,0,.06);
    }

    .product-image{
        width:100%;
        height:500px;
        object-fit:contain;
        background:#f8fafc;
        padding:30px;
    }

    .price{
        font-size:2rem;
        font-weight:800;
        color:#2563eb;
    }

    .stock-badge{
        padding:10px 18px;
        border-radius:999px;
        font-weight:700;
        font-size:.9rem;
    }

    .qty-box{
        width:120px;
    }

    .btn-cart{
        height:55px;
        border-radius:16px;
        font-weight:700;
    }

    .related-card{
        border:none;
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 10px 25px rgba(0,0,0,.05);
        transition:.3s;
        height:100%;
    }

    .related-card:hover{
        transform:translateY(-5px);
    }

    .related-image{
        height:220px;
        object-fit:contain;
        background:#f8fafc;
        padding:20px;
    }

</style>

<div class="container py-4">

    <!-- DETAIL -->
    <div class="card detail-card mb-5">

        <div class="row g-0">

            <!-- IMAGE -->
            <div class="col-lg-6">

                @if($product->image)

                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="product-image"
                         alt="{{ $product->name }}">

                @else

                    <img src="https://via.placeholder.com/600x600?text=No+Image"
                         class="product-image"
                         alt="No Image">

                @endif

            </div>

            <!-- CONTENT -->
            <div class="col-lg-6">

                <div class="p-4 p-lg-5">

                    <!-- CATEGORY -->
                    <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">
                        {{ $product->category->name }}
                    </span>

                    <!-- NAME -->
                    <h1 class="fw-bold mb-3">
                        {{ $product->name }}
                    </h1>

                    <!-- PRICE -->
                    <div class="price mb-4">
                        {{ $product->formatted_price }}
                    </div>

                    <!-- STOCK -->
                    <div class="mb-4">

                        @if($product->stock > 0)

                            <span class="badge bg-success stock-badge">
                                Stock tersedia : {{ $product->stock }}
                            </span>

                        @else

                            <span class="badge bg-danger stock-badge">
                                Stock habis
                            </span>

                        @endif

                    </div>

                    <!-- DESCRIPTION -->
                    <div class="mb-5">

                        <h5 class="fw-bold mb-3">
                            Deskripsi Produk
                        </h5>

                        <p class="text-muted lh-lg">
                            {{ $product->description }}
                        </p>

                    </div>

                    <!-- ACTION -->
                    @if($product->stock > 0)

                        <form action="{{ route('customer.cart.store') }}"
                              method="POST">

                            @csrf

                            <input type="hidden"
                                   name="product_id"
                                   value="{{ $product->id }}">

                            <div class="d-flex gap-3 align-items-center flex-wrap">

                                <!-- QTY -->
                                <div class="qty-box">

                                    <input type="number"
                                           name="qty"
                                           value="1"
                                           min="1"
                                           max="{{ $product->stock }}"
                                           class="form-control form-control-lg">

                                </div>

                                <!-- BUTTON -->
                                <button type="submit"
                                        class="btn btn-primary btn-cart px-4">

                                    <i class="bi bi-cart-plus-fill me-2"></i>
                                    Tambah ke Keranjang

                                </button>

                            </div>

                        </form>

                    @endif

                    <!-- BACK -->
                    <div class="mt-4">

                        <a href="{{ route('customer.shop.index') }}"
                           class="btn btn-outline-dark rounded-pill px-4">

                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali Belanja

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- RELATED PRODUCTS -->
    @if($relatedProducts->count() > 0)

        <div class="mb-4">

            <h2 class="fw-bold">
                Produk Terkait
            </h2>

            <p class="text-muted">
                Produk lain yang mungkin Anda suka
            </p>

        </div>

        <div class="row">

            @foreach($relatedProducts as $item)

                <div class="col-md-6 col-lg-3 mb-4">

                    <div class="card related-card">

                        @if($item->image)

                            <img src="{{ asset('storage/' . $item->image) }}"
                                 class="related-image"
                                 alt="{{ $item->name }}">

                        @else

                            <img src="https://via.placeholder.com/400x300?text=No+Image"
                                 class="related-image"
                                 alt="No Image">

                        @endif

                        <div class="card-body">

                            <h6 class="fw-bold mb-2">
                                {{ $item->name }}
                            </h6>

                            <div class="text-primary fw-bold mb-3">
                                {{ $item->formatted_price }}
                            </div>

                            <a href="{{ route('customer.shop.show', $item) }}"
                               class="btn btn-dark w-100 rounded-pill">

                                View Detail

                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection