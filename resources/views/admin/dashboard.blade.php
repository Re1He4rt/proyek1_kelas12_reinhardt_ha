@extends('layouts.admin')

@section('content')

<div class="space-y-8">

    <!-- HEADER - MEDIABOOK THEME -->
    <div class="bg-gradient-to-r from-purple-700 via-purple-600 to-indigo-600 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">

        <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-16 -left-16 w-52 h-52 bg-white/5 rounded-full"></div>

        <!-- Decorative Book Icon -->
        <div class="absolute top-4 right-8 text-7xl opacity-10">
            📚
        </div>

        <div class="relative z-10">

            <span class="bg-white/20 text-white text-xs px-4 py-2 rounded-full font-semibold backdrop-blur-sm">
                📖 ADMIN PANEL - MEDIABOOK
            </span>

            <h1 class="text-4xl font-black mt-4 mb-3" style="font-family: 'Playfair Display', serif; font-weight: 900;">
                Dashboard Admin
            </h1>

            <p class="text-white/80 text-lg" style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-style: italic;">
                Kelola toko buku, produk literasi, transaksi, dan inventory dengan mudah.
            </p>

        </div>

    </div>

    <!-- STATISTICS - MEDIABOOK THEME -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- TOTAL BUKU -->
        <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 hover:shadow-2xl transition duration-300 group">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm font-medium">
                        Total Buku
                    </p>

                    <h2 class="text-4xl font-black mt-3 text-slate-800 group-hover:text-purple-600 transition">
                        {{ $totalProducts }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center group-hover:bg-purple-600 transition">

                    <i class="bi bi-book text-3xl text-purple-600 group-hover:text-white transition"></i>

                </div>

            </div>

        </div>

        <!-- TOTAL ORDER -->
        <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 hover:shadow-2xl transition duration-300 group">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm font-medium">
                        Total Pesanan
                    </p>

                    <h2 class="text-4xl font-black mt-3 text-slate-800 group-hover:text-orange-600 transition">
                        {{ $totalOrders }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-orange-100 flex items-center justify-center group-hover:bg-orange-600 transition">

                    <i class="bi bi-cart-check text-3xl text-orange-600 group-hover:text-white transition"></i>

                </div>

            </div>

        </div>

        <!-- TOTAL CUSTOMER -->
        <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 hover:shadow-2xl transition duration-300 group">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm font-medium">
                        Total Pembaca
                    </p>

                    <h2 class="text-4xl font-black mt-3 text-slate-800 group-hover:text-indigo-600 transition">
                        {{ $totalCustomers }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-600 transition">

                    <i class="bi bi-people text-3xl text-indigo-600 group-hover:text-white transition"></i>

                </div>

            </div>

        </div>

        <!-- REVENUE -->
        <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 hover:shadow-2xl transition duration-300 group">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm font-medium">
                        Total Pendapatan
                    </p>

                    <h2 class="text-3xl font-black mt-3 text-green-600 group-hover:text-purple-600 transition">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center group-hover:bg-green-600 transition">

                    <i class="bi bi-cash-stack text-3xl text-green-600 group-hover:text-white transition"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- QUICK ACTION - MEDIABOOK THEME -->
    <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">

        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">

            <div>

                <h2 class="text-2xl font-black text-slate-800" style="font-family: 'Playfair Display', serif; font-weight: 800;">
                    ⚡ Aksi Cepat
                </h2>

                <p class="text-slate-500" style="font-family: 'Cormorant Garamond', serif; font-style: italic;">
                    Akses cepat untuk mengelola toko buku
                </p>

            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

            <!-- TAMBAH BUKU -->
            <a href="{{ route('admin.products.create') }}"
               class="group bg-purple-50 hover:bg-purple-600 rounded-2xl p-6 transition duration-300">

                <div class="w-14 h-14 rounded-2xl bg-purple-100 group-hover:bg-white flex items-center justify-center mb-5">

                    <i class="bi bi-plus-circle text-2xl text-purple-600 group-hover:text-purple-600"></i>

                </div>

                <h3 class="font-bold text-lg text-slate-800 group-hover:text-white" style="font-family: 'Playfair Display', serif;">
                    Tambah Buku
                </h3>

                <p class="text-slate-500 group-hover:text-purple-100 text-sm mt-1">
                    Tambahkan buku baru ke toko
                </p>

            </a>

            <!-- STOCK MASUK (Buku Masuk) -->
            <a href="{{ route('admin.stock-ins.create') }}"
               class="group bg-green-50 hover:bg-green-600 rounded-2xl p-6 transition duration-300">

                <div class="w-14 h-14 rounded-2xl bg-green-100 group-hover:bg-white flex items-center justify-center mb-5">

                    <i class="bi bi-box-arrow-in-down text-2xl text-green-600"></i>

                </div>

                <h3 class="font-bold text-lg text-slate-800 group-hover:text-white" style="font-family: 'Playfair Display', serif;">
                    Buku Masuk
                </h3>

                <p class="text-slate-500 group-hover:text-green-100 text-sm mt-1">
                    Tambahkan stok buku dari penerbit
                </p>

            </a>

            <!-- STOCK KELUAR (Buku Keluar) -->
            <a href="{{ route('admin.stock-outs.create') }}"
               class="group bg-red-50 hover:bg-red-600 rounded-2xl p-6 transition duration-300">

                <div class="w-14 h-14 rounded-2xl bg-red-100 group-hover:bg-white flex items-center justify-center mb-5">

                    <i class="bi bi-box-arrow-up text-2xl text-red-600"></i>

                </div>

                <h3 class="font-bold text-lg text-slate-800 group-hover:text-white" style="font-family: 'Playfair Display', serif;">
                    Buku Keluar
                </h3>

                <p class="text-slate-500 group-hover:text-red-100 text-sm mt-1">
                    Kurangi stok buku (rusak/hilang)
                </p>

            </a>

            <!-- ORDERS -->
            <a href="{{ route('admin.orders.index') }}"
               class="group bg-orange-50 hover:bg-orange-500 rounded-2xl p-6 transition duration-300">

                <div class="w-14 h-14 rounded-2xl bg-orange-100 group-hover:bg-white flex items-center justify-center mb-5">

                    <i class="bi bi-receipt text-2xl text-orange-600"></i>

                </div>

                <h3 class="font-bold text-lg text-slate-800 group-hover:text-white" style="font-family: 'Playfair Display', serif;">
                    Kelola Pesanan
                </h3>

                <p class="text-slate-500 group-hover:text-orange-100 text-sm mt-1">
                    Lihat dan proses pesanan buku
                </p>

            </a>

        </div>

    </div>

    <!-- INFO PANEL - MEDIABOOK THEME -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- STATUS SISTEM -->
        <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">

            <h2 class="text-2xl font-black text-slate-800 mb-6" style="font-family: 'Playfair Display', serif; font-weight: 800;">
                📊 Status Sistem
            </h2>

            <div class="space-y-5">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="w-4 h-4 rounded-full bg-green-500"></div>

                        <span class="font-semibold text-slate-700">
                            Website Online
                        </span>

                    </div>

                    <span class="text-green-600 font-bold">
                        ✅ Active
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="w-4 h-4 rounded-full bg-purple-500"></div>

                        <span class="font-semibold text-slate-700">
                            Database
                        </span>

                    </div>

                    <span class="text-purple-600 font-bold">
                        ✅ Connected
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="w-4 h-4 rounded-full bg-orange-500"></div>

                        <span class="font-semibold text-slate-700">
                            Inventory Buku
                        </span>

                    </div>

                    <span class="text-orange-600 font-bold">
                        ✅ Running
                    </span>

                </div>

            </div>

        </div>

        <!-- TIPS ADMIN - MEDIABOOK THEME -->
        <div class="bg-gradient-to-br from-purple-700 to-indigo-800 rounded-3xl shadow-lg p-8 text-white relative overflow-hidden">

            <!-- Decorative -->
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/5 rounded-full"></div>
            <div class="absolute top-4 right-4 text-5xl opacity-10">📖</div>

            <div class="relative z-10">

                <h2 class="text-2xl font-black mb-5" style="font-family: 'Playfair Display', serif; font-weight: 800;">
                    💡 Tips Admin MediaBook
                </h2>

                <ul class="space-y-4">

                    <li class="flex gap-3">

                        <i class="bi bi-check-circle-fill text-green-300 text-xl"></i>

                        <span>
                            Selalu cek stok buku setiap hari untuk memastikan ketersediaan.
                        </span>

                    </li>

                    <li class="flex gap-3">

                        <i class="bi bi-check-circle-fill text-green-300 text-xl"></i>

                        <span>
                            Verifikasi pembayaran customer secara rutin agar pesanan cepat diproses.
                        </span>

                    </li>

                    <li class="flex gap-3">

                        <i class="bi bi-check-circle-fill text-green-300 text-xl"></i>

                        <span>
                            Tambahkan buku baru dan best seller untuk meningkatkan penjualan.
                        </span>

                    </li>

                    <li class="flex gap-3">

                        <i class="bi bi-check-circle-fill text-green-300 text-xl"></i>

                        <span>
                            Pantau laporan penjualan setiap minggu untuk strategi bisnis.
                        </span>

                    </li>

                    <li class="flex gap-3">

                        <i class="bi bi-check-circle-fill text-green-300 text-xl"></i>

                        <span>
                            Jalin kerjasama dengan penerbit untuk mendapatkan koleksi terbaru.
                        </span>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>

<!-- Tambahkan Font Google untuk Elegant -->
<style>
    /* Import Google Fonts untuk Elegant */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap');

    /* Styling tambahan untuk dashboard */
    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    /* Elegant text untuk judul */
    .elegant-title {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
    }

    .elegant-subtitle {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-weight: 400;
    }

    /* Hover effect untuk quick action */
    .quick-action-card {
        transition: all 0.3s ease;
    }

    .quick-action-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    /* Status indicator pulse */
    .status-dot {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
</style>

@endsection
