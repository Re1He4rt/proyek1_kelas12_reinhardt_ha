@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Products
    </h1>

    <a href="{{ route('admin.products.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">

        + Tambah Produk
    </a>

</div>

@if(session('success'))

    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
        {{ session('success') }}
    </div>

@endif

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">Nama</th>
                <th class="p-4 text-left">Kategori</th>
                <th class="p-4 text-left">Harga</th>
                <th class="p-4 text-left">Stock</th>
                <th class="p-4 text-center">Action</th>

            </tr>

        </thead>

        <tbody>

            @forelse($products as $product)

                <tr class="border-t">

                    <td class="p-4">
                        {{ $product->name }}
                    </td>

                    <td class="p-4">
                        {{ $product->category->name ?? '-' }}
                    </td>

                    <td class="p-4">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>

                    <td class="p-4">
                        {{ $product->stock }}
                    </td>

                    <td class="p-4">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="bg-yellow-500 text-white px-4 py-2 rounded-lg">

                                Edit
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Hapus produk?')"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg">

                                    Delete
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5"
                        class="p-6 text-center text-gray-500">

                        Belum ada produk

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-5">

    {{ $products->links() }}

</div>

@endsection