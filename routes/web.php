<?php

use Illuminate\Support\Facades\Route;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockInController;
use App\Http\Controllers\Admin\StockOutController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| CUSTOMER CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\ShippingAddressController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $featuredProducts = Product::with('category')
        ->latest()
        ->take(4)
        ->get();

    $categories = Category::latest()
        ->take(8)
        ->get();

    $stats = [
        'products'   => Product::count(),
        'categories' => Category::count(),
        'orders'     => Order::count(),
    ];

    return view(
        'home',
        compact(
            'featuredProducts',
            'categories',
            'stats'
        )
    );

})->name('home');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

    /*
    |--------------------------------------------------------------------------
    | SHOP
    |--------------------------------------------------------------------------
    */

    Route::get('/shop', [ShopController::class, 'index'])
        ->name('shop.index');

    Route::get('/products/{product}', [ShopController::class, 'show'])
        ->name('shop.show');

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart', [CartController::class, 'store'])
        ->name('cart.store');

    Route::put('/cart/{cartItem}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

    Route::post('/cart/clear', [CartController::class, 'clear'])
        ->name('cart.clear');

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */

    Route::get('/orders', [CustomerOrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])
        ->name('orders.show');

    Route::get('/orders/{order}/pay', [CustomerOrderController::class, 'pay'])
        ->name('orders.pay');

    Route::get('/orders/payment/finish', [CustomerOrderController::class, 'paymentFinish'])
        ->name('orders.paymentFinish');

    Route::post('/orders/{order}/payment', [CustomerOrderController::class, 'uploadPayment'])
        ->name('orders.uploadPayment');

    Route::post('/orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])
        ->name('orders.cancel');

    Route::get('/orders/{order}/invoice', [CustomerOrderController::class, 'downloadInvoice'])
        ->name('orders.invoice');

    Route::get('/orders/{order}/history', [CustomerOrderController::class, 'statusHistory'])
        ->name('orders.history');

    /*
    |--------------------------------------------------------------------------
    | SHIPPING ADDRESS
    |--------------------------------------------------------------------------
    */

    Route::prefix('addresses')
        ->name('addresses.')
        ->group(function () {

        Route::get('/', [ShippingAddressController::class, 'index'])
            ->name('index');

        Route::get('/create', [ShippingAddressController::class, 'create'])
            ->name('create');

        Route::post('/', [ShippingAddressController::class, 'store'])
            ->name('store');

        Route::get('/{shippingAddress}/edit', [ShippingAddressController::class, 'edit'])
            ->name('edit');

        Route::put('/{shippingAddress}', [ShippingAddressController::class, 'update'])
            ->name('update');

        Route::delete('/{shippingAddress}', [ShippingAddressController::class, 'destroy'])
            ->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', function () {
        return view('customer.profile');
    })->name('profile.index');

    Route::put('/profile', function () {

        $user = auth()->user();

        $user->update([
            'name'  => request('name'),
            'email' => request('email'),
        ]);

        return back()->with('success', 'Profile berhasil diupdate');

    })->name('profile.update');

}); // <- PENUTUP CUSTOMER GROUP

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | RESOURCE
    |--------------------------------------------------------------------------
    */

    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);

    Route::resource('stock-ins', StockInController::class)
        ->except(['show']);

    Route::resource('stock-outs', StockOutController::class)
        ->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */

    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('orders.show');

    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');

    /*
    |--------------------------------------------------------------------------
    | PAYMENTS
    |--------------------------------------------------------------------------
    */

    Route::prefix('payments')
        ->name('payments.')
        ->group(function () {

        Route::get('/', [PaymentController::class, 'index'])
            ->name('index');

        Route::get('/{payment}', [PaymentController::class, 'show'])
            ->name('show');

        Route::post('/{payment}/verify', [PaymentController::class, 'verify'])
            ->name('verify');

        Route::post('/{payment}/reject', [PaymentController::class, 'reject'])
            ->name('reject');

        Route::get('/{payment}/download-proof', [PaymentController::class, 'downloadProof'])
            ->name('downloadProof');

        Route::get('/statistics', [PaymentController::class, 'statistics'])
            ->name('statistics');
    });

    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */

    Route::prefix('reports')
        ->name('reports.')
        ->group(function () {

        Route::get('/stock', [ReportController::class, 'stock'])
            ->name('stock');

        Route::get('/sales', [ReportController::class, 'sales'])
            ->name('sales');

        Route::get('/export-stock', [ReportController::class, 'exportStock'])
            ->name('exportStock');

        Route::get('/export-sales', [ReportController::class, 'exportSales'])
            ->name('exportSales');

    });

});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return view('errors.404');
});