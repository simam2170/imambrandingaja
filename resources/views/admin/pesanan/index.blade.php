@extends('layouts.admin') 
{{-- Assuming a layout exists, or I should use 'layouts.user' or create 'layouts.admin'. 
   Existing layouts: 'layouts.mitra', 'layouts.user'. 
   I'll use 'layouts.mitra' structure as a base for admin or just a simple layout if 'layouts.admin' doesn't exist.
   Actually, I should check if 'layouts.admin' exists. If not, I'll copy 'layouts.mitra' to 'layouts.admin'.
   For now, I'll use a generic HTML structure or extend 'layouts.user' but with admin nav?
   Let's check layouts first. --}}
@section('title', 'Admin - Daftar Pesanan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard - Pesanan</h1>
    
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-bold">#{{ $order->order_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                        <div class="text-sm text-gray-500">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $order->layanan->nama_layanan ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $order->status === 'selesai' ? 'bg-green-100 text-green-800' : 
                               ($order->status === 'ditolak' ? 'bg-red-100 text-red-800' : 
                               ($order->status === 'diproses' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.pesanan.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail & Verifikasi</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
