<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockHistory;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Support\Facades\DB;

/**
 * StockService
 * Service layer untuk menangani business logic stok
 * 
 * Keuntungan:
 * - Centralize semua stok logic
 * - Consistency dalam record keeping
 * - Mudah untuk extend dengan features baru
 */
class StockService
{
    /**
     * Stock in - tambah stok produk
     * 
     * Logic:
     * 1. Validasi produk ada
     * 2. Record stok masuk
     * 3. Update stok produk
     * 4. Catat di stock history
     */
    public function stockIn(
        int $productId,
        int $qty,
        ?int $supplierId = null,
        string $date = null,
        string $description = null
    ): StockIn {
        // Validasi input
        if ($qty <= 0) {
            throw new \Exception("Qty harus lebih dari 0");
        }

        // Default date to today
        $date = $date ?? now()->format('Y-m-d');

        // Get product
        $product = Product::findOrFail($productId);

        // Use transaction
        return DB::transaction(function () use (
            $product,
            $qty,
            $supplierId,
            $date,
            $description
        ) {
            // Get stock before
            $stockBefore = $product->stock;
            $stockAfter = $stockBefore + $qty;

            // Create stock in record
            $stockIn = StockIn::create([
                'product_id' => $product->id,
                'supplier_id' => $supplierId,
                'tanggal_masuk' => $date,
                'qty' => $qty,
                'keterangan' => $description,
            ]);

            // Update product stock
            $product->update(['stock' => $stockAfter]);

            // Record stock history
            StockHistory::create([
                'product_id' => $product->id,
                'type' => 'in',
                'qty' => $qty,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reference_id' => $stockIn->id,
                'reference_type' => 'StockIn',
            ]);

            return $stockIn;
        });
    }

    /**
     * Stock out - kurangi stok produk
     * 
     * Logic:
     * 1. Validasi produk ada
     * 2. Validasi stok cukup
     * 3. Record stok keluar
     * 4. Update stok produk
     * 5. Catat di stock history
     */
    public function stockOut(
        int $productId,
        int $qty,
        string $date = null,
        string $description = null
    ): StockOut {
        // Validasi input
        if ($qty <= 0) {
            throw new \Exception("Qty harus lebih dari 0");
        }

        // Default date to today
        $date = $date ?? now()->format('Y-m-d');

        // Get product
        $product = Product::findOrFail($productId);

        // Validasi stok cukup
        if (!$product->hasStock($qty)) {
            throw new \Exception(
                "Stok {$product->name} tidak mencukupkan! " .
                "Stok tersedia: {$product->stock}, diminta: {$qty}"
            );
        }

        // Use transaction
        return DB::transaction(function () use (
            $product,
            $qty,
            $date,
            $description
        ) {
            // Get stock before
            $stockBefore = $product->stock;
            $stockAfter = $stockBefore - $qty;

            // Prevent negative stock
            if ($stockAfter < 0) {
                throw new \Exception("Stok tidak boleh minus!");
            }

            // Create stock out record
            $stockOut = StockOut::create([
                'product_id' => $product->id,
                'tanggal_keluar' => $date,
                'qty' => $qty,
                'keterangan' => $description,
            ]);

            // Update product stock
            $product->update(['stock' => $stockAfter]);

            // Record stock history
            StockHistory::create([
                'product_id' => $product->id,
                'type' => 'out',
                'qty' => $qty,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reference_id' => $stockOut->id,
                'reference_type' => 'StockOut',
            ]);

            return $stockOut;
        });
    }

    /**
     * Reduce stock for sale (order)
     * Digunakan saat checkout untuk reduce stok
     */
    public function reduceStockForSale(int $productId, int $qty, int $orderId): void
    {
        DB::transaction(function () use ($productId, $qty, $orderId) {
            $product = Product::lockForUpdate()->findOrFail($productId);

            if ($product->stock < $qty) {
                throw new \Exception(
                    "Stok {$product->name} tidak mencukupkan! " .
                    "Stok tersedia: {$product->stock}, diminta: {$qty}"
                );
            }

            $stockBefore = $product->stock;
            $stockAfter = $stockBefore - $qty;

            $product->update(['stock' => $stockAfter]);

            StockHistory::create([
                'product_id' => $product->id,
                'type' => 'sale',
                'qty' => $qty,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reference_id' => $orderId,
                'reference_type' => 'Order',
            ]);
        });
    }

    /**
     * Restore stock when payment is rejected
     */
    public function restoreStockForRejection(int $orderId): void
    {
        $orderItems = \App\Models\OrderItem::where('order_id', $orderId)->get();

        foreach ($orderItems as $item) {
            DB::transaction(function () use ($item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);

                $stockBefore = $product->stock;
                $stockAfter = $stockBefore + $item->qty;

                $product->update(['stock' => $stockAfter]);

                StockHistory::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'qty' => $item->qty,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'reference_id' => $item->order_id,
                    'reference_type' => 'Order',
                ]);
            });
        }
    }

    /**
     * Get low stock products
     */
    public function getLowStockProducts(int $threshold = 5)
    {
        return Product::lowStock($threshold)
            ->with('category')
            ->get();
    }

    /**
     * Get out of stock products
     */
    public function getOutOfStockProducts()
    {
        return Product::outOfStock()
            ->with('category')
            ->get();
    }

    /**
     * Get stock history untuk product
     */
    public function getStockHistory(int $productId, int $limit = 20)
    {
        return StockHistory::where('product_id', $productId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get total stock value (untuk laporan)
     */
    public function getTotalStockValue(): float
    {
        return Product::query()
            ->selectRaw('SUM(stock * price) as total')
            ->value('total') ?? 0;
    }
}
