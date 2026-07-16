@extends('layouts.admin')

@section('title', 'Statistik Pembayaran - MediaBook')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Statistik Pembayaran</h1>
    <a href="{{ route('admin.payments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-2xl text-center">
        <div class="text-4xl font-bold text-yellow-600">{{ $stats['total_pending'] }}</div>
        <div class="text-yellow-700 mt-2">Menunggu Verifikasi</div>
        <div class="text-sm text-yellow-500 mt-1">Rp {{ number_format($stats['pending_amount'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-green-50 border border-green-200 p-6 rounded-2xl text-center">
        <div class="text-4xl font-bold text-green-600">{{ $stats['total_verified'] }}</div>
        <div class="text-green-700 mt-2">Terverifikasi</div>
        <div class="text-sm text-green-500 mt-1">Rp {{ number_format($stats['verified_amount'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-red-50 border border-red-200 p-6 rounded-2xl text-center">
        <div class="text-4xl font-bold text-red-600">{{ $stats['total_rejected'] }}</div>
        <div class="text-red-700 mt-2">Ditolak</div>
    </div>
</div>

@if($paymentsByMethod->count() > 0)
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="p-6 border-b">
        <h3 class="text-xl font-bold">Berdasarkan Metode Pembayaran</h3>
    </div>
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">Metode</th>
                <th class="p-4 text-center">Total</th>
                <th class="p-4 text-center">Terverifikasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paymentsByMethod as $method)
                <tr class="border-t">
                    <td class="p-4 font-bold">{{ ucfirst(str_replace('_', ' ', $method->payment_type ?? '-')) }}</td>
                    <td class="p-4 text-center">{{ $method->total }}</td>
                    <td class="p-4 text-center">{{ $method->verified }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
