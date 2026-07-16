@extends('layouts.admin')

@section('title', 'Detail Order - MediaBook')

@section('content')

<style>

    body{
        background:#f8fafc;
    }

    .page-title{
        font-size:2rem;
        font-weight:800;
        color:#0f172a;
        font-family: 'Playfair Display', serif;
    }

    .page-subtitle{
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.1rem;
        color: #64748b;
    }

    .card-modern{
        border:none;
        border-radius:28px;
        overflow:hidden;
        background:#fff;
        box-shadow:0 10px 30px rgba(15,23,42,.06);
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .card-modern:hover{
        box-shadow:0 15px 40px rgba(139,92,246,.08);
    }

    .card-header-modern{
        padding:24px 28px;
        border-bottom:1px solid #f1f5f9;
        background: linear-gradient(135deg, #faf5ff, #f3e8ff);
    }

    .card-header-modern h5{
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #5b21b6;
    }

    .card-body-modern{
        padding:28px;
    }

    .product-item{
        padding-bottom:22px;
        margin-bottom:22px;
        border-bottom:1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .product-item:last-child{
        border-bottom:none;
        margin-bottom:0;
        padding-bottom:0;
    }

    .product-item:hover{
        background: #faf5ff;
        margin: 0 -10px;
        padding: 10px 10px;
        border-radius: 16px;
    }

    .product-image{
        width:80px;
        height:100px;
        object-fit:cover;
        border-radius:14px;
        background:#f8fafc;
        box-shadow: 0 4px 12px rgba(0,0,0,.06);
    }

    .product-name{
        font-size:1rem;
        font-weight:700;
        color:#0f172a;
        font-family: 'Playfair Display', serif;
    }

    .product-author{
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: #64748b;
        font-size: 0.9rem;
    }

    .price-text{
        color:#8b5cf6;
        font-weight:700;
    }

    .summary-item{
        display:flex;
        justify-content:space-between;
        margin-bottom:18px;
        padding-bottom:12px;
        border-bottom: 1px dashed #f1f5f9;
    }

    .summary-item:last-child{
        border-bottom:none;
        margin-bottom:0;
        padding-bottom:0;
    }

    .summary-label{
        color:#64748b;
        font-weight:500;
    }

    .summary-value{
        font-weight:700;
        color:#0f172a;
    }

    .badge-modern{
        padding:10px 18px;
        border-radius:999px;
        font-size:13px;
        font-weight:700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-success{
        background:#dcfce7;
        color:#166534;
    }

    .status-primary{
        background:#dbeafe;
        color:#1d4ed8;
    }

    .status-warning{
        background:#fef3c7;
        color:#92400e;
    }

    .status-danger{
        background:#fee2e2;
        color:#991b1b;
    }

    .address-box{
        background: linear-gradient(135deg, #faf5ff, #f3e8ff);
        border-radius:22px;
        padding:22px;
        border: 1px solid #ede9fe;
    }

    .customer-box{
        background: linear-gradient(135deg, #faf5ff, #f3e8ff);
        border-radius:22px;
        padding:22px;
        border: 1px solid #ede9fe;
    }

    /* =======================
       BUTTON BACK - FIXED POSITION
    ======================= */
    .btn-back-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .btn-back {
        border-radius:16px;
        padding:12px 28px;
        font-weight:700;
        background: #0f172a;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: white;
        text-decoration: none;
        font-size: 0.95rem;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.15);
    }

    .btn-back:hover {
        background: #8b5cf6;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(139,92,246,.35);
        color: white;
    }

    .btn-back i {
        font-size: 1.1rem;
    }

    /* Order Number Badge */
    .order-number-badge{
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        color: white;
        padding: 8px 24px;
        border-radius: 999px;
        font-size: 0.9rem;
        font-weight: 700;
        display: inline-block;
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(139,92,246,.25);
    }

    /* Header Action Container */
    .header-action {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Status Quick Badge di Header */
    .header-status-badge {
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .total-box{
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        color:white;
        border-radius:24px;
        padding:24px;
        position: relative;
        overflow: hidden;
    }

    .total-box::before{
        content: '📚';
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 3rem;
        opacity: 0.1;
    }

    .total-box::after{
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
        bottom: -30px;
        right: -20px;
    }

    .total-label{
        opacity:.8;
        font-size:.95rem;
        font-weight: 500;
    }

    .total-price{
        font-size:2rem;
        font-weight:800;
        font-family: 'Playfair Display', serif;
    }

    .empty-box{
        background:#faf5ff;
        border:1px solid #ede9fe;
        color:#5b21b6;
        border-radius:18px;
        padding:18px;
    }

    .payment-proof-img{
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,.08);
        border: 2px solid #f1f5f9;
        transition: all 0.3s ease;
        max-height: 300px;
        object-fit: contain;
        width: 100%;
        background: #f8fafc;
    }

    .payment-proof-img:hover{
        transform: scale(1.02);
        box-shadow: 0 12px 35px rgba(139,92,246,.15);
        border-color: #8b5cf6;
    }

    .btn-payment{
        border-radius: 16px;
        padding: 14px;
        font-weight: 700;
        background: #8b5cf6;
        border: none;
        transition: all 0.3s ease;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
    }

    .btn-payment:hover{
        background: #6d28d9;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(139,92,246,.3);
        color: white;
    }

    @media(max-width:768px){

        .card-body-modern{
            padding:20px;
        }

        .card-header-modern{
            padding:20px;
        }

        .total-price{
            font-size:1.5rem;
        }

        .product-image{
            width:60px;
            height:80px;
        }

        .btn-back-wrapper {
            width: 100%;
            justify-content: flex-start;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }

        .header-action {
            width: 100%;
        }
    }

</style>

<div class="container-fluid py-4">

    <!-- HEADER - MEDIABOOK THEME WITH FIXED BACK BUTTON -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <!-- LEFT: Title & Order Number -->
        <div>

            <h1 class="page-title mb-1">
                📖 Detail Order
            </h1>

            <div class="d-flex align-items-center gap-3 flex-wrap mt-2">

                <span class="order-number-badge">
                    📋 {{ $order->order_number }}
                </span>

                <span class="page-subtitle mb-0">
                    Pesanan buku dari customer
                </span>

                <!-- Quick Status di Header -->
                @php
                    $statusColors = [
                        'pending' => 'status-warning',
                        'processed' => 'status-primary',
                        'shipped' => 'status-primary',
                        'completed' => 'status-success',
                        'cancelled' => 'status-danger',
                    ];
                    $statusIcons = [
                        'pending' => '⏳',
                        'processed' => '🔄',
                        'shipped' => '📦',
                        'completed' => '✅',
                        'cancelled' => '❌',
                    ];
                @endphp

                <span class="header-status-badge {{ $statusColors[$order->status] ?? 'status-primary' }}">
                    {{ $statusIcons[$order->status] ?? '' }}
                    {{ ucfirst($order->status) }}
                </span>

            </div>

        </div>

        <!-- RIGHT: Back Button - FIXED POSITION -->
        <div class="btn-back-wrapper">

            <a href="{{ route('admin.orders.index') }}"
               class="btn-back">

                <i class="bi bi-arrow-left"></i>
                Kembali ke Pesanan

            </a>

        </div>

    </div>

    <div class="row g-4">

        <!-- LEFT COLUMN -->
        <div class="col-lg-8">

            <!-- PRODUCT ITEMS - MEDIABOOK THEME -->
            <div class="card-modern mb-4">

                <div class="card-header-modern">

                    <h5 class="fw-bold mb-0">
                        📚 Produk Pesanan
                    </h5>

                </div>

                <div class="card-body-modern">

                    @if($order->orderItems && $order->orderItems->count())

                        @foreach($order->orderItems as $item)

                            <div class="product-item">

                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                                    <div class="d-flex align-items-center gap-3">

                                        <!-- IMAGE -->
                                        @if($item->product && $item->product->image)

                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                 class="product-image"
                                                 alt="{{ $item->product->name }}">

                                        @else

                                            <img src="https://via.placeholder.com/80x100?text=Cover+Buku"
                                                 class="product-image"
                                                 alt="Cover Buku">

                                        @endif

                                        <!-- INFO -->
                                        <div>

                                            <div class="product-name mb-0">
                                                {{ $item->product->name ?? 'Buku telah dihapus' }}
                                            </div>

                                            @if(isset($item->product->author))
                                                <div class="product-author">
                                                    <i class="bi bi-pencil-fill me-1" style="font-size: 0.7rem;"></i>
                                                    {{ $item->product->author }}
                                                </div>
                                            @endif

                                            <div class="text-muted small mt-1">
                                                <i class="bi bi-cart3 me-1"></i>
                                                Qty : {{ $item->qty }}
                                            </div>

                                            <div class="price-text mt-1">
                                                Rp {{ number_format($item->price,0,',','.') }}
                                            </div>

                                        </div>

                                    </div>

                                    <!-- SUBTOTAL -->
                                    <div class="text-end bg-purple-50 px-4 py-3 rounded-3">

                                        <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">
                                            Subtotal
                                        </small>

                                        <div class="fw-bold fs-5 text-purple-600">
                                            Rp {{ number_format($item->subtotal,0,',','.') }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    @else

                        <div class="empty-box">

                            <i class="bi bi-exclamation-circle-fill me-2"></i>

                            Tidak ada item produk pada order ini.

                        </div>

                    @endif

                </div>

            </div>

            <!-- SHIPPING ADDRESS - MEDIABOOK THEME -->
            <div class="card-modern">

                <div class="card-header-modern">

                    <h5 class="fw-bold mb-0">
                        📦 Alamat Pengiriman
                    </h5>

                </div>

                <div class="card-body-modern">

                    @if($order->shippingAddress)

                        <div class="address-box">

                            <div class="d-flex align-items-center gap-3 mb-3">

                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-fill text-purple-600"></i>
                                </div>

                                <div>

                                    <h5 class="fw-bold mb-0">
                                        {{ $order->shippingAddress->recipient_name }}
                                    </h5>

                                    <p class="text-muted mb-0 small">
                                        <i class="bi bi-telephone me-1"></i>
                                        {{ $order->shippingAddress->phone }}
                                    </p>

                                </div>

                            </div>

                            <div class="bg-white p-3 rounded-3 border border-purple-100">

                                <p class="text-dark mb-0">
                                    <i class="bi bi-geo-alt-fill text-purple-500 me-2"></i>
                                    {{ $order->shippingAddress->full_address }}
                                </p>

                            </div>

                        </div>

                    @else

                        <div class="empty-box">

                            <i class="bi bi-exclamation-triangle-fill me-2"></i>

                            Alamat pengiriman tidak tersedia.

                        </div>

                    @endif

                </div>

            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">

            <!-- CUSTOMER INFO - MEDIABOOK THEME -->
            <div class="card-modern mb-4">

                <div class="card-header-modern">

                    <h5 class="fw-bold mb-0">
                        👤 Customer
                    </h5>

                </div>

                <div class="card-body-modern">

                    <div class="customer-box">

                        <div class="d-flex align-items-center gap-3 mb-2">

                            <div class="rounded-full bg-purple-100 p-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-fill text-purple-600 fs-4"></i>
                            </div>

                            <div>

                                <h5 class="fw-bold mb-0">
                                    {{ $order->user->name }}
                                </h5>

                                <p class="text-muted mb-0 small">
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $order->user->email }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ORDER SUMMARY - MEDIABOOK THEME -->
            <div class="card-modern mb-4">

                <div class="card-header-modern">

                    <h5 class="fw-bold mb-0">
                        📋 Ringkasan Order
                    </h5>

                </div>

                <div class="card-body-modern">

                    <div class="summary-item">

                        <div class="summary-label">
                            <i class="bi bi-receipt me-1"></i>
                            Nomor Order
                        </div>

                        <div class="summary-value">
                            {{ $order->order_number }}
                        </div>

                    </div>

                    <div class="summary-item">

                        <div class="summary-label">
                            <i class="bi bi-tag me-1"></i>
                            Status Order
                        </div>

                        <div>

                            <span class="badge-modern {{ $statusColors[$order->status] ?? 'status-primary' }}">
                                {{ $statusIcons[$order->status] ?? '' }}
                                {{ ucfirst($order->status) }}
                            </span>

                        </div>

                    </div>

                    <div class="summary-item">

                        <div class="summary-label">
                            <i class="bi bi-credit-card me-1"></i>
                            Status Payment
                        </div>

                        <div>

                            @php
                                $paymentColors = [
                                    'paid' => 'status-success',
                                    'pending' => 'status-warning',
                                    'rejected' => 'status-danger',
                                    'unpaid' => 'status-warning',
                                ];
                                $paymentIcons = [
                                    'paid' => '✅',
                                    'pending' => '⏳',
                                    'rejected' => '❌',
                                    'unpaid' => '⏸️',
                                ];
                            @endphp

                            <span class="badge-modern {{ $paymentColors[$order->payment_status] ?? 'status-warning' }}">
                                {{ $paymentIcons[$order->payment_status] ?? '' }}
                                {{ ucfirst($order->payment_status) }}
                            </span>

                        </div>

                    </div>

                    <div class="summary-item">

                        <div class="summary-label">
                            <i class="bi bi-calendar3 me-1"></i>
                            Tanggal
                        </div>

                        <div class="summary-value">
                            {{ $order->created_at->format('d M Y') }}
                        </div>

                    </div>

                    <hr class="my-4" style="border-color: #ede9fe;">

                    <!-- TOTAL -->
                    <div class="total-box">

                        <div class="total-label mb-2">
                            💰 Total Pembayaran
                        </div>

                        <div class="total-price">
                            Rp {{ number_format($order->total,0,',','.') }}
                        </div>

                    </div>

                </div>

            </div>

            <!-- PAYMENT INFO -->
            @if($order->payment)

                <div class="card-modern">

                    <div class="card-header-modern">

                        <h5 class="fw-bold mb-0">
                            💳 Info Pembayaran
                        </h5>

                    </div>

                    <div class="card-body-modern">

                        <div class="summary-item">
                            <div class="summary-label">Metode</div>
                            <div class="summary-value">{{ $order->payment->payment_type_label }}</div>
                        </div>

                        <div class="summary-item">
                            <div class="summary-label">Status</div>
                            <div class="summary-value">{{ $order->payment->status_label }}</div>
                        </div>

                        @if($order->payment->transaction_id)
                            <div class="summary-item">
                                <div class="summary-label">Transaction ID</div>
                                <div class="summary-value small">{{ $order->payment->transaction_id }}</div>
                            </div>
                        @endif

                        <a href="{{ route('admin.payments.show', $order->payment) }}"
                           class="btn-payment mt-3">

                            <i class="bi bi-eye me-2"></i>
                            Lihat Detail Pembayaran

                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
