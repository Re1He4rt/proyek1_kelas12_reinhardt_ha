@extends('layouts.admin')

@section('title', 'Detail Produk - MediaBook')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Detail Produk</h1>
    <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
        Kembali
    </a>
</div>

<div class="bg-white p-8 rounded-2xl shadow">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-64 object-cover rounded-xl border" alt="{{ $product->name }}">
            @else
                <div class="w-full h-64 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                    <i class="bi bi-image text-4xl"></i>
                </div>
            @endif
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">{{ $product->name }}</h2>

            <div class="space-y-3">
                <div><span class="text-gray-500">Kategori:</span> <strong>{{ $product->category->name ?? '-' }}</strong></div>
                <div><span class="text-gray-500">Penulis:</span> <strong>{{ $product->author ?? '-' }}</strong></div>
                <div><span class="text-gray-500">Penerbit:</span> <strong>{{ $product->publisher ?? '-' }}</strong></div>
                <div><span class="text-gray-500">Tahun:</span> <strong>{{ $product->year ?? '-' }}</strong></div>
                <div><span class="text-gray-500">ISBN:</span> <strong>{{ $product->isbn ?? '-' }}</strong></div>
                <div><span class="text-gray-500">Harga:</span> <strong class="text-blue-600">{{ $product->formatted_price }}</strong></div>
                <div><span class="text-gray-500">Stok:</span> <strong class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock }}</strong></div>
            </div>

            @if($product->description)
                <div class="mt-4">
                    <span class="text-gray-500">Deskripsi:</span>
                    <p class="mt-1 text-gray-700">{{ $product->description }}</p>
                </div>
            @endif
        </div>

    </div>

</div>

@if($product->stockHistories->count() > 0)
<div class="bg-white p-8 rounded-2xl shadow mt-6">
    <h3 class="text-xl font-bold mb-4">Riwayat Stok</h3>
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Tanggal</th>
                <th class="p-3 text-left">Tipe</th>
                <th class="p-3 text-center">Qty</th>
                <th class="p-3 text-center">Sebelum</th>
                <th class="p-3 text-center">Sesudah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($product->stockHistories as $history)
                <tr class="border-t">
                    <td class="p-3">{{ $history->created_at->translatedFormat('d M Y H:i') }}</td>
                    <td class="p-3">{{ ucfirst($history->type) }}</td>
                    <td class="p-3 text-center">{{ $history->qty }}</td>
                    <td class="p-3 text-center">{{ $history->stock_before }}</td>
                    <td class="p-3 text-center">{{ $history->stock_after }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
