@extends('layouts.customer')

@section('title', 'Invoice ' . $order->order_number)

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('customer.orders.index') }}" class="text-decoration-none">Pesanan Saya</a>
    </li>
    <li class="breadcrumb-item active">Invoice</li>
@endsection

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <h3 class="fw-bold">MediaBook</h3>
                        <p class="text-muted">Invoice Pembelian</p>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>No. Order:</strong><br>
                            {{ $order->order_number }}
                        </div>
                        <div class="col-6 text-end">
                            <strong>Tanggal:</strong><br>
                            {{ $order->created_at->translatedFormat('d M Y') }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <strong>Alamat Pengiriman:</strong><br>
                        {{ $order->shippingAddress->recipient_name }}<br>
                        {{ $order->shippingAddress->phone }}<br>
                        {{ $order->shippingAddress->full_address }}
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'Produk' }}</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold text-primary">{{ $order->formatted_total }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="text-center mt-4">
                        <p class="text-muted small">Terima kasih telah berbelanja di MediaBook</p>
                        <button onclick="window.print()" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-printer me-1"></i> Cetak Invoice
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
