@extends('layouts.customer')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('customer.orders.index') }}" class="text-decoration-none">
            Pesanan Saya
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ $order->order_number }}
    </li>
@endsection

@section('content')

<style>
    /* ==================== HOME THEME STYLES ==================== */
    html, body {
        overflow-x: hidden;
        background: #f1f5f9;
    }
    
    body {
        background: #f1f5f9;
    }
    
    /* Card Styles - Tanpa hover effect */
    .order-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
        background: white;
    }
    
    /* Header Card dengan gradient */
    .card-header-gradient {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 1.2rem 1.5rem;
        border: none;
        font-weight: 700;
    }
    
    .card-header-gradient i {
        margin-right: 8px;
        color: #a78bfa;
    }
    
    /* Status Badge */
    .status-badge {
        padding: 8px 24px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .status-badge i {
        font-size: 1rem;
    }
    
    /* Timeline Styles */
    .timeline-wrapper {
        position: relative;
        padding: 20px 0;
    }
    
    .timeline-item {
        position: relative;
        padding-left: 55px;
        padding-bottom: 35px;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 42px;
        height: 42px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #64748b;
        z-index: 2;
    }
    
    .timeline-icon.active {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        box-shadow: 0 8px 20px rgba(139,92,246,.25);
    }
    
    .timeline-icon.completed {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 8px 20px rgba(16,185,129,.25);
    }
    
    .timeline-line {
        position: absolute;
        left: 20px;
        top: 42px;
        width: 2px;
        height: calc(100% - 42px);
        background: linear-gradient(to bottom, #e2e8f0, #cbd5e1);
    }
    
    .timeline-item:last-child .timeline-line {
        display: none;
    }
    
    /* Product Image */
    .product-image-order {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 18px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* Table Styles */
    .table-order {
        margin-bottom: 0;
    }
    
    .table-order thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        font-weight: 700;
        color: #0f172a;
        padding: 1rem;
    }
    
    .table-order tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table-order tfoot td {
        background: #f8fafc;
        padding: 1rem;
        font-weight: 700;
    }
    
    /* Button Styles - Tanpa efek gerakan */
    .btn-primary-custom {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border: none;
        border-radius: 16px;
        padding: 12px 24px;
        font-weight: 700;
        color: white;
        cursor: pointer;
    }
    
    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: white;
    }
    
    .btn-outline-custom {
        border-radius: 16px;
        padding: 10px 24px;
        font-weight: 600;
        border: 2px solid #e2e8f0;
        background: white;
        color: #0f172a;
        cursor: pointer;
    }
    
    .btn-outline-custom:hover {
        border-color: #8b5cf6;
        background: #8b5cf6;
        color: white;
    }
    
    .btn-warning-custom {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        border-radius: 16px;
        padding: 12px;
        font-weight: 700;
        color: white;
        cursor: pointer;
    }
    
    .btn-warning-custom:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: white;
    }
    
    /* Alert Styles */
    .alert-custom {
        border: none;
        border-radius: 20px;
        padding: 1rem 1.25rem;
        backdrop-filter: blur(10px);
    }
    
    .alert-warning-custom {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }
    
    .alert-info-custom {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #6d28d9;
    }
    
    .alert-success-custom {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }
    
    .alert-danger-custom {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }
    
    /* Info Row */
    .info-row {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    /* Payment Proof */
    .payment-proof {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    
    /* Address Card */
    .address-card {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 20px;
        padding: 20px;
    }
    
    /* Qty Badge */
    .qty-badge {
        background: #eff6ff;
        color: #8b5cf6;
        padding: 6px 16px;
        border-radius: 999px;
        font-weight: 600;
        display: inline-block;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .timeline-item {
            padding-left: 45px;
            padding-bottom: 25px;
        }
        
        .timeline-icon {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
        
        .timeline-line {
            left: 17px;
        }
        
        .product-image-order {
            width: 50px;
            height: 50px;
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 6px 16px;
        }
        
        .table-order {
            font-size: 0.85rem;
        }
        
        .table-order td, 
        .table-order th {
            padding: 0.75rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="order-card mb-4">
        <div class="card-header-gradient d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="mb-1 fw-bold">
                    <i class="bi bi-receipt"></i> Detail Pesanan
                </h4>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-upc-scan"></i> {{ $order->order_number }}
                </p>
            </div>
            <div>
                @if($order->status === 'pending')
                    <span class="status-badge" style="background: linear-gradient(135deg, #64748b, #475569); color: white;">
                        <i class="bi bi-hourglass-split"></i> Menunggu Diproses
                    </span>
                @elseif($order->status === 'processed')
                    <span class="status-badge" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
                        <i class="bi bi-arrow-repeat"></i> Sedang Diproses
                    </span>
                @elseif($order->status === 'shipped')
                    <span class="status-badge" style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white;">
                        <i class="bi bi-truck"></i> Sedang Dikirim
                    </span>
                @elseif($order->status === 'completed')
                    <span class="status-badge" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
                        <i class="bi bi-check2-circle"></i> Selesai
                    </span>
                @elseif($order->status === 'cancelled')
                    <span class="status-badge" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white;">
                        <i class="bi bi-x-octagon"></i> Dibatalkan
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- LEFT COLUMN -->
        <div class="col-lg-8">
            <!-- Order Items Card -->
            <div class="order-card mb-4">
                <div class="card-header-gradient">
                    <i class="bi bi-list-check"></i> Item Pesanan
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-order align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th width="100" class="text-center">Qty</th>
                                    <th width="150" class="text-end">Harga</th>
                                    <th width="150" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="product-image-order">
                                                @endif
                                                <div>
                                                    <strong class="text-dark">{{ $item->product?->name }}</strong>
                                                    @if($item->product?->sku)
                                                        <br>
                                                        <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="qty-badge">{{ $item->qty }}</span>
                                        </td>
                                        <td class="text-end text-muted">{{ $item->formatted_price }}</td>
                                        <td class="text-end fw-bold" style="color:#8b5cf6;">{{ $item->formatted_subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fs-5 fw-bold">Total Pesanan:</td>
                                    <td class="text-end">
                                        <strong class="text-success fs-3">{{ $order->formatted_total }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shipping Address Card -->
            <div class="order-card">
                <div class="card-header-gradient">
                    <i class="bi bi-geo-alt-fill"></i> Alamat Pengiriman
                </div>
                <div class="card-body">
                    <div class="address-card">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ede9fe, #e0d4fc); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-house-door fs-4" style="color: #8b5cf6;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-2 fw-bold">{{ $order->shippingAddress->recipient_name }}</h6>
                                <p class="mb-1 text-muted">
                                    <i class="bi bi-telephone"></i> {{ $order->shippingAddress->phone }}
                                </p>
                                <p class="mb-0">
                                    <i class="bi bi-pin-map"></i> {{ $order->shippingAddress->full_address }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">
            <!-- Payment Status Card -->
            <div class="order-card mb-4">
                <div class="card-header-gradient">
                    <i class="bi bi-credit-card"></i> Status Pembayaran
                </div>
                <div class="card-body">
                    @if($order->payment_status === 'unpaid')
                        <div class="alert-custom alert-warning-custom mb-3">
                            <i class="bi bi-exclamation-triangle-fill"></i> 
                            Pembayaran belum dilakukan
                        </div>
                        <a href="{{ route('customer.orders.pay', $order) }}" 
                           class="btn btn-primary-custom w-100">
                            <i class="bi bi-wallet2"></i> Bayar Sekarang
                        </a>
                        <small class="text-muted d-block text-center mt-2">
                            <i class="bi bi-shield-check"></i> Pembayaran aman melalui Midtrans
                        </small>
                    
                    @elseif($order->payment_status === 'pending')
                        <div class="alert-custom alert-info-custom mb-3">
                            <i class="bi bi-clock-history"></i> Menunggu pembayaran
                        </div>
                        <a href="{{ route('customer.orders.pay', $order) }}" 
                           class="btn btn-warning-custom w-100">
                            <i class="bi bi-arrow-repeat"></i> Bayar Sekarang
                        </a>
                        <small class="text-muted d-block text-center mt-2">
                            <i class="bi bi-hourglass"></i> Selesaikan pembayaran sebelum kedaluwarsa
                        </small>
                    
                    @elseif($order->payment_status === 'paid')
                        <div class="alert-custom alert-success-custom mb-3">
                            <i class="bi bi-check-circle-fill"></i> Pembayaran berhasil
                        </div>
                        <div class="info-row">
                            <small class="text-muted">Metode Pembayaran</small>
                            <p class="mb-0 fw-bold">{{ $order->payment?->payment_type_label ?? '-' }}</p>
                        </div>
                        <div class="info-row">
                            <small class="text-muted">Tanggal Pembayaran</small>
                            <p class="mb-0 fw-bold">
                                {{ $order->payment?->updated_at ? $order->payment->updated_at->translatedFormat('d M Y H:i') : '-' }}
                            </p>
                        </div>
                    
                    @elseif($order->payment_status === 'rejected')
                        <div class="alert-custom alert-danger-custom mb-3">
                            <i class="bi bi-x-circle-fill"></i> Pembayaran gagal / kedaluwarsa
                        </div>
                        <a href="{{ route('customer.orders.pay', $order) }}" 
                           class="btn btn-warning-custom w-100">
                            <i class="bi bi-arrow-repeat"></i> Bayar Ulang
                        </a>
                    @endif
                </div>
            </div>

            <!-- Order Status Timeline Card -->
            <div class="order-card">
                <div class="card-header-gradient">
                    <i class="bi bi-clock-history"></i> Timeline Pesanan
                </div>
                <div class="card-body">
                    <div class="timeline-wrapper">
                        <!-- Order Created -->
                        <div class="timeline-item">
                            <div class="timeline-icon active">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="timeline-line"></div>
                            <div>
                                <strong class="text-dark">Pesanan Dibuat</strong>
                                <br>
                                <small class="text-muted">
                                    {{ $order->created_at->translatedFormat('d M Y H:i') }}
                                </small>
                            </div>
                        </div>

                        <!-- Processed -->
                        <div class="timeline-item">
                            <div class="timeline-icon {{ in_array($order->status, ['processed', 'shipped', 'completed']) ? 'active' : '' }}">
                                <i class="bi bi-gear-fill"></i>
                            </div>
                            <div class="timeline-line"></div>
                            <div>
                                <strong class="text-dark">Pesanan Diproses</strong>
                                <br>
                                <small class="text-muted">
                                    @if(in_array($order->status, ['processed', 'shipped', 'completed']))
                                        Sedang disiapkan oleh toko
                                    @else
                                        Menunggu diproses
                                    @endif
                                </small>
                            </div>
                        </div>

                        <!-- Shipped -->
                        <div class="timeline-item">
                            <div class="timeline-icon {{ in_array($order->status, ['shipped', 'completed']) ? 'active' : '' }}">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div class="timeline-line"></div>
                            <div>
                                <strong class="text-dark">Pesanan Dikirim</strong>
                                <br>
                                <small class="text-muted">
                                    @if(in_array($order->status, ['shipped', 'completed']))
                                        Barang dalam perjalanan
                                    @else
                                        Belum dikirim
                                    @endif
                                </small>
                            </div>
                        </div>

                        <!-- Completed -->
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $order->status == 'completed' ? 'completed' : '' }}">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <div>
                                <strong class="{{ $order->status == 'completed' ? 'text-success' : 'text-dark' }}">
                                    Pesanan Selesai
                                </strong>
                                <br>
                                <small class="text-muted">
                                    @if($order->status == 'completed')
                                        Terima kasih telah berbelanja!
                                    @else
                                        Menunggu penyelesaian
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4 text-center">
        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-custom">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Daftar Pesanan
        </a>
    </div>
</div>

@endsection