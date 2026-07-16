@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Kategori
</h1>

<div class="bg-white rounded-2xl shadow p-6">

    <form action="{{ route('admin.categories.update', $category) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Nama Kategori
            </label>

            <input type="text"
                   name="name"
                   value="{{ $category->name }}"
                   class="w-full border rounded-lg px-4 py-3"
                   required>

        </div>

        <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg">

            Update
        </button>

    </form>

</div>

@endsection