@extends('layouts.admin')

@section('title', 'Laporan Stok - MediaBook')

@section('content')

<!-- HEADER - MEDIABOOK THEME -->
<div class="mb-8">

    <h2 class="text-3xl font-bold text-slate-800" style="font-family: 'Playfair Display', serif; font-weight: 800;">
        📦 Laporan Stok Buku
    </h2>

    <p class="text-slate-500 mt-1" style="font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 1.1rem;">
        Monitoring stok buku di gudang MediaBook.
    </p>

</div>

<!-- SUMMARY - MEDIABOOK THEME -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Total Buku -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl transition group">

        <p class="text-slate-500 text-sm font-medium">
            📚 Total Buku
        </p>

        <h3 class="text-4xl font-bold mt-2 text-slate-800 group-hover:text-purple-600 transition">
            {{ $products->count() }}
        </h3>

    </div>

    <!-- Low Stock -->
    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-3xl p-6 shadow-sm border border-yellow-200 hover:shadow-xl transition group">

        <p class="text-yellow-700 text-sm font-medium">
            ⚠️ Stok Menipis
        </p>

        <h3 class="text-4xl font-bold mt-2 text-yellow-800 group-hover:text-yellow-600 transition">
            {{ $products->where('stock', '<=', 5)->where('stock', '>', 0)->count() }}
        </h3>

        <p class="text-xs text-yellow-600 mt-1">
            Buku dengan stok ≤ 5
        </p>

    </div>

    <!-- Out Of Stock -->
    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-3xl p-6 shadow-sm border border-red-200 hover:shadow-xl transition group">

        <p class="text-red-700 text-sm font-medium">
            🚫 Stok Habis
        </p>

        <h3 class="text-4xl font-bold mt-2 text-red-800 group-hover:text-red-600 transition">
            {{ $products->where('stock', 0)->count() }}
        </h3>

        <p class="text-xs text-red-600 mt-1">
            Buku yang perlu segera di-restock
        </p>

    </div>

</div>

<!-- TABLE - MEDIABOOK THEME -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        📖 Judul Buku
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        📌 Genre
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        💰 Harga
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        📦 Stok
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                    <tr class="border-t hover:bg-purple-50 transition">

                        <td class="px-6 py-5 font-semibold text-slate-800">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-book text-purple-500"></i>
                                {{ $product->name }}
                            </div>
                        </td>

                        <td class="px-6 py-5 text-slate-700">
                            <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-sm">
                                {{ $product->category->name }}
                            </span>
                        </td>

                        <td class="px-6 py-5 text-purple-600 font-bold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-5">

                            @php
                                $stock = $product->stock;
                                $badgeClass = '';
                                $badgeIcon = '';
                                $badgeText = '';

                                if($stock == 0) {
                                    $badgeClass = 'bg-red-100 text-red-700';
                                    $badgeIcon = '🚫';
                                    $badgeText = 'Habis';
                                } elseif($stock <= 5) {
                                    $badgeClass = 'bg-yellow-100 text-yellow-700';
                                    $badgeIcon = '⚠️';
                                    $badgeText = $stock . ' tersisa';
                                } elseif($stock <= 20) {
                                    $badgeClass = 'bg-orange-100 text-orange-700';
                                    $badgeIcon = '📦';
                                    $badgeText = $stock;
                                } else {
                                    $badgeClass = 'bg-green-100 text-green-700';
                                    $badgeIcon = '✅';
                                    $badgeText = $stock;
                                }
                            @endphp

                            <span class="{{ $badgeClass }} px-4 py-1.5 rounded-full text-sm font-semibold inline-flex items-center gap-1.5">
                                {{ $badgeIcon }}
                                {{ $badgeText }}
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4"
                            class="text-center py-16 text-slate-500">

                            <div class="flex flex-col items-center gap-3">

                                <i class="bi bi-inbox text-6xl text-slate-300"></i>

                                <p class="text-lg">
                                    Belum ada data buku.
                                </p>

                                <p class="text-sm">
                                    Tambahkan buku pertama Anda sekarang!
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- Tambahkan CSS Elegant -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap');

    /* Card hover effect */
    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    /* Table row hover */
    tbody tr {
        transition: all 0.2s ease;
    }

    /* Badge animation */
    .badge-pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    /* Custom scroll untuk table */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Responsive table */
    @media (max-width: 640px) {
        table {
            font-size: 0.9rem;
        }
        td, th {
            padding: 12px 10px !important;
        }
    }
</style>

@endsection
