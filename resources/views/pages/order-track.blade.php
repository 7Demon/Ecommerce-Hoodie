@extends('layouts.app')

@section('content')
<main class="w-full max-w-3xl mx-auto px-5 sm:px-6 lg:px-12 pt-24 sm:pt-28 lg:pt-32 pb-16 sm:pb-20 lg:pb-28">

    <header class="mb-10">
        <h1 class="font-h1 text-3xl sm:text-4xl text-primary">Lacak Pesanan</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mt-2">Masukkan nomor pesanan dan email untuk melihat status pesanan Anda.</p>
    </header>

    @if(session('error'))
        <div class="bg-red-50 text-red-800 p-4 rounded-sm border border-red-200 mb-6">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tracking Form --}}
    <form method="POST" action="{{ route('orders.track.submit') }}" class="bg-stone-50 rounded-lg p-8 shadow-sm mb-10">
        @csrf
        <div class="space-y-5">
            <div>
                <label for="order_number" class="block font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2">Nomor Pesanan</label>
                <input type="text" id="order_number" name="order_number"
                    value="{{ old('order_number') }}"
                    required
                    class="w-full px-4 py-3 border border-outline-variant rounded-lg bg-surface text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md text-body-md"
                    placeholder="Contoh: ORD-20260529-ABC12">
            </div>
            <div>
                <label for="customer_email" class="block font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2">Email</label>
                <input type="email" id="customer_email" name="customer_email"
                    value="{{ old('customer_email') }}"
                    required
                    class="w-full px-4 py-3 border border-outline-variant rounded-lg bg-surface text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md text-body-md"
                    placeholder="email@contoh.com">
            </div>
            <button type="submit"
                class="w-full py-3 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:opacity-90 active:scale-[0.98] transition-all flex justify-center items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">search</span>
                LACAK PESANAN
            </button>
        </div>
    </form>

    {{-- Order Result (shown after tracking) --}}
    @isset($order)
    <div class="bg-white rounded-lg border border-outline-variant/30 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-outline-variant/20">
            <div class="flex flex-wrap justify-between items-start gap-4">
                <div>
                    <p class="font-label-caps text-label-caps text-on-surface-variant mb-1">NOMOR PESANAN</p>
                    <p class="font-h3 text-xl text-primary">{{ $order->order_number }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                    @if($order->status === 'delivered') bg-green-100 text-green-800
                    @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                    @elseif($order->status === 'paid') bg-emerald-100 text-emerald-800
                    @elseif($order->status === 'pending') bg-amber-100 text-amber-800
                    @else bg-stone-100 text-stone-600
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="p-6 space-y-4">
            @php
                $steps = [
                    ['status' => 'pending',   'label' => 'Pesanan Dibuat',  'icon' => 'receipt_long',    'time' => $order->created_at],
                    ['status' => 'paid',      'label' => 'Pembayaran Diterima', 'icon' => 'payments',    'time' => $order->paid_at],
                    ['status' => 'shipped',   'label' => 'Dikirim',        'icon' => 'local_shipping',   'time' => $order->shipped_at],
                    ['status' => 'delivered', 'label' => 'Diterima',       'icon' => 'check_circle',     'time' => $order->delivered_at],
                ];
                $statusOrder = ['pending' => 0, 'paid' => 1, 'shipped' => 2, 'delivered' => 3, 'cancelled' => -1];
                $currentStep = $statusOrder[$order->status] ?? -1;
            @endphp

            @if($order->status === 'cancelled')
                <div class="flex items-center gap-3 p-4 bg-red-50 rounded-lg">
                    <span class="material-symbols-outlined text-red-600">cancel</span>
                    <div>
                        <p class="font-label-md text-label-md text-red-800">Pesanan Dibatalkan</p>
                        <p class="font-body-md text-body-md text-red-600">{{ $order->cancelled_at?->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            @else
                <div class="flex items-start gap-4">
                    @foreach($steps as $i => $step)
                        @php
                            $isActive = $i <= $currentStep;
                            $isCurrent = $i === $currentStep;
                        @endphp
                        <div class="flex-1 text-center">
                            <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center mb-2
                                {{ $isActive ? 'bg-primary text-on-primary' : 'bg-stone-100 text-stone-400' }}
                                {{ $isCurrent ? 'ring-2 ring-primary ring-offset-2' : '' }}">
                                <span class="material-symbols-outlined text-[20px]">{{ $step['icon'] }}</span>
                            </div>
                            <p class="font-label-sm text-label-sm {{ $isActive ? 'text-primary' : 'text-stone-400' }}">{{ $step['label'] }}</p>
                            @if($step['time'])
                                <p class="text-[10px] text-on-surface-variant mt-1">{{ $step['time']->format('d/m H:i') }}</p>
                            @endif
                        </div>
                        @if(!$loop->last)
                            <div class="flex-shrink-0 w-8 h-px mt-5 {{ $i < $currentStep ? 'bg-primary' : 'bg-stone-200' }}"></div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tracking Info --}}
        @if($order->tracking_number)
        <div class="px-6 pb-4">
            <div class="bg-surface-container-low rounded-lg p-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant mb-1">NOMOR RESI</p>
                <p class="font-body-lg text-body-lg text-primary font-semibold">
                    {{ $order->shipping_courier ? strtoupper($order->shipping_courier) . ' — ' : '' }}{{ $order->tracking_number }}
                </p>
            </div>
        </div>
        @endif

        {{-- Order Items --}}
        <div class="p-6 border-t border-outline-variant/20">
            <p class="font-label-caps text-label-caps text-on-surface-variant mb-4">ITEM PESANAN</p>
            @foreach($order->items as $item)
            <div class="flex justify-between py-2 border-b border-outline-variant/10 last:border-0">
                <div>
                    <p class="font-body-md text-body-md text-on-surface">{{ $item->product_name }}</p>
                    <p class="font-label-sm text-label-sm text-on-surface-variant">
                        {{ $item->product_size ?? '-' }} / {{ $item->product_color ?? '-' }} &times; {{ $item->quantity }}
                    </p>
                </div>
                <p class="font-body-md text-body-md text-primary">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
            </div>
            @endforeach

            <div class="flex justify-between pt-4 mt-2 border-t border-outline-variant">
                <span class="font-label-md text-label-md text-primary font-bold">TOTAL</span>
                <span class="font-h3 text-xl text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
    @endisset

</main>
@endsection
