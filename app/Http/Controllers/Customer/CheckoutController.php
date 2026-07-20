<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\OrderService;

class CheckoutController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Tampilkan halaman checkout
     */
    public function index()
    {
        $cart = \App\Models\Cart::where('user_id', \Auth::id())
            ->with('cartItems.product')
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()
                ->route('customer.shop.index')
                ->with('error', 'Keranjang belanja kosong!');
        }

        $addresses = \App\Models\ShippingAddress::where('user_id', \Auth::id())->get();

        return view('customer.checkout', compact('cart', 'addresses'));
    }

    /**
     * Proses checkout
     */
    public function store(CheckoutRequest $request)
    {
        try {
            $order = $this->orderService->checkout(
                $request->validated('shipping_address_id')
            );

            return redirect()
                ->route('customer.orders.pay', $order)
                ->with('success', 'Order berhasil dibuat! Silakan selesaikan pembayaran.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
