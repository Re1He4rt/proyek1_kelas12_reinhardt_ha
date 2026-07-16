@extends('layouts.customer')

@section('title', 'Pembayaran ' . $order->order_number)

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('customer.orders.index') }}" class="text-decoration-none">
            Pesanan Saya
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('customer.orders.show', $order) }}" class="text-decoration-none">
            {{ $order->order_number }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        Pembayaran
    </li>
@endsection

@section('content')

<style>
    .pay-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
        background: white;
    }

    .pay-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 1.5rem;
    }

    .snap-btn {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border: none;
        border-radius: 16px;
        padding: 16px 32px;
        font-weight: 700;
        font-size: 1.1rem;
        color: white;
        cursor: pointer;
        transition: all .2s;
    }

    .snap-btn:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37,99,235,.3);
        color: white;
    }

    .snap-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .info-row {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="pay-card mb-4">
                <div class="pay-header text-center">
                    <h4 class="mb-2 fw-bold">
                        <i class="bi bi-credit-card me-2"></i>
                        Pembayaran
                    </h4>
                    <p class="mb-0 opacity-75">
                        {{ $order->order_number }}
                    </p>
                </div>
                <div class="card-body p-4">

                    <!-- Ringkasan -->
                    <div class="mb-4">
                        <div class="info-row d-flex justify-content-between">
                            <span class="text-muted">Total Pembayaran</span>
                            <strong class="text-primary fs-5">{{ $order->formatted_total }}</strong>
                        </div>
                        <div class="info-row d-flex justify-content-between">
                            <span class="text-muted">Status</span>
                            <span class="badge bg-warning text-dark rounded-pill">
                                {{ $order->paymentStatusLabel }}
                            </span>
                        </div>
                    </div>

                    <!-- Tombol Bayar -->
                    <div class="text-center">
                        <button
                            id="pay-button"
                            class="snap-btn w-100"
                        >
                            <i class="bi bi-wallet2 me-2"></i>
                            Bayar Sekarang
                        </button>

                        <a href="{{ route('customer.orders.show', $order) }}"
                           class="btn btn-outline-secondary mt-3"
                           style="border-radius: 16px;">
                            <i class="bi bi-arrow-left me-1"></i>
                            Kembali ke Detail Pesanan
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        var btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

        snap.pay('{{ $order->snap_token }}', {
            onSuccess: function(result) {
                window.location.href = '{{ route("customer.orders.paymentFinish", ["order_id" => $order->order_number]) }}';
            },
            onPending: function(result) {
                window.location.href = '{{ route("customer.orders.paymentFinish", ["order_id" => $order->order_number]) }}';
            },
            onError: function(result) {
                alert('Pembayaran gagal! Silakan coba lagi.');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-wallet2 me-2"></i> Bayar Sekarang';
            },
            onClose: function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-wallet2 me-2"></i> Bayar Sekarang';
            }
        });
    });
</script>
@endsection
