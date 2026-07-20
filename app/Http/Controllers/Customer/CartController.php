<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

        $cart->load('cartItems.product');

        return view('customer.cart', compact('cart'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1|max:100',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (!$product->hasStock($validated['qty'])) {
            if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => "Stok tidak mencukupi! Stok tersedia: {$product->stock}"
                ], 422);
            }
            return back()
                ->with('error', "Stok tidak mencukupan! Stok tersedia: {$product->stock}")
                ->withInput();
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->qty + $validated['qty'];

            if (!$product->hasStock($newQty)) {
                if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                    return response()->json([
                        'success' => false,
                        'message' => "Total qty ({$newQty}) melebihi stok tersedia ({$product->stock})!"
                    ], 422);
                }
                return back()
                    ->with('error', "Total qty ({$newQty}) melebihi stok tersedia ({$product->stock})!")
                    ->withInput();
            }

            $cartItem->update(['qty' => $newQty]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'qty' => $validated['qty'],
                'price' => $product->price,
            ]);
        }

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            $cartCount = CartItem::whereHas('cart', function ($q) {
                $q->where('user_id', Auth::id());
            })->sum('qty');

            return response()->json([
                'success' => true,
                'message' => 'Produk ditambahkan ke keranjang!',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()
            ->route('customer.cart.index')
            ->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'qty' => 'required|integer|min:1|max:100',
        ]);

        $product = $cartItem->product;

        if (!$product->hasStock($validated['qty'])) {
            if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => "Stok tidak mencukupi! Stok tersedia: {$product->stock}"
                ], 422);
            }
            return back()
                ->with('error', "Stok tidak mencukupi! Stok tersedia: {$product->stock}");
        }

        $cartItem->update($validated);

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            $cart = $cartItem->cart;
            $cart->load('cartItems.product');
            $totalItems = $cart->cartItems->sum('qty');
            $total = $cart->total;

            return response()->json([
                'success' => true,
                'message' => 'Jumlah item diupdate!',
                'total' => $total,
                'total_items' => $totalItems
            ]);
        }

        return back()
            ->with('success', 'Jumlah item diupdate!');
    }

    public function destroy(Request $request, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized');
        }

        $cart = $cartItem->cart;
        $cartItem->delete();

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            $cart->load('cartItems.product');
            $totalItems = $cart->cartItems->sum('qty');
            $total = $cart->total;

            return response()->json([
                'success' => true,
                'message' => 'Item dihapus dari keranjang!',
                'total' => $total,
                'total_items' => $totalItems,
                'empty' => $cart->cartItems->isEmpty()
            ]);
        }

        return back()
            ->with('success', 'Item dihapus dari keranjang!');
    }

    public function clear(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cart->cartItems()->delete();
        }

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Keranjang dikosongkan!'
            ]);
        }

        return back()
            ->with('success', 'Keranjang dikosongkan!');
    }
}
