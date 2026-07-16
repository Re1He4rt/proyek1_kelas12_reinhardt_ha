@extends('layouts.admin')

@section('title', 'Laporan Penjualan - MediaBook')

@section('content')

<!-- HEADER - MEDIABOOK THEME -->
<div class="flex justify-between items-center mb-8">

    <div>

        <h2 class="text-3xl font-bold text-slate-800" style="font-family: 'Playfair Display', serif; font-weight: 800;">
            📊 Laporan Penjualan
        </h2>

        <p class="text-slate-500 mt-1" style="font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 1.1rem;">
            Monitoring penjualan dan transaksi toko buku MediaBook.
        </p>

    </div>

    <!-- Tombol Export (Opsional) -->
    <div>
        <a href="{{ route('admin.reports.sales') }}?export=true&{{ http_build_query(request()->query()) }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-3 rounded-xl transition">
            <i class="bi bi-download me-2"></i>
            Export PDF
        </a>
    </div>

</div>

<!-- FILTER - TETAP SAMA STRUKTURNYA -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 mb-8">

    <form action="{{ route('admin.reports.sales') }}"
          method="GET"
          class="grid grid-cols-1 md:grid-cols-4 gap-5">

        <div>

            <label class="block text-sm font-semibold mb-2 text-slate-700">
                📅 Tanggal Mulai
            </label>

            <input type="date"
                   name="start_date"
                   value="{{ $startDate }}"
                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">

        </div>

        <div>

            <label class="block text-sm font-semibold mb-2 text-slate-700">
                📅 Tanggal Akhir
            </label>

            <input type="date"
                   name="end_date"
                   value="{{ $endDate }}"
                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">

        </div>

        <div>

            <label class="block text-sm font-semibold mb-2 text-slate-700">
                📌 Status
            </label>

            <select name="status"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">

                <option value="">Semua Status</option>

                <option value="pending"
                    {{ request('status') == 'pending' ? 'selected' : '' }}>
                    ⏳ Pending
                </option>

                <option value="processed"
                    {{ request('status') == 'processed' ? 'selected' : '' }}>
                    🔄 Processed
                </option>

                <option value="shipped"
                    {{ request('status') == 'shipped' ? 'selected' : '' }}>
                    📦 Shipped
                </option>

                <option value="completed"
                    {{ request('status') == 'completed' ? 'selected' : '' }}>
                    ✅ Completed
                </option>

                <option value="cancelled"
                    {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                    ❌ Cancelled
                </option>

            </select>

        </div>

        <div class="flex items-end gap-3">

            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl transition shadow-lg shadow-purple-200">

                <i class="bi bi-filter me-2"></i>
                Filter

            </button>

            <a href="{{ route('admin.reports.sales') }}"
               class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-xl transition">

                <i class="bi bi-arrow-counterclockwise me-2"></i>
                Reset

            </a>

        </div>

    </form>

</div>

<!-- SUMMARY - MEDIABOOK THEME -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <!-- Total Pesanan -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl transition group">

        <p class="text-slate-500 text-sm font-medium">
            📚 Total Pesanan
        </p>

        <h3 class="text-4xl font-bold mt-2 text-slate-800 group-hover:text-purple-600 transition">
            {{ $totalOrders }}
        </h3>

    </div>

    <!-- Pesanan Lunas -->
    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-3xl p-6 shadow-sm border border-green-200 hover:shadow-xl transition group">

        <p class="text-green-700 text-sm font-medium">
            ✅ Pesanan Lunas
        </p>

        <h3 class="text-4xl font-bold mt-2 text-green-800 group-hover:text-green-600 transition">
            {{ $paidOrders }}
        </h3>

    </div>

    <!-- Pendapatan -->
    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-3xl p-6 shadow-sm border border-purple-200 hover:shadow-xl transition group">

        <p class="text-purple-700 text-sm font-medium">
            💰 Pendapatan
        </p>

        <h3 class="text-3xl font-bold mt-2 text-purple-800 group-hover:text-purple-600 transition">
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </h3>

    </div>

    <!-- Rata-rata Order -->
    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-3xl p-6 shadow-sm border border-yellow-200 hover:shadow-xl transition group">

        <p class="text-yellow-700 text-sm font-medium">
            📊 Rata-rata Order
        </p>

        <h3 class="text-2xl font-bold mt-2 text-yellow-800 group-hover:text-yellow-600 transition">

            @if($paidOrders > 0)

                Rp {{ number_format($totalRevenue / $paidOrders, 0, ',', '.') }}

            @else

                Rp 0

            @endif

        </h3>

    </div>

</div>

<!-- TABLE - MEDIABOOK THEME -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-8">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        📋 Order
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        👤 Customer
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        💰 Total
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        📌 Status
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        💳 Payment
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-purple-800">
                        📅 Tanggal
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($orders as $order)

                    <tr class="border-t hover:bg-purple-50 transition">

                        <td class="px-6 py-5 font-semibold text-slate-800">
                            {{ $order->order_number }}
                        </td>

                        <td class="px-6 py-5 text-slate-700">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-person-circle text-purple-500"></i>
                                {{ $order->user->name }}
                            </div>
                        </td>

                        <td class="px-6 py-5 text-purple-600 font-bold">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-5">

                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'processed' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-indigo-100 text-indigo-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $statusIcons = [
                                    'pending' => '⏳',
                                    'processed' => '🔄',
                                    'shipped' => '📦',
                                    'completed' => '✅',
                                    'cancelled' => '❌',
                                ];
                            @endphp

                            <span class="{{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700' }} px-4 py-1.5 rounded-full text-sm font-semibold">
                                {{ $statusIcons[$order->status] ?? '' }}
                                {{ ucfirst($order->status) }}
                            </span>

                        </td>

                        <td class="px-6 py-5">

                            @if($order->payment_status == 'paid')

                                <span class="bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-sm font-semibold">
                                    ✅ Paid
                                </span>

                            @elseif($order->payment_status == 'pending')

                                <span class="bg-yellow-100 text-yellow-700 px-4 py-1.5 rounded-full text-sm font-semibold">
                                    ⏳ Pending
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-4 py-1.5 rounded-full text-sm font-semibold">
                                    ❌ Unpaid
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-5 text-slate-500">
                            {{ $order->created_at->format('d M Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-16 text-slate-500">

                            <div class="flex flex-col items-center gap-3">

                                <i class="bi bi-inbox text-6xl text-slate-300"></i>

                                <p class="text-lg">
                                    Belum ada transaksi.
                                </p>

                                <p class="text-sm">
                                    Mulai jual buku Anda sekarang!
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- TOP PRODUCTS - MEDIABOOK THEME -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">

    <div class="flex items-center justify-between mb-5">

        <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Playfair Display', serif; font-weight: 800;">
            🏆 Buku Terlaris
        </h3>

        <span class="text-sm text-slate-400">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </span>

    </div>

    @if($topProducts->count() > 0)

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            @foreach($topProducts as $index => $top)

                <div class="flex items-center justify-between border rounded-2xl px-5 py-4 hover:shadow-lg transition hover:border-purple-200">

                    <div class="flex items-center gap-4">

                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-sm">
                            #{{ $index + 1 }}
                        </div>

                        <div>

                            <p class="font-semibold text-slate-800">
                                {{ $top->product->name ?? 'Buku Dihapus' }}
                            </p>

                            <p class="text-sm text-slate-500">
                                <i class="bi bi-tag me-1"></i>
                                {{ $top->product->category->name ?? 'Tanpa Kategori' }}
                            </p>

                        </div>

                    </div>

                    <div class="bg-purple-100 text-purple-700 px-5 py-2 rounded-xl font-bold text-sm">

                        📚 {{ $top->total_sold }} Terjual

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="text-center py-12">

            <i class="bi bi-book text-6xl text-slate-300"></i>

            <p class="text-slate-500 mt-3">
                Belum ada data penjualan buku.
            </p>

        </div>

    @endif

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

    /* Input focus */
    input:focus, select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    }

    /* Elegant button */
    .btn-elegant {
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        transition: all 0.3s ease;
    }

    .btn-elegant:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
    }
</style>

@endsection
