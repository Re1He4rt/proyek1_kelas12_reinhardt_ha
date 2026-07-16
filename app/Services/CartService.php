<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

/**
 * CartService
 * Service layer untuk menangani business logic cart
 * 
 * Keuntungan:
 * - Memisahkan business logic dari controller
 * - Membuat logic reusable
 * - Lebih mudah di-test
 * - Code lebih clean
 */
class CartService
{
    /**
     * Get or create cart untuk user yang login
     */
    public function getOrCreateCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    /**
     * Add product to cart
     * 
     * Logic:
     * 1. Cek apakah produk sudah di cart
     * 2. Jika ada, tambah qty
     * 3. Jika tidak, buat item baru
     */
    public function addToCart(int $productId, int $qty): CartItem
    {
        // Validasi produk ada
        $product = Product::findOrFail($productId);

        // Validasi stok cukup
        if (!$product->hasStock($qty)) {
            throw new \Exception("Stok {$product->name} tidak mencukupkan!");
        }

        // Get or create cart
        $cart = $this->getOrCreateCart();

        // Check if product already in cart
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            // Update qty
            $newQty = $existingItem->qty + $qty;
            
            // Validasi qty baru tidak melebihi stok
            if (!$product->hasStock($newQty)) {
                throw new \Exception(
                    "Total qty {$product->name} melebihi stok! " .
                    "Stok tersedia: {$product->stock}, diminta: {$newQty}"
                );
            }

            $existingItem->update(['qty' => $newQty]);
            return $existingItem;
        }

        // Create new item
        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'qty' => $qty,
            'price' => $product->price,
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function updateCartItem(CartItem $item, int $qty): CartItem
    {
        // Validasi qty > 0
        if ($qty <= 0) {
            $this->removeFromCart($item);
            throw new \Exception("Qty harus lebih dari 0");
        }

        // Validasi stok cukup
        $product = $item->product;
        if (!$product->hasStock($qty)) {
            throw new \Exception(
                "Stok {$product->name} tidak mencukupkan! " .
                "Stok tersedia: {$product->stock}, diminta: {$qty}"
            );
        }

        // Update qty
        $item->update(['qty' => $qty]);
        return $item;
    }

    /**
     * Remove item dari cart
     */
    public function removeFromCart(CartItem $item): bool
    {
        return $item->delete();
    }

    /**
     * Clear all items in cart
     */
    public function clearCart(): bool
    {
        $cart = $this->getOrCreateCart();
        return $cart->cartItems()->delete();
    }

    /**
     * Get cart total
     */
    public function getCartTotal(): float
    {
        $cart = $this->getOrCreateCart();
        return $cart->cartItems->sum(function ($item) {
            return $item->qty * $item->price;
        });
    }

    /**
     * Get cart item count
     */
    public function getCartItemCount(): int
    {
        $cart = $this->getOrCreateCart();
        return $cart->cartItems->sum('qty');
    }

    /**
     * Validate cart untuk checkout
     * Cek apakah semua item masih tersedia dan stok cukup
     */
    public function validateCart(): void
    {
        $cart = $this->getOrCreateCart();

        if ($cart->cartItems->isEmpty()) {
            throw new \Exception("Keranjang belanja kosong!");
        }

        foreach ($cart->cartItems as $item) {
            if (!$item->product->hasStock($item->qty)) {
                throw new \Exception(
                    "Stok {$item->product->name} tidak mencukupkan! " .
                    "Stok tersedia: {$item->product->stock}, " .
                    "diminta: {$item->qty}"
                );
            }
        }
    }
}
