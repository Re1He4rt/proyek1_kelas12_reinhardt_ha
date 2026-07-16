@extends('layouts.customer')

@section('title', 'Alamat Pengiriman')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Alamat Pengiriman</h3>
        <p class="text-muted mb-0">
            Kelola alamat pengiriman anda
        </p>
    </div>

    <a href="{{ route('customer.addresses.create') }}"
       class="btn btn-primary rounded-pill px-4">

        <i class="bi bi-plus-circle"></i>
        Tambah Alamat
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 border-0 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="row">

    @forelse($addresses as $address)

        <div class="col-md-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <h5 class="fw-bold">
                                {{ $address->recipient_name }}
                            </h5>

                            <p class="text-muted mb-1">
                                {{ $address->phone }}
                            </p>
                        </div>

                    </div>

                    <hr>

                    <p class="mb-4 text-secondary">
                        {{ $address->address }},
                        {{ $address->city }},
                        {{ $address->province }},
                        {{ $address->postal_code }}
                    </p>

                    <div class="d-flex gap-2">

                        <a href="{{ route('customer.addresses.edit', $address) }}"
                           class="btn btn-outline-primary rounded-pill w-100">

                            <i class="bi bi-pencil-square"></i>
                            Edit
                        </a>

                        <form action="{{ route('customer.addresses.destroy', $address) }}"
                              method="POST"
                              class="w-100">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-outline-danger rounded-pill w-100"
                                    onclick="return confirm('Hapus alamat ini?')">

                                <i class="bi bi-trash"></i>
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center py-5">

                    <i class="bi bi-geo-alt fs-1 text-muted"></i>

                    <h5 class="mt-3">
                        Belum ada alamat
                    </h5>

                    <p class="text-muted">
                        Tambahkan alamat pengiriman terlebih dahulu
                    </p>

                    <a href="{{ route('customer.addresses.create') }}"
                       class="btn btn-primary rounded-pill px-4">

                        Tambah Alamat
                    </a>

                </div>

            </div>

        </div>

    @endforelse

</div>

@endsection