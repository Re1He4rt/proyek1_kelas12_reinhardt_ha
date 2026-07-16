@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Produk
</h1>

<div class="bg-white p-8 rounded-2xl shadow">

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-5">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- Kategori --}}
        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Kategori
            </label>

            <select name="category_id"
                    class="w-full border rounded-lg p-3">

                @foreach($categories as $category)

                    <option value="{{ $category->id }}"
                        {{ $product->category_id == $category->id ? 'selected' : '' }}>

                        {{ $category->name }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- Nama Produk --}}
        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Nama Produk
            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name', $product->name) }}"
                   class="w-full border rounded-lg p-3">

        </div>

        {{-- Harga --}}
        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Harga
            </label>

            <input type="number"
                   name="price"
                   value="{{ old('price', $product->price) }}"
                   class="w-full border rounded-lg p-3">

        </div>

        {{-- Stock --}}
        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Stock
            </label>

            <input type="number"
                   name="stock"
                   value="{{ old('stock', $product->stock) }}"
                   class="w-full border rounded-lg p-3">

        </div>

        {{-- Foto Lama --}}
        @if($product->image)
            <div class="mb-5">

                <label class="block mb-2 font-semibold">
                    Foto Saat Ini
                </label>

                <img src="{{ asset('storage/' . $product->image) }}"
                     class="w-40 h-40 object-cover rounded-xl border">

            </div>
        @endif

        {{-- Upload Foto Baru --}}
        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Ganti Foto Produk
            </label>

            <input type="file"
                   name="image"
                   class="w-full border rounded-lg p-3 bg-white">

            <p class="text-sm text-gray-500 mt-2">
                Kosongkan jika tidak ingin mengganti foto
            </p>

        </div>

        {{-- Deskripsi --}}
        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Deskripsi
            </label>

            <textarea name="description"
                      rows="5"
                      class="w-full border rounded-lg p-3">{{ old('description', $product->description) }}</textarea>

        </div>

        {{-- Tombol --}}
        <div class="flex gap-3">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                Update Produk
            </button>

            <a href="{{ route('admin.products.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                Kembali
            </a>

        </div>

    </form>

</div>

@endsection