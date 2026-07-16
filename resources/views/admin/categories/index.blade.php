@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Data Kategori
    </h1>

    <a href="{{ route('admin.categories.create') }}"
       class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg">

        + Tambah Kategori
    </a>

</div>

@if(session('success'))

    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
        {{ session('success') }}
    </div>

@endif

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">No</th>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-center">Action</th>

            </tr>

        </thead>

        <tbody>

            @forelse($categories as $category)

                <tr class="border-t">

                    <td class="p-4">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-4">
                        {{ $category->name }}
                    </td>

                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-sm 
                            {{ $category->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $category->status_label }}
                        </span>
                    </td>

                    <td class="p-4">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg">

                                Edit
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Hapus kategori ini?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                                    Hapus
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4"
                        class="p-6 text-center text-gray-500">

                        Belum ada kategori
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-5">
    {{ $categories->links() }}
</div>

@endsection