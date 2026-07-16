@extends('layouts.admin')

@section('title', 'Buku Masuk - MediaBook')

@section('content')

<style>
    /* ==================== MEDIABOOK PREMIUM STYLES ==================== */
    body {
        background: #f8fafc;
    }

    /* Page Header Premium - MediaBook Theme */
    .page-header {
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        border-radius: 32px;
        padding: 2rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 30px -10px rgba(139,92,246,0.3);
    }

    .page-header::before {
        content: '📚';
        position: absolute;
        font-size: 12rem;
        opacity: 0.06;
        top: -60px;
        right: 20px;
        transform: rotate(15deg);
    }

    .page-header::after {
        content: '';
        position: absolute;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
        top: -120px;
        right: -80px;
    }

    .header-badge {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 1px;
        display: inline-block;
        margin-bottom: 0.8rem;
        color: rgba(255,255,255,0.9);
    }

    .page-header h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        color: white;
    }

    .page-header p {
        color: rgba(255,255,255,0.85);
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.1rem;
    }

    /* Card Premium */
    .modern-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 30px rgba(15,23,42,.06);
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .modern-card:hover {
        box-shadow: 0 15px 40px rgba(139,92,246,.08);
    }

    /* Table Premium */
    .table-modern {
        margin: 0;
        min-width: 600px;
        width: 100%;
    }

    .table-modern thead {
        background: linear-gradient(135deg, #faf5ff, #f3e8ff);
    }

    .table-modern thead th {
        border: none;
        padding: 1rem 1.25rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: #5b21b6;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .table-modern tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .table-modern tbody tr {
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background: #faf5ff;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    /* Product Info */
    .product-info {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: nowrap;
    }

    .product-avatar {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #ede9fe, #faf5ff);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8b5cf6;
        font-size: 1.2rem;
        flex-shrink: 0;
        border: 1px solid #ede9fe;
    }

    .product-details {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2px;
        font-family: 'Playfair Display', serif;
        white-space: normal;
        word-break: break-word;
    }

    .product-author {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 0.85rem;
        color: #64748b;
    }

    .product-category {
        font-size: 0.65rem;
        background: #ede9fe;
        color: #5b21b6;
        padding: 2px 10px;
        border-radius: 999px;
        display: inline-block;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Qty Badge */
    .qty-badge {
        background: linear-gradient(135deg, #dbeafe, #ede9fe);
        color: #5b21b6;
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .qty-badge i {
        font-size: 0.9rem;
        color: #8b5cf6;
    }

    /* Supplier Badge */
    .supplier-badge {
        background: #f8fafc;
        color: #475569;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        border: 1px solid #e2e8f0;
    }

    .supplier-badge i {
        color: #8b5cf6;
    }

    /* Notes */
    .notes-text {
        color: #64748b;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .notes-text i {
        color: #8b5cf6;
        flex-shrink: 0;
    }

    /* Date */
    .date-cell {
        font-weight: 600;
        color: #0f172a;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .date-cell i {
        color: #8b5cf6;
    }

    /* Button Modern */
    .btn-modern {
        border: none;
        border-radius: 18px;
        padding: 12px 28px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        color: white;
        box-shadow: 0 4px 15px rgba(139,92,246,0.25);
    }

    .btn-primary-modern:hover {
        background: linear-gradient(135deg, #6d28d9, #5b21b6);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(139,92,246,0.35);
    }

    .btn-light-modern {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .btn-light-modern:hover {
        background: rgba(255,255,255,0.25);
        color: white;
        transform: translateY(-2px);
    }

    /* Alert Premium */
    .alert-premium {
        border: none;
        border-radius: 20px;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 4px 12px rgba(21,128,61,0.1);
        margin-bottom: 1.5rem;
    }

    .alert-premium i {
        font-size: 1.2rem;
        color: #16a34a;
    }

    /* Empty State Premium */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #faf5ff, #ede9fe);
        border-radius: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #c4b5fd;
    }

    .empty-icon i {
        font-size: 3rem;
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        font-family: 'Playfair Display', serif;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #64748b;
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.05rem;
        margin-bottom: 1.5rem;
    }

    /* Statistik Cards - MediaBook Theme */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 1.2rem 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: #c4b5fd;
        box-shadow: 0 8px 25px rgba(139,92,246,0.08);
        transform: translateY(-2px);
    }

    .stat-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-family: 'Playfair Display', serif;
    }

    .stat-sub {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 4px;
        display: block;
    }

    /* Footer Info */
    .footer-info {
        margin-top: 1rem;
        text-align: center;
        padding: 0.75rem;
        background: linear-gradient(135deg, #faf5ff, #f3e8ff);
        border-radius: 16px;
        color: #5b21b6;
        font-size: 0.85rem;
        font-weight: 500;
        border: 1px solid #ede9fe;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }

        .stat-value {
            font-size: 1.3rem;
        }

        .table-modern thead th {
            padding: 0.75rem 1rem;
            font-size: 0.7rem;
        }

        .table-modern tbody td {
            padding: 0.75rem 1rem;
        }

        .product-avatar {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        .product-name {
            font-size: 0.85rem;
        }

        .qty-badge {
            padding: 4px 10px;
            font-size: 0.75rem;
        }

        .supplier-badge {
            padding: 4px 10px;
            font-size: 0.7rem;
        }

        .date-cell {
            font-size: 0.8rem;
        }

        .btn-light-modern {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modern-card {
        animation: fadeIn 0.4s ease;
    }

    .alert-premium {
        animation: fadeIn 0.4s ease;
    }

    .stat-card {
        animation: fadeIn 0.5s ease;
    }
</style>

<div class="container-fluid px-0">

    <!-- HEADER PREMIUM - MEDIABOOK THEME -->
    <div class="page-header">
        <div class="position-relative d-flex justify-content-between align-items-center flex-wrap gap-3" style="position: relative; z-index: 2;">
            <div>
                <div class="header-badge">
                    <i class="bi bi-book me-2"></i>
                    📚 INVENTORY MANAGEMENT
                </div>
                <h1 class="fw-bold mb-2" style="font-size: 2rem;">
                    <i class="bi bi-arrow-down-circle-fill me-2"></i>
                    Buku Masuk
                </h1>
                <p class="opacity-75 mb-0">
                    Riwayat buku masuk ke gudang MediaBook
                </p>
            </div>
            <a href="{{ route('admin.stock-ins.create') }}" class="btn btn-light-modern btn-modern">
                <i class="bi bi-plus-circle me-2"></i>
                Tambah Buku
            </a>
        </div>
    </div>

    <!-- Statistik Ringkasan - MediaBook Theme -->
    @php
        $totalStockIn = $stockIns->sum('qty');
        $totalProducts = $stockIns->groupBy('product_id')->count();
        $lastUpdate = $stockIns->isNotEmpty() ? $stockIns->first()->created_at : null;
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">📚 Total Buku Masuk</div>
            <div class="stat-value">{{ number_format($totalStockIn) }}</div>
            <span class="stat-sub"><i class="bi bi-box"></i> Eksemplar</span>
        </div>
        <div class="stat-card">
            <div class="stat-label">📖 Total Judul</div>
            <div class="stat-value">{{ $totalProducts }}</div>
            <span class="stat-sub"><i class="bi bi-grid"></i> Jenis Buku</span>
        </div>
        <div class="stat-card">
            <div class="stat-label">📋 Total Transaksi</div>
            <div class="stat-value">{{ $stockIns->count() }}</div>
            <span class="stat-sub"><i class="bi bi-receipt"></i> Kali Masuk</span>
        </div>
        @if($lastUpdate)
        <div class="stat-card">
            <div class="stat-label">🔄 Update Terakhir</div>
            <div class="stat-value" style="font-size: 1.2rem;">{{ $lastUpdate->translatedFormat('d M Y') }}</div>
            <span class="stat-sub"><i class="bi bi-clock"></i> {{ $lastUpdate->diffForHumans() }}</span>
        </div>
        @endif
    </div>

    <!-- SUCCESS ALERT PREMIUM -->
    @if(session('success'))
        <div class="alert-premium">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- TABLE PREMIUM - MEDIABOOK THEME -->
    <div class="modern-card">
        <div class="table-responsive">
            <table class="table table-modern align-middle">
                <thead>
                    <tr>
                        <th><i class="bi bi-calendar3 me-2"></i> Tanggal</th>
                        <th><i class="bi bi-book me-2"></i> Buku</th>
                        <th><i class="bi bi-building me-2"></i> Penerbit</th>
                        <th class="text-center"><i class="bi bi-sort-numeric-down me-2"></i> Qty</th>
                        <th><i class="bi bi-file-text me-2"></i> Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockIns as $stock)
                        <tr>
                            <td class="date-cell">
                                <i class="bi bi-calendar-check"></i>
                                {{ \Carbon\Carbon::parse($stock->tanggal_masuk)->translatedFormat('d M Y') }}
                            </td>
                            <td>
                                <div class="product-info">
                                    <div class="product-avatar">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <div class="product-details">
                                        <div class="product-name">{{ $stock->product->name ?? 'Buku dihapus' }}</div>
                                        @if(isset($stock->product->author))
                                            <div class="product-author">
                                                <i class="bi bi-pencil-fill me-1" style="font-size: 0.6rem;"></i>
                                                {{ $stock->product->author }}
                                            </div>
                                        @endif
                                        <span class="product-category">
                                            {{ $stock->product->category->name ?? 'Tanpa Genre' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($stock->supplier && $stock->supplier_id)
                                    <span class="supplier-badge">
                                        <i class="bi bi-building"></i>
                                        {{ $stock->supplier->name ?? 'Penerbit' }}
                                    </span>
                                @else
                                    <span class="supplier-badge">
                                        <i class="bi bi-dash-circle"></i>
                                        Tidak Ada
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="qty-badge">
                                    <i class="bi bi-arrow-down-circle-fill"></i>
                                    +{{ number_format($stock->qty) }}
                                </span>
                            </td>
                            <td>
                                @if($stock->keterangan)
                                    <div class="notes-text">
                                        <i class="bi bi-chat-text"></i>
                                        <span>{{ $stock->keterangan }}</span>
                                    </div>
                                @else
                                    <div class="notes-text">
                                        <i class="bi bi-dash-circle"></i>
                                        <span class="text-muted">Tidak ada catatan</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-inboxes"></i>
                                    </div>
                                    <h4 class="empty-title">
                                        Belum Ada Data Buku Masuk
                                    </h4>
                                    <p class="empty-text">
                                        Tambahkan stok buku pertama untuk gudang MediaBook.
                                    </p>
                                    <a href="{{ route('admin.stock-ins.create') }}" class="btn btn-primary-modern btn-modern">
                                        <i class="bi bi-plus-circle me-2"></i>
                                        Tambah Buku Masuk
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Info -->
    @if($stockIns->isNotEmpty())
    <div class="footer-info">
        <i class="bi bi-database me-2"></i>
        Menampilkan {{ $stockIns->count() }} data buku masuk
        @if($totalStockIn > 0)
            <span class="mx-2">•</span>
            <i class="bi bi-boxes me-1"></i>
            Total {{ number_format($totalStockIn) }} eksemplar buku masuk
        @endif
    </div>
    @endif
</div>

<!-- Tambahkan Font Google -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap');
</style>

@endsection
