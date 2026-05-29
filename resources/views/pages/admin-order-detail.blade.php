@extends('layouts.app')
@section('title', 'Detail Pesanan — Admin')
@section('content')
<div class="flex flex-col min-w-0 overflow-hidden bg-background p-5 sm:p-8">

    {{-- Header --}}
    <div class="flex justify-between items-start mb-8">
        <div>
            <a href="{{ route('admin-orders') }}" class="text-on-surface-variant hover:text-primary text-sm font-label-md inline-flex items-center gap-1 mb-3">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span> Kembali ke Orders
            </a>
            <h1 class="font-headline-md text-headline-md text-primary">{{ $order->order_number }}</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                {{ $order->created_at->format('d M Y, H:i') }} — {{ $order->customer_name }}
            </p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
            @if($order->status === 'delivered') bg-[#d8ddd3] text-[#4a5c41]
            @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
            @elseif($order->status === 'paid') bg-emerald-100 text-emerald-800
            @elseif($order->status === 'pending') bg-[#e8e0d5] text-[#6b5b4e]
            @else bg-surface-variant text-on-surface-variant
            @endif">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-800 p-3 rounded-sm border border-green-200 mb-4 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 text-red-800 p-3 rounded-sm border border-red-200 mb-4 text-sm">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Customer Info --}}
            <div class="bg-surface rounded-xl p-6 shadow-sm">
                <h2 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Informasi Customer</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-on-surface-variant">Nama</p><p class="font-medium text-on-surface">{{ $order->customer_name }}</p></div>
                    <div><p class="text-on-surface-variant">Email</p><p class="font-medium text-on-surface">{{ $order->customer_email }}</p></div>
                    <div class="col-span-2"><p class="text-on-surface-variant">Alamat</p><p class="font-medium text-on-surface">{{ $order->shipping_address }}</p></div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-surface rounded-xl p-6 shadow-sm">
                <h2 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Item Pesanan</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-outline-variant/30 text-on-surface-variant">
                            <th class="text-left py-2">Produk</th>
                            <th class="text-center py-2">Qty</th>
                            <th class="text-right py-2">Harga</th>
                            <th class="text-right py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="py-3">
                                <p class="font-medium">{{ $item->product_name }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $item->product_size ?? '-' }} / {{ $item->product_color ?? '-' }}</p>
                            </td>
                            <td class="py-3 text-center">{{ $item->quantity }}</td>
                            <td class="py-3 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="py-3 text-right font-medium">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 pt-4 border-t border-outline-variant/30 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-on-surface-variant">Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span class="text-on-surface-variant">Ongkir</span><span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                    @if($order->discount > 0)
                    <div class="flex justify-between"><span class="text-on-surface-variant">Diskon</span><span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span></div>
                    @endif
                    <div class="flex justify-between pt-2 border-t border-outline-variant font-bold text-base">
                        <span>Total</span><span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Actions --}}
        <div class="space-y-6">
            {{-- Payment Info --}}
            <div class="bg-surface rounded-xl p-6 shadow-sm">
                <h2 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Pembayaran</h2>
                @if($order->payment)
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-on-surface-variant">Status</span>
                            <span class="font-semibold {{ $order->payment->status === 'completed' ? 'text-green-700' : 'text-amber-700' }}">{{ ucfirst($order->payment->status) }}</span>
                        </div>
                        <div class="flex justify-between"><span class="text-on-surface-variant">Gateway</span><span>{{ ucfirst($order->payment->gateway_provider ?? '-') }}</span></div>
                        <div class="flex justify-between"><span class="text-on-surface-variant">Method</span><span>{{ $order->payment->payment_method ?? '-' }}</span></div>
                        @if($order->payment->gateway_reference)
                        <div class="flex justify-between"><span class="text-on-surface-variant">Ref</span><span class="text-xs">{{ $order->payment->gateway_reference }}</span></div>
                        @endif
                        @if($order->payment->paid_at)
                        <div class="flex justify-between"><span class="text-on-surface-variant">Paid</span><span>{{ $order->payment->paid_at->format('d/m/Y H:i') }}</span></div>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-stone-400">Belum ada data pembayaran.</p>
                @endif
            </div>

            {{-- Shipping Action --}}
            @if($order->status === 'paid')
            <div class="bg-surface rounded-xl p-6 shadow-sm">
                <h2 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Kirim Pesanan</h2>
                <form method="POST" action="{{ route('admin-orders.shipping', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-3">
                        <input type="text" name="shipping_courier" placeholder="Kurir (JNE, JNT, dll)"
                            class="w-full px-3 py-2 border border-outline-variant rounded text-sm bg-surface text-on-surface focus:border-primary outline-none">
                        <input type="text" name="shipping_service" placeholder="Layanan (REG, YES, dll)"
                            class="w-full px-3 py-2 border border-outline-variant rounded text-sm bg-surface text-on-surface focus:border-primary outline-none">
                        <input type="text" name="tracking_number" placeholder="Nomor Resi"
                            class="w-full px-3 py-2 border border-outline-variant rounded text-sm bg-surface text-on-surface focus:border-primary outline-none">
                        <button type="submit"
                            class="w-full py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[16px]">local_shipping</span> Tandai Dikirim
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Status Actions --}}
            @if(in_array($order->status, ['shipped']))
            <div class="bg-surface rounded-xl p-6 shadow-sm">
                <h2 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Update Status</h2>
                <form method="POST" action="{{ route('admin-orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="delivered">
                    <button type="submit"
                        class="w-full py-2 bg-green-600 text-white text-sm font-semibold rounded hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span> Tandai Diterima
                    </button>
                </form>
            </div>
            @endif

            @if(in_array($order->status, ['pending', 'paid']))
            <div class="bg-surface rounded-xl p-6 shadow-sm">
                <form method="POST" action="{{ route('admin-orders.status', $order) }}"
                    onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit"
                        class="w-full py-2 bg-red-50 text-red-700 text-sm font-semibold rounded border border-red-200 hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">cancel</span> Batalkan Pesanan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
