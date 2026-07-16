<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * CartController
 * Controller untuk mengelola keranjang belanja
 */
class CartController extends Controller
{
    /**
     * Constructor - middleware auth
     */
    /**
     * Display cart.
     * Tampilkan keranjang belanja
     */
    public function index()
    {
        // Ambil atau buat cart user
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

        // Load cart items dengan produk
        $cart->load('cartItems.product');

        return view('customer.cart', compact('cart'));
    }

    /**
     * Store item to cart.
     * Tambah produk ke keranjang
     *
     * LOGIC:
     * - Jika produk sudah ada di cart, update qty
     * - Jika belum, tambahkan item baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1|max:100',
        ]);

        // Ambil data produk
        $product = Product::findOrFail($validated['product_id']);

        // Cek stok
        if (!$product->hasStock($validated['qty'])) {
            return back()
                ->with('error', "Stok tidak mencukupan! Stok tersedia: {$product->stock}")
                ->withInput();
        }

        // Ambil atau buat cart user
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

        // Cek apakah produk sudah ada di cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Update qty jika sudah ada
            $newQty = $cartItem->qty + $validated['qty'];

            // Validasi stok lagi untuk total qty
            if (!$product->hasStock($newQty)) {
                return back()
                    ->with('error', "Total qty ({$newQty}) melebihi stok tersedia ({$product->stock})!")
                    ->withInput();
            }

            $cartItem->update(['qty' => $newQty]);
        } else {
            // Tambah item baru
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'qty' => $validated['qty'],
                'price' => $product->price,
            ]);
        }

        return redirect()
            ->route('customer.cart.index')
            ->with('success', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Update cart item qty.
     * Update jumlah item di keranjang
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // Cek ownership - pastikan item ini milik user yang login
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Validasi input
        $validated = $request->validate([
            'qty' => 'required|integer|min:1|max:100',
        ]);

        // Ambil produk
        $product = $cartItem->product;

        // Validasi stok
        if (!$product->hasStock($validated['qty'])) {
            return back()
                ->with('error', "Stok tidak mencukupan! Stok tersedia: {$product->stock}");
        }

        // Update qty
        $cartItem->update($validated);

        return back()
            ->with('success', 'Jumlah item diupdate!');
    }

    /**
     * Remove item from cart.
     * Hapus item dari keranjang
     */
    public function destroy(CartItem $cartItem)
    {
        // Cek ownership
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hapus item
        $cartItem->delete();

        return back()
            ->with('success', 'Item dihapus dari keranjang!');
    }

    /**
     * Clear cart.
     * Kosongkan keranjang
     */
    public function clear()
    {
        // Ambil cart user
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cart->cartItems()->delete();
        }

        return back()
            ->with('success', 'Keranjang dikosongkan!');
    }
}
