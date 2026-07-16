@extends('layouts.admin')

@section('title', 'Manajemen Pesanan - MediaBook')

@section('content')

<!-- HEADER - MEDIABOOK THEME -->
<div class="flex justify-between items-center mb-6">

    <div>

        <h2 class="text-3xl font-bold text-slate-800" style="font-family: 'Playfair Display', serif; font-weight: 800;">
            📋 Manajemen Pesanan
        </h2>

        <p class="text-slate-500 mt-1" style="font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 1.1rem;">
            Kelola semua pesanan buku dari customer MediaBook.
        </p>

    </div>

    <!-- Statistik Cepat -->
    <div class="flex gap-3">
        <div class="bg-purple-100 text-purple-700 px-4 py-2 rounded-xl text-sm font-semibold">
            Total: {{ $orders->total() }}
        </div>
        <div class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl text-sm font-semibold">
            Pending: {{ $orders->where('status', 'pending')->count() }}
        </div>
    </div>

</div>

<!-- SUCCESS MESSAGE -->
@if(session('success'))

    <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
        <i class="bi bi-check-circle-fill text-green-500"></i>
        {{ session('success') }}
    </div>

@endif

<!-- ERROR MESSAGE -->
@if(session('error'))

    <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
        <i class="bi bi-exclamation-circle-fill text-red-500"></i>
        {{ session('error') }}
    </div>

@endif

<!-- TABLE - MEDIABOOK THEME -->
<div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-slate-200">

    <div class="overflow-x-auto">

        <table class="w-full">

            <!-- TABLE HEAD -->
            <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">

                <tr class="text-left">

                    <th class="px-6 py-4 text-sm font-semibold text-purple-800">
                        📋 Order
                    </th>

                    <th class="px-6 py-4 text-sm font-semibold text-purple-800">
                        👤 Customer
                    </th>

                    <th class="px-6 py-4 text-sm font-semibold text-purple-800">
                        💰 Total
                    </th>

                    <th class="px-6 py-4 text-sm font-semibold text-purple-800">
                        💳 Payment
                    </th>

                    <th class="px-6 py-4 text-sm font-semibold text-purple-800">
                        📌 Status
                    </th>

                    <th class="px-6 py-4 text-sm font-semibold text-purple-800">
                        📅 Date
                    </th>

                    <th class="px-6 py-4 text-center text-sm font-semibold text-purple-800">
                        ⚡ Action
                    </th>

                </tr>

            </thead>

            <!-- TABLE BODY -->
            <tbody>

                @forelse($orders as $order)

                    <tr class="border-t hover:bg-purple-50 transition">

                        <!-- ORDER -->
                        <td class="px-6 py-5 font-semibold text-slate-800">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-receipt text-purple-500"></i>
                                {{ $order->order_number }}
                            </div>
                        </td>

                        <!-- CUSTOMER -->
                        <td class="px-6 py-5 text-slate-700">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-person-circle text-purple-400"></i>
                                {{ $order->user->name }}
                            </div>
                        </td>

                        <!-- TOTAL -->
                        <td class="px-6 py-5 font-bold text-purple-600">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>

                        <!-- PAYMENT -->
                        <td class="px-6 py-5">

                            @php
                                $paymentColors = [
                                    'paid' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                    'unpaid' => 'bg-slate-200 text-slate-700',
                                ];
                                $paymentIcons = [
                                    'paid' => '✅',
                                    'pending' => '⏳',
                                    'rejected' => '❌',
                                    'unpaid' => '⏸️',
                                ];
                            @endphp

                            <span class="{{ $paymentColors[$order->payment_status] ?? 'bg-slate-200 text-slate-700' }} px-4 py-1.5 rounded-full text-sm font-semibold inline-flex items-center gap-1.5">
                                {{ $paymentIcons[$order->payment_status] ?? '' }}
                                {{ ucfirst($order->payment_status) }}
                            </span>

                        </td>

                        <!-- STATUS -->
                        <td class="px-6 py-5">

                            @php
                                $statusColors = [
                                    'pending' => 'bg-slate-200 text-slate-700',
                                    'processed' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-cyan-100 text-cyan-700',
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
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'processed' => 'Diproses',
                                    'shipped' => 'Dikirim',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp

                            <span class="{{ $statusColors[$order->status] ?? 'bg-slate-200 text-slate-700' }} px-4 py-1.5 rounded-full text-sm font-semibold inline-flex items-center gap-1.5">
                                {{ $statusIcons[$order->status] ?? '' }}
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>

                        </td>

                        <!-- DATE -->
                        <td class="px-6 py-5 text-slate-500">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $order->created_at->format('d M Y') }}
                        </td>

                        <!-- ACTION -->
                        <td class="px-6 py-5">

                            <div class="flex items-center justify-center gap-2 flex-wrap">

                                <!-- DETAIL -->
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm shadow-purple-200">

                                    <i class="bi bi-eye me-1"></i>
                                    Detail

                                </a>

                                <!-- VERIFY PAYMENT -->
                                @if($order->payment_status === 'pending')

                                    <form action="{{ route('admin.payments.verify', $order->payment) }}"
                                          method="POST">

                                        @csrf

                                        <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm shadow-green-200">

                                            <i class="bi bi-check2-circle me-1"></i>
                                            Approve

                                        </button>

                                    </form>

                                @endif

                                <!-- PROCESS ORDER -->
                                @if($order->payment_status === 'paid' && $order->status === 'pending')

                                    <form action="{{ route('admin.orders.updateStatus', $order) }}"
                                          method="POST">

                                        @csrf

                                        <input type="hidden"
                                               name="status"
                                               value="processed">

                                        <button type="submit"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm shadow-blue-200">

                                            <i class="bi bi-arrow-repeat me-1"></i>
                                            Proses

                                        </button>

                                    </form>

                                @endif

                                <!-- SHIP ORDER -->
                                @if($order->status === 'processed')

                                    <form action="{{ route('admin.orders.updateStatus', $order) }}"
                                          method="POST">

                                        @csrf

                                        <input type="hidden"
                                               name="status"
                                               value="shipped">

                                        <button type="submit"
                                                class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm shadow-cyan-200">

                                            <i class="bi bi-truck me-1"></i>
                                            Kirim

                                        </button>

                                    </form>

                                @endif

                                <!-- COMPLETE ORDER -->
                                @if($order->status === 'shipped')

                                    <form action="{{ route('admin.orders.updateStatus', $order) }}"
                                          method="POST">

                                        @csrf

                                        <input type="hidden"
                                               name="status"
                                               value="completed">

                                        <button type="submit"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm shadow-emerald-200">

                                            <i class="bi bi-check2-all me-1"></i>
                                            Selesai

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-16 text-slate-500">

                            <div class="flex flex-col items-center gap-3">

                                <i class="bi bi-inbox text-6xl text-slate-300"></i>

                                <p class="text-lg">
                                    Belum ada pesanan masuk.
                                </p>

                                <p class="text-sm text-slate-400">
                                    Tunggu customer melakukan pemesanan buku.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- PAGINATION -->
@if($orders->hasPages())

    <div class="mt-6">

        {{ $orders->links() }}

    </div>

@endif

<!-- Tambahkan CSS Elegant -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap');

    /* Table row hover */
    tbody tr {
        transition: all 0.2s ease;
    }

    /* Button hover */
    .btn-action {
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
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

    /* Responsive table */
    @media (max-width: 768px) {
        table {
            font-size: 0.85rem;
        }
        td, th {
            padding: 10px 8px !important;
        }
        .btn-action {
            padding: 6px 10px !important;
            font-size: 0.75rem !important;
        }
    }
</style>

@endsection
