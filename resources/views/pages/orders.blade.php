@extends('layouts.app')
@section('title', 'Orders — Admin')
@section('content')
<div class="flex flex-col min-w-0 overflow-hidden bg-background p-5 sm:p-8">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h1 class="font-headline-md text-headline-md text-primary mb-2">Orders</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Manage and track customer orders.</p>
        </div>
        {{-- Status Filter --}}
        <div class="flex gap-2 flex-wrap">
            @foreach(['all' => 'Semua', 'pending' => 'Pending', 'paid' => 'Paid', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'] as $val => $label)
                <a href="{{ route('admin-orders', $val === 'all' ? [] : ['status' => $val]) }}"
                    class="px-3 py-1.5 rounded text-xs font-semibold transition-colors
                        {{ ($status ?? null) === ($val === 'all' ? null : $val) || ($val === 'all' && !($status ?? null))
                            ? 'bg-primary text-on-primary'
                            : 'border border-outline-variant text-on-surface-variant hover:border-primary hover:text-primary' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-800 p-3 rounded-sm border border-green-200 mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-surface rounded-xl shadow-[0_20px_40px_rgba(62,39,35,0.05)] flex-1 flex flex-col overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/30 text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider bg-surface-container-low/50">
                        <th class="py-5 px-6 font-semibold">Order</th>
                        <th class="py-5 px-6 font-semibold">Tanggal</th>
                        <th class="py-5 px-6 font-semibold">Customer</th>
                        <th class="py-5 px-6 font-semibold">Status</th>
                        <th class="py-5 px-6 font-semibold">Pembayaran</th>
                        <th class="py-5 px-6 font-semibold text-right">Total</th>
                        <th class="py-5 px-6 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant/20">
                    @forelse($orders as $order)
                    <tr class="hover:bg-surface-container-low/30 transition-colors group">
                        <td class="py-4 px-6 font-medium">{{ $order->order_number }}</td>
                        <td class="py-4 px-6 text-on-surface-variant">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-medium">{{ $order->customer_name }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $order->customer_email }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                @if($order->status === 'delivered') bg-[#d8ddd3] text-[#4a5c41]
                                @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                                @elseif($order->status === 'paid') bg-emerald-100 text-emerald-800
                                @elseif($order->status === 'pending') bg-[#e8e0d5] text-[#6b5b4e]
                                @else bg-surface-variant text-on-surface-variant
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($order->payment)
                                <span class="text-xs
                                    {{ $order->payment->status === 'completed' ? 'text-green-700' : 'text-amber-700' }}">
                                    {{ ucfirst($order->payment->status) }}
                                </span>
                            @else
                                <span class="text-xs text-stone-400">—</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('admin-orders.show', $order) }}"
                                class="text-on-surface-variant hover:text-primary p-2 rounded-full hover:bg-surface-container transition-colors inline-block" title="Lihat Detail">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-stone-400">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="mt-auto border-t border-outline-variant/30 py-4 px-6 bg-surface-container-lowest">
            {{ $orders->appends(request()->query())->links('partials.pagination') }}
        </div>
        @endif
    </div>
</div>
@endsection
