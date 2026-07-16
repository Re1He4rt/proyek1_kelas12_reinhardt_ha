@extends('layouts.admin')

@section('title', 'Buku Keluar - MediaBook')

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

    .btn-add{
        background: #ef4444;
        border: none;
        border-radius:16px;
        padding:12px 28px;
        font-weight:700;
        color: white;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(239,68,68,.3);
    }

    .btn-add:hover{
        background: #dc2626;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(239,68,68,.35);
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
        padding:20px 28px;
    }

    .modern-card .card-header h5{
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #5b21b6;
    }

    .modern-card .card-body{
        padding:0;
    }

    .table-modern{
        width:100%;
        border-collapse:collapse;
    }

    .table-modern thead{
        background: #f8fafc;
    }

    .table-modern thead th{
        padding:16px 24px;
        text-align:left;
        font-weight:600;
        color:#475569;
        font-size:0.85rem;
        text-transform:uppercase;
        letter-spacing:0.5px;
    }

    .table-modern tbody td{
        padding:16px 24px;
        border-top:1px solid #f1f5f9;
        color:#0f172a;
        vertical-align:middle;
    }

    .table-modern tbody tr{
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover{
        background: #faf5ff;
    }

    .badge-stock-out{
        background: #fee2e2;
        color: #991b1b;
        padding:6px 14px;
        border-radius:999px;
        font-size:0.8rem;
        font-weight:600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-order{
        background: #dbeafe;
        color: #1e40af;
        padding:4px 12px;
        border-radius:999px;
        font-size:0.75rem;
        font-weight:600;
    }

    .empty-state{
        padding: 60px 20px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-state i{
        font-size: 4rem;
        color: #c4b5fd;
        margin-bottom: 16px;
        display: block;
    }

    .product-name-cell{
        font-weight:600;
        color:#0f172a;
    }

    .product-author-cell{
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: #64748b;
        font-size: 0.85rem;
    }

    .qty-number{
        font-weight:700;
        font-size:1.1rem;
    }

    .qty-negative{
        color: #dc2626;
    }

    .reason-text{
        font-size:0.85rem;
        color:#64748b;
    }

    .date-cell{
        display: flex;
        align-items: center;
        gap: 8px;
        color: #475569;
    }

    .date-cell i{
        color: #8b5cf6;
    }

    @media(max-width:768px){
        .page-header{
            padding:25px;
        }

        .table-modern thead th,
        .table-modern tbody td{
            padding:12px 16px;
            font-size:0.85rem;
        }

        .btn-add{
            width:100%;
            justify-content:center;
        }

        .header-actions{
            width:100%;
            flex-direction:column;
        }
    }
</style>

<div class="container-fluid py-4">

    <!-- HEADER - MEDIABOOK THEME -->
    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h2 class="page-title mb-1">
                    📤 Buku Keluar
                </h2>

                <p class="page-subtitle mb-0">
                    Riwayat buku keluar dari gudang MediaBook
                </p>

            </div>

            <a href="{{ route('admin.stock-outs.create') }}"
               class="btn-add">

                <i class="bi bi-plus-circle"></i>
                Buku Keluar

            </a>

        </div>

    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-green-500"></i>
            {{ session('success') }}
        </div>

    @endif

    <!-- TABLE - MEDIABOOK THEME -->
    <div class="modern-card">

        <div class="card-header">

            <h5 class="fw-bold mb-0">
                📋 Riwayat Buku Keluar
            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table-modern">

                    <thead>

                        <tr>

                            <th>
                                <i class="bi bi-calendar3 me-1"></i>
                                Tanggal
                            </th>

                            <th>
                                <i class="bi bi-book me-1"></i>
                                Buku
                            </th>

                            <th>
                                <i class="bi bi-hash me-1"></i>
                                Qty
                            </th>

                            <th>
                                <i class="bi bi-info-circle me-1"></i>
                                Keterangan
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($stockOuts as $stock)

                            <tr>

                                <!-- TANGGAL -->
                                <td>

                                    <span class="date-cell">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $stock->tanggal_keluar->format('d M Y') }}
                                    </span>

                                </td>

                                <!-- PRODUK -->
                                <td>

                                    <div>

                                        <div class="product-name-cell">
                                            {{ $stock->product->name }}
                                        </div>

                                        @if(isset($stock->product->author))
                                            <div class="product-author-cell">
                                                <i class="bi bi-pencil-fill me-1" style="font-size: 0.6rem;"></i>
                                                {{ $stock->product->author }}
                                            </div>
                                        @endif

                                        <div class="mt-1">
                                            <span class="badge-order">
                                                {{ $stock->product->category->name ?? 'Tanpa Kategori' }}
                                            </span>
                                        </div>

                                    </div>

                                </td>

                                <!-- QTY -->
                                <td>

                                    <span class="badge-stock-out">
                                        <i class="bi bi-box-arrow-up"></i>
                                        -{{ $stock->qty }}
                                    </span>

                                </td>

                                <!-- KETERANGAN -->
                                <td>

                                    @if($stock->keterangan)

                                        <span class="reason-text">
                                            <i class="bi bi-chat me-1"></i>
                                            {{ $stock->keterangan }}
                                        </span>

                                    @else

                                        <span class="text-muted" style="font-size:0.85rem;">
                                            <i class="bi bi-dash-circle me-1"></i>
                                            Tidak ada keterangan
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4">

                                    <div class="empty-state">

                                        <i class="bi bi-box-arrow-up"></i>

                                        <h5 class="fw-bold text-slate-600">
                                            Belum ada riwayat buku keluar
                                        </h5>

                                        <p class="text-muted">
                                            Mulai catat pengurangan stok buku dari gudang MediaBook.
                                        </p>

                                        <a href="{{ route('admin.stock-outs.create') }}"
                                           class="btn-add mt-3" style="display: inline-flex;">

                                            <i class="bi bi-plus-circle"></i>
                                            Tambah Buku Keluar

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- PAGINATION -->
    @if($stockOuts->hasPages())

        <div class="mt-6 d-flex justify-content-center">

            {{ $stockOuts->links() }}

        </div>

    @endif

</div>

<!-- Tambahkan Font Google & Pagination Styling -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap');

    /* Pagination styling */
    .pagination{
        gap: 8px;
    }

    .pagination .page-link{
        border: none;
        border-radius: 12px !important;
        padding: 10px 16px;
        color: #0f172a;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .05);
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover{
        background: #8b5cf6;
        color: white;
    }

    .pagination .page-item.active .page-link{
        background: #8b5cf6;
        color: white;
    }

    .pagination .page-item.disabled .page-link{
        opacity: .5;
    }

    /* Table responsive */
    @media (max-width: 640px) {
        .table-modern {
            font-size: 0.85rem;
        }

        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 12px;
        }

        .badge-order {
            font-size: 0.65rem;
            padding: 2px 8px;
        }

        .empty-state i {
            font-size: 3rem;
        }
    }
</style>

@endsection
