@extends('layouts.admin')

@section('title', 'Data Pembayaran - MediaBook')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Data Pembayaran</h1>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">{{ session('error') }}</div>
@endif

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">No</th>
                <th class="p-4 text-left">Order Number</th>
                <th class="p-4 text-left">Customer</th>
                <th class="p-4 text-left">Metode</th>
                <th class="p-4 text-left">Total</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr class="border-t">
                    <td class="p-4">{{ $loop->iteration }}</td>
                    <td class="p-4 font-bold">{{ $payment->order->order_number }}</td>
                    <td class="p-4">{{ $payment->order->user->name ?? '-' }}</td>
                    <td class="p-4">{{ $payment->payment_type_label }}</td>
                    <td class="p-4 font-bold">Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-sm
                            @if(in_array($payment->status, ['settlement', 'capture'])) bg-green-100 text-green-700
                            @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $payment->status_label }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <a href="{{ route('admin.payments.show', $payment) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-gray-500">
                        Belum ada data pembayaran
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-5">{{ $payments->links() }}</div>

@endsection
