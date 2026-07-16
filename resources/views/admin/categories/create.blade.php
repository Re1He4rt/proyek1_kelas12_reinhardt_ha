@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Tambah Kategori
</h1>

<div class="bg-white rounded-2xl shadow p-6">

    <form action="{{ route('admin.categories.store') }}"
          method="POST">

        @csrf

        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Nama Kategori
            </label>

            <input type="text"
                   name="name"
                   class="w-full border rounded-lg px-4 py-3"
                   required>

        </div>

        <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg">

            Simpan
        </button>

    </form>

</div>

@endsection