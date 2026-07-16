@extends('layouts.admin')

@section('title', 'Detail Pembayaran - MediaBook')

@section('content')

<style>

    body{
        background:#f8fafc;
    }

    .page-header{
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        border-radius:28px;
        padding:35px;
        color:white;
        margin-bottom:30px;
        position:relative;
        overflow:hidden;
    }

    .page-header::before{
        content:'📚';
        position:absolute;
        font-size:10rem;
        opacity:0.08;
        top:-40px;
        right:20px;
        transform:rotate(15deg);
    }

    .page-header::after{
        content:'';
        position:absolute;
        width:250px;
        height:250px;
        border-radius:50%;
        background:rgba(255,255,255,.05);
        top:-120px;
        right:-80px;
    }

    .page-title{
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        font-size: 2rem;
    }

    .page-subtitle{
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.1rem;
        opacity: 0.85;
    }

    .modern-card{
        border:none;
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(15,23,42,.06);
        background:#fff;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .modern-card:hover{
        box-shadow:0 15px 40px rgba(139,92,246,.08);
    }

    .modern-card .card-header{
        background: linear-gradient(135deg, #faf5ff, #f3e8ff);
        border-bottom:1px solid #ede9fe;
        padding:22px 28px;
    }

    .modern-card .card-header h5{
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #5b21b6;
    }

    .modern-card .card-body{
        padding:28px;
    }

    .info-box{
        background: linear-gradient(135deg, #faf5ff, #f3e8ff);
        border-radius:18px;
        padding:20px;
        height:100%;
        border: 1px solid #ede9fe;
    }

    .label-title{
        font-size:13px;
        color:#64748b;
        margin-bottom:6px;
        font-weight: 500;
    }

    .value-text{
        font-weight:700;
        color:#0f172a;
    }

    .payment-image{
        width:100%;
        border-radius:24px;
        object-fit:cover;
        box-shadow:0 10px 25px rgba(0,0,0,.08);
        border: 2px solid #f1f5f9;
        transition: all 0.3s ease;
        max-height: 400px;
        object-fit: contain;
        background: #faf5ff;
    }

    .payment-image:hover{
        transform: scale(1.02);
        box-shadow:0 15px 35px rgba(139,92,246,.15);
        border-color: #8b5cf6;
    }

    .product-item{
        border:1px solid #ede9fe;
        border-radius:18px;
        padding:18px;
        margin-bottom:16px;
        transition: all 0.3s ease;
    }

    .product-item:last-child{
        margin-bottom:0;
    }

    .product-item:hover{
        background: #faf5ff;
        border-color: #8b5cf6;
        transform: translateX(4px);
    }

    .product-image{
        width:80px;
        height:100px;
        border-radius:16px;
        object-fit:cover;
        background:#f1f5f9;
        box-shadow: 0 4px 12px rgba(0,0,0,.06);
    }

    .product-name{
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #0f172a;
    }

    .product-author{
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: #64748b;
        font-size: 0.9rem;
    }

    .status-badge{
        padding:10px 20px;
        border-radius:999px;
        font-size:13px;
        font-weight:700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-modern{
        border:none;
        border-radius:16px;
        padding:14px 20px;
        font-weight:700;
        transition: all 0.3s ease;
    }

    .btn-modern:hover{
        transform: translateY(-2px);
    }

    .btn-back{
        border-radius:16px;
        padding:12px 28px;
        font-weight:700;
        background: rgba(255,255,255,.2);
        border: 1px solid rgba(255,255,255,.3);
        color: white;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-back:hover{
        background: rgba(255,255,255,.35);
        color: white;
        transform: translateY(-2px);
    }

    .summary-box{
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        color:white;
        border-radius:24px;
        padding:25px;
        position: relative;
        overflow: hidden;
    }

    .summary-box::before{
        content: '💰';
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 2.5rem;
        opacity: 0.15;
    }

    .summary-box h2{
        font-weight:800;
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
    }

    .order-badge{
        background: rgba(255,255,255,.15);
        padding: 4px 16px;
        border-radius: 999px;
        font-size: 0.8rem;
        color: rgba(255,255,255,.9);
        backdrop-filter: blur(4px);
    }

    .empty-state{
        background: #faf5ff;
        border: 2px dashed #ede9fe;
        border-radius: 18px;
        padding: 40px 20px;
        text-align: center;
        color: #8b5cf6;
    }

    .empty-state i{
        font-size: 3rem;
        opacity: 0.5;
    }

    /* Form Textarea */
    .form-control{
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .form-control:focus{
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139,92,246,.15);
    }

    .btn-verify{
        background: #10b981;
        color: white;
    }

    .btn-verify:hover{
        background: #059669;
        color: white;
    }

    .btn-reject{
        background: #ef4444;
        color: white;
    }

    .btn-reject:hover{
        background: #dc2626;
        color: white;
    }

    @media(max-width:768px){
        .page-header{
            padding:25px;
        }

        .modern-card .card-header{
            padding:18px 20px;
        }

        .modern-card .card-body{
            padding:20px;
        }

        .product-image{
            width:60px;
            height:80px;
        }

        .summary-box h2{
            font-size:1.5rem;
        }

        .btn-back{
            width:100%;
            justify-content:center;
        }
    }

</style>

<div class="container-fluid py-4">

    <!-- HEADER - MEDIABOOK THEME -->
    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h2 class="page-title mb-1">
                    💳 Detail Pembayaran
                </h2>

                <p class="page-subtitle mb-0">
                    Informasi lengkap pembayaran customer MediaBook
                </p>

                <div class="mt-2">
                    <span class="order-badge">
                        📋 {{ $payment->order->order_number }}
                    </span>
                </div>

            </div>

            <a href="{{ route('admin.orders.show', $payment->order) }}"
               class="btn-back">

                <i class="bi bi-arrow-left"></i>
                Kembali ke Order

            </a>

        </div>

    </div>

    <div class="row g-4">

        <!-- LEFT COLUMN -->
        <div class="col-lg-8">

            <!-- TRANSACTION DATA -->
            <div class="modern-card mb-4">

                <div class="card-header">

                    <h5 class="fw-bold mb-0">
                        🔍 Data Transaksi Midtrans
                    </h5>

                </div>

                <div class="card-body">

                    @if($payment->payload)

                        <pre class="bg-light p-3 rounded-3" style="font-size:0.8rem; max-height:400px; overflow:auto;">{{ json_encode($payment->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>

                    @else

                        <div class="empty-state">

                            <i class="bi bi-database-x"></i>

                            <p class="mt-2 mb-0">
                                Belum ada data transaksi dari Midtrans
                            </p>

                        </div>

                    @endif

                </div>

            </div>

            <!-- ORDER ITEMS - MEDIABOOK THEME -->
            <div class="modern-card">

                <div class="card-header">

                    <h5 class="fw-bold mb-0">
                        📚 Produk Pesanan
                    </h5>

                </div>

                <div class="card-body">

                    @forelse($payment->order->orderItems ?? [] as $item)

                        <div class="product-item">

                            <div class="d-flex gap-3 align-items-center">

                                <!-- IMAGE -->
                                <div>

                                    @if($item->product && $item->product->image)

                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                             class="product-image"
                                             alt="{{ $item->product->name }}">

                                    @else

                                        <img src="https://via.placeholder.com/80x100?text=Cover+Buku"
                                             class="product-image"
                                             alt="Cover Buku">

                                    @endif

                                </div>

                                <!-- INFO -->
                                <div class="flex-grow-1">

                                    <h6 class="product-name mb-0">
                                        {{ $item->product->name ?? 'Buku tidak ditemukan' }}
                                    </h6>

                                    @if(isset($item->product->author))
                                        <div class="product-author">
                                            <i class="bi bi-pencil-fill me-1" style="font-size: 0.6rem;"></i>
                                            {{ $item->product->author }}
                                        </div>
                                    @endif

                                    <div class="d-flex gap-3 mt-1">

                                        <span class="text-muted small">
                                            <i class="bi bi-cart3 me-1"></i>
                                            Qty: {{ $item->qty }}
                                        </span>

                                        <strong class="text-purple-600">
                                            Rp {{ number_format($item->price,0,',','.') }}
                                        </strong>

                                    </div>

                                </div>

                                <!-- SUBTOTAL -->
                                <div class="text-end bg-purple-50 px-3 py-2 rounded-3">

                                    <small class="text-muted d-block" style="font-size: 0.65rem;">
                                        Subtotal
                                    </small>

                                    <span class="fw-bold text-purple-600">
                                        Rp {{ number_format($item->subtotal,0,',','.') }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="empty-state">

                            <i class="bi bi-cart-x-fill"></i>

                            <p class="mt-2 mb-0">
                                Tidak ada item pesanan
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">

            <!-- PAYMENT INFO -->
            <div class="modern-card mb-4">

                <div class="card-header">

                    <h5 class="fw-bold mb-0">
                        📋 Informasi Pembayaran
                    </h5>

                </div>

                <div class="card-body">

                    <div class="info-box mb-3">

                        <div class="label-title">
                            <i class="bi bi-receipt me-1"></i>
                            Order Number
                        </div>

                        <div class="value-text">
                            {{ $payment->order->order_number }}
                        </div>

                    </div>

                    <div class="info-box mb-3">

                        <div class="label-title">
                            <i class="bi bi-person me-1"></i>
                            Customer
                        </div>

                        <div class="value-text">
                            {{ $payment->order->user->name ?? '-' }}
                        </div>

                    </div>

                    <div class="info-box mb-3">

                        <div class="label-title">
                            <i class="bi bi-credit-card me-1"></i>
                            Metode Pembayaran
                        </div>

                        <div class="value-text">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">
                                {{ $payment->payment_type_label }}
                            </span>
                        </div>

                    </div>

                    <div class="info-box mb-3">

                        <div class="label-title">
                            <i class="bi bi-check-circle me-1"></i>
                            Status Pembayaran
                        </div>

                        <div class="mt-2">
                            <span class="status-badge 
                                @if(in_array($payment->status, ['settlement', 'capture'])) bg-green-100 text-green-700
                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ $payment->status_label }}
                            </span>
                        </div>

                    </div>

                    <div class="info-box mb-3">

                        <div class="label-title">
                            <i class="bi bi-upc-scan me-1"></i>
                            Transaction ID
                        </div>

                        <div class="value-text">
                            {{ $payment->transaction_id ?? '-' }}
                        </div>

                    </div>

                    <div class="summary-box mt-4">

                        <div class="label-title" style="color: rgba(255,255,255,0.7);">
                            💰 Total Pembayaran
                        </div>

                        <h2 class="mt-2 mb-0">
                            Rp {{ number_format($payment->order->total,0,',','.') }}
                        </h2>

                    </div>

                </div>

            </div>

            <!-- ACTION - MEDIABOOK THEME -->
            @if($payment->status == 'pending')

                <div class="modern-card">

                    <div class="card-header">

                        <h5 class="fw-bold mb-0">
                            ⚡ Aksi Admin
                        </h5>

                    </div>

                    <div class="card-body">

                        <!-- VERIFY -->
                        <form action="{{ route('admin.payments.verify', $payment) }}"
                              method="POST"
                              class="mb-3">

                            @csrf

                            <button type="submit"
                                    class="btn btn-verify btn-modern w-100">

                                <i class="bi bi-check-circle-fill me-2"></i>
                                Verifikasi Pembayaran

                            </button>

                        </form>

                        <!-- REJECT -->
                        <form action="{{ route('admin.payments.reject', $payment) }}"
                              method="POST">

                            @csrf

                            <textarea name="reason"
                                      class="form-control mb-3"
                                      rows="4"
                                      required
                                      placeholder="Masukkan alasan penolakan pembayaran..."></textarea>

                            <button type="submit"
                                    class="btn btn-reject btn-modern w-100">

                                <i class="bi bi-x-circle-fill me-2"></i>
                                Tolak Pembayaran

                            </button>

                        </form>

                        <div class="mt-3 text-muted small text-center">
                            <i class="bi bi-info-circle me-1"></i>
                            Pastikan bukti pembayaran valid sebelum verifikasi
                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

<!-- Tambahkan Font Google -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap');

    .text-purple-600 {
        color: #7c3aed;
    }

    .bg-purple-50 {
        background-color: #faf5ff;
    }

    .bg-purple-100 {
        background-color: #ede9fe;
    }

    .text-purple-700 {
        color: #5b21b6;
    }

    .border-purple-200 {
        border-color: #ddd6fe;
    }
</style>

@endsection
