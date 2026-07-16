<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * ShopController
 * Controller untuk halaman shop customer
 * Menampilkan katalog produk
 */
class ShopController extends Controller
{
    /**
     * Display a listing of the products.
     * Menampilkan semua produk dengan filter & search
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Product::with('category')->available();

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search berdasarkan nama produk
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Pagination
        $products = $query->paginate(12);

        // Ambil semua kategori untuk filter
        $categories = Category::active()->get();

        return view('customer.shop', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     * Tampilkan detail produk
     */
    public function show(Product $product)
    {
        // Load relasi
        $product->load('category');

        // Produk terkait (kategori yang sama)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->available()
            ->take(4)
            ->get();

        return view('customer.product-detail', compact('product', 'relatedProducts'));
    }
}
