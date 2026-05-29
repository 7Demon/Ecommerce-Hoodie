@extends('layouts.app')

@section('content')
<main class="w-full max-w-5xl mx-auto px-5 sm:px-6 lg:px-12 pt-24 sm:pt-28 lg:pt-32 pb-16 sm:pb-20 lg:pb-28">

    <header class="mb-10">
        <h1 class="font-h1 text-3xl sm:text-4xl text-primary">Pesanan Saya</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mt-2">Riwayat pesanan Anda.</p>
    </header>

    @if($orders->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <span class="material-symbols-outlined text-[64px] text-stone-300 mb-4">receipt_long</span>
            <p class="font-body-lg text-body-lg text-stone-400 mb-4">Anda belum memiliki pesanan.</p>
            <a href="{{ route('collections') }}" class="px-6 py-3 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:opacity-90 transition-all">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <a href="{{ route('my-orders.show', $order->order_number) }}"
                class="block bg-white border border-outline-variant/30 rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="flex flex-wrap justify-between items-start gap-4">
                    <div class="space-y-1">
                        <p class="font-label-md text-label-md text-primary font-semibold">{{ $order->order_number }}</p>
                        <p class="font-body-md text-body-md text-on-surface-variant">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="text-right space-y-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                            @if($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                            @elseif($order->status === 'paid') bg-emerald-100 text-emerald-800
                            @elseif($order->status === 'pending') bg-amber-100 text-amber-800
                            @else bg-stone-100 text-stone-600
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                        <p class="font-body-lg text-body-lg text-primary font-semibold">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $orders->links('partials.pagination') }}
        </div>
    @endif

</main>
@endsection
