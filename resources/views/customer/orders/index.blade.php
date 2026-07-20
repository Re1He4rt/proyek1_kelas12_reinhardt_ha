@extends('layouts.customer')

@section('title', 'Pesanan Saya')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pesanan Saya</li>
@endsection

@section('content')
<style>
    /* ==================== PREMIUM THEME STYLES ==================== */
    html, body {
        overflow-x: hidden;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        min-height: 100vh;
    }
    
    body {
        background: transparent;
    }
    
    /* Card Styles - Tanpa hover effect */
    .order-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 20px 35px -10px rgba(0,0,0,0.1);
    }
    
    /* Section Header */
    .section-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        background-size: 200% 200%;
        animation: gradientShift 3s ease infinite;
        border-radius: 32px;
        padding: 2rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 30px -10px rgba(15,23,42,0.3);
    }
    
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    .section-header::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, rgba(167,139,250,0.1), rgba(139,92,246,0.05));
        border-radius: 50%;
        top: -150px;
        right: -150px;
        animation: float 6s ease-in-out infinite;
    }
    
    .section-header::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, rgba(167,139,250,0.08), rgba(139,92,246,0.04));
        border-radius: 50%;
        bottom: -100px;
        left: -100px;
        animation: float 4s ease-in-out infinite reverse;
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(20px, -20px); }
    }
    
    .section-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #fff, #94a3b8);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin: 0;
        position: relative;
        z-index: 2;
        letter-spacing: -0.5px;
    }
    
    .section-title i {
        background: linear-gradient(135deg, #a78bfa, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-right: 12px;
    }
    
    /* Table Styles - Tanpa hover effect */
    .table-order {
        margin-bottom: 0;
    }
    
    .table-order thead th {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        border: none;
        font-weight: 700;
        padding: 1.2rem 1.5rem;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
    }
    
    .table-order thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #8b5cf6, #a78bfa, #8b5cf6);
    }
    
    .table-order tbody td {
        padding: 1.2rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #eef2ff;
        color: #334155;
    }
    
    .table-order tbody tr {
        transition: background 0.2s ease;
    }
    
    /* Hanya background yang berubah saat hover, tanpa gerakan */
    .table-order tbody tr:hover {
        background: #f8fafc;
    }
    
    .table-order tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Status Badge Premium */
    .status-badge {
        padding: 8px 18px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    
    .status-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .status-badge:hover::before {
        left: 100%;
    }
    
    /* Payment Badge Premium */
    .payment-badge {
        padding: 8px 18px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    /* Order Number */
    .order-number {
        font-weight: 800;
        background: linear-gradient(135deg, #0f172a, #334155);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-size: 1rem;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    /* Total Amount */
    .total-amount {
        font-weight: 800;
        background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-size: 1.1rem;
        display: inline-block;
    }
    
    /* Button Detail - Tanpa efek ripple yang mengganggu */
    .btn-detail {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border: none;
        border-radius: 14px;
        padding: 8px 22px;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-detail:hover {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: white;
    }
    
    /* Empty State Premium */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 32px;
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 20px 35px -10px rgba(0,0,0,0.1);
    }
    
    .empty-icon {
        width: 140px;
        height: 140px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #ede9fe, #f5f3ff);
        border-radius: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: float 3s ease-in-out infinite;
        box-shadow: 0 10px 30px rgba(139,92,246,0.1);
    }
    
    .empty-icon i {
        font-size: 4rem;
        background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    
    .empty-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #0f172a, #334155);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 0.5rem;
    }
    
    .empty-text {
        color: #64748b;
        margin-bottom: 2rem;
        font-size: 1rem;
    }
    
    .btn-shop {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border: none;
        border-radius: 18px;
        padding: 14px 36px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.2s ease;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    
    .btn-shop:hover {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: white;
    }
    
    /* Filter Tabs Premium */
    .filter-tabs {
        display: flex;
        gap: 12px;
        margin-bottom: 28px;
        flex-wrap: wrap;
        padding: 5px 0;
    }
    
    .filter-tab {
        padding: 10px 26px;
        border-radius: 50px;
        font-weight: 700;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(5px);
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid rgba(226,232,240,0.8);
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .filter-tab:hover {
        border-color: #8b5cf6;
        color: #8b5cf6;
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        border-color: transparent;
        box-shadow: 0 8px 20px -5px rgba(139,92,246,0.3);
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 1.2rem;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.2s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 5px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .section-header {
            padding: 1.2rem 1.5rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .table-order thead th {
            padding: 0.8rem 1rem;
            font-size: 0.7rem;
        }
        
        .table-order tbody td {
            padding: 0.8rem 1rem;
        }
        
        .status-badge,
        .payment-badge {
            padding: 5px 12px;
            font-size: 0.7rem;
        }
        
        .order-number {
            font-size: 0.85rem;
        }
        
        .total-amount {
            font-size: 0.95rem;
        }
        
        .btn-detail {
            padding: 6px 14px;
            font-size: 0.7rem;
        }
        
        .filter-tab {
            padding: 6px 16px;
            font-size: 0.8rem;
        }
        
        .empty-title {
            font-size: 1.5rem;
        }
        
        .empty-icon {
            width: 100px;
            height: 100px;
        }
        
        .empty-icon i {
            font-size: 2.8rem;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .order-card {
        animation: fadeInUp 0.4s ease;
    }
</style>

<div>
    <!-- Header Section dengan Gradient Animasi -->
    <div class="section-header">
        <h2 class="section-title">
            <i class="bi bi-receipt"></i> 
            Pesanan Saya
        </h2>
    </div>

    @if($totalOrders > 0)
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $totalOrders }}</div>
                <div class="stat-label">Total Pesanan</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $completedOrders }}</div>
                <div class="stat-label">Pesanan Selesai</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $pendingOrders }}</div>
                <div class="stat-label">Sedang Diproses</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                <div class="stat-label">Total Belanja</div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs" id="filterTabs">
            <button class="filter-tab active" data-filter="all">
                <i class="bi bi-grid-3x3-gap-fill"></i> Semua
                <span class="badge bg-light text-dark ms-1 rounded-pill">{{ $totalOrders }}</span>
            </button>
            <button class="filter-tab" data-filter="pending">
                <i class="bi bi-hourglass-split"></i> Menunggu
            </button>
            <button class="filter-tab" data-filter="processed">
                <i class="bi bi-arrow-repeat"></i> Diproses
            </button>
            <button class="filter-tab" data-filter="shipped">
                <i class="bi bi-truck"></i> Dikirim
            </button>
            <button class="filter-tab" data-filter="completed">
                <i class="bi bi-check2-circle"></i> Selesai
            </button>
            <button class="filter-tab" data-filter="cancelled">
                <i class="bi bi-x-octagon"></i> Dibatalkan
            </button>
        </div>

        <!-- Card dengan Tabel - Tanpa efek hover bergerak -->
        <div class="order-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-order mb-0">
                        <thead>
                            <tr>
                                <th>No. Order</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status Pesanan</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTableBody">
                            @foreach($orders->sortByDesc('created_at') as $order)
                                <tr class="order-row" data-status="{{ $order->status }}">
                                    <td>
                                        <span class="order-number">
                                            <i class="bi bi-upc-scan"></i> {{ $order->order_number }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="bi bi-calendar3"></i> 
                                        {{ $order->created_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="total-amount">{{ $order->formatted_total }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'secondary',
                                                'processed' => 'primary',
                                                'shipped' => 'info',
                                                'completed' => 'success',
                                                'cancelled' => 'danger'
                                            ];
                                            $statusIcons = [
                                                'pending' => 'hourglass-split',
                                                'processed' => 'arrow-repeat',
                                                'shipped' => 'truck',
                                                'completed' => 'check2-circle',
                                                'cancelled' => 'x-octagon'
                                            ];
                                        @endphp
                                        <span class="status-badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                            <i class="bi bi-{{ $statusIcons[$order->status] ?? 'tag' }}"></i>
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($order->payment_status === 'paid')
                                            <span class="payment-badge" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46;">
                                                <i class="bi bi-check-circle-fill"></i> Lunas
                                            </span>
                                        @elseif($order->payment_status === 'pending')
                                            <span class="payment-badge" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e;">
                                                <i class="bi bi-clock-history"></i> Verifikasi
                                            </span>
                                        @elseif($order->payment_status === 'rejected')
                                            <span class="payment-badge" style="background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b;">
                                                <i class="bi bi-x-circle-fill"></i> Ditolak
                                            </span>
                                        @elseif($order->payment_status === 'unpaid')
                                            <span class="payment-badge" style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); color: #475569;">
                                                <i class="bi bi-credit-card"></i> Belum Bayar
                                            </span>
                                        @else
                                            <span class="payment-badge" style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); color: #475569;">
                                                {{ $order->payment_status_label }}
                                            </span>
                                        @endif
                                      </td>
                                    <td>
                                        <a href="{{ route('customer.orders.show', $order) }}" 
                                           class="btn btn-detail">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                      </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h3 class="empty-title">Belum Ada Pesanan</h3>
            <p class="empty-text">
                Anda belum memiliki pesanan apapun.<br>
                Yuk, mulai belanja sekarang!
            </p>
            <a href="{{ route('customer.shop.index') }}" class="btn btn-shop">
                <i class="bi bi-grid"></i> Mulai Belanja
            </a>
        </div>
    @endif
</div>

@if($totalOrders > 0)
<script>
    // Filter functionality untuk pesanan
    const filterTabs = document.querySelectorAll('.filter-tab');
    const orderRows = document.querySelectorAll('.order-row');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            // Filter rows
            orderRows.forEach(row => {
                if (filterValue === 'all' || row.getAttribute('data-status') === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Show/hide empty message jika diperlukan
            const visibleRows = Array.from(orderRows).filter(row => row.style.display !== 'none');
            const tableBody = document.getElementById('ordersTableBody');
            const existingEmptyMsg = document.querySelector('.filter-empty-msg');
            
            if (visibleRows.length === 0 && !existingEmptyMsg) {
                const emptyMsg = document.createElement('tr');
                emptyMsg.className = 'filter-empty-msg';
                emptyMsg.innerHTML = `
                    <td colspan="6" class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #cbd5e1;"></i>
                        <p class="mt-3 text-muted">Tidak ada pesanan dengan status ini</p>
                    </td>
                `;
                tableBody.appendChild(emptyMsg);
            } else if (visibleRows.length > 0 && existingEmptyMsg) {
                existingEmptyMsg.remove();
            }
        });
    });
</script>
@endif
@endsection