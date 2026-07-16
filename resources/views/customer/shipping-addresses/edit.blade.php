@extends('layouts.customer')

@section('title', 'Edit Alamat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('customer.addresses.index') }}" class="text-decoration-none">Alamat Pengiriman</a></li>
    <li class="breadcrumb-item active">Edit Alamat</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Alamat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('customer.addresses.update', $shippingAddress) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Penerima -->
                    <div class="mb-3">
                        <label for="recipient_name" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                        <input type="text"
                               name="recipient_name"
                               id="recipient_name"
                               class="form-control @error('recipient_name') is-invalid @enderror"
                               value="{{ old('recipient_name', $shippingAddress->recipient_name) }}"
                               placeholder="Contoh: Budi Santoso"
                               required>
                        @error('recipient_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- No. HP -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">No. HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text"
                               name="phone"
                               id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $shippingAddress->phone) }}"
                               placeholder="Contoh: 08123456789"
                               required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="address"
                                  id="address"
                                  class="form-control @error('address') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Nama jalan, nomor rumah, RT/RW..."
                                  required>{{ old('address', $shippingAddress->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kota/Kabupaten -->
                    <div class="mb-3">
                        <label for="city" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <input type="text"
                               name="city"
                               id="city"
                               class="form-control @error('city') is-invalid @enderror"
                               value="{{ old('city', $shippingAddress->city) }}"
                               placeholder="Contoh: Jakarta Selatan"
                               required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Provinsi -->
                    <div class="mb-3">
                        <label for="province" class="form-label">Provinsi <span class="text-danger">*</span></label>
                        <input type="text"
                               name="province"
                               id="province"
                               class="form-control @error('province') is-invalid @enderror"
                               value="{{ old('province', $shippingAddress->province) }}"
                               placeholder="Contoh: DKI Jakarta"
                               required>
                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kode Pos -->
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                        <input type="text"
                               name="postal_code"
                               id="postal_code"
                               class="form-control @error('postal_code') is-invalid @enderror"
                               value="{{ old('postal_code', $shippingAddress->postal_code) }}"
                               placeholder="Contoh: 12345"
                               required>
                        @error('postal_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Warning if used in active order -->
                    @if($shippingAddress->orders()->whereIn('status', ['pending', 'processed', 'shipped'])->count() > 0)
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-exclamation-triangle"></i>
                            Alamat ini digunakan di order aktif. Hati-hati saat mengedit.
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('customer.addresses.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Update Alamat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
