<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // TOTAL DATA
        $totalProducts = Product::count();

        $totalCustomers = User::where('role', 'customer')->count();

        $totalOrders = Order::count();

        $pendingOrders = Order::where('status', 'pending')->count();

        $completedOrders = Order::where('status', 'completed')->count();

        // TOTAL REVENUE
        $totalRevenue = Order::where('payment_status', 'paid')
            ->sum('total');

        // DATA STOK
        $lowStock = Product::where('stock', '<=', 5)->count();

        $outOfStock = Product::where('stock', 0)->count();

        $stockInToday = StockIn::whereDate('created_at', today())
            ->sum('qty');

        $stockOutToday = StockOut::whereDate('created_at', today())
            ->sum('qty');

        // PENJUALAN HARI INI
        $salesToday = Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total');

        // PRODUK STOK MENIPIS
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->with('category')
            ->get();

        // ORDER TERBARU
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // GRAFIK PENJUALAN
        $salesChart = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total) as total_sales')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'lowStock',
            'outOfStock',
            'stockInToday',
            'stockOutToday',
            'salesToday',
            'lowStockProducts',
            'recentOrders',
            'salesChart'
        ));
    }
}