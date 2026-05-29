@extends('layouts.app')

@section('content')
<main class="w-full max-w-7xl mx-auto px-5 sm:px-6 lg:px-12 pt-24 sm:pt-28 lg:pt-32 pb-16 sm:pb-20 lg:pb-28">

    {{-- Breadcrumb --}}
    <nav class="mb-8 flex items-center gap-2 font-label-sm text-label-sm text-stone-400">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a href="{{ route('shopping-cart') }}" class="hover:text-primary transition-colors">Cart</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary">Checkout</span>
    </nav>

    <header class="mb-10">
        <h1 class="font-h1 text-4xl sm:text-5xl text-primary">Checkout</h1>
    </header>

    @if(session('error'))
        <div class="bg-red-50 text-red-800 p-4 rounded-sm border border-red-200 mb-6">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            {{-- Left: Customer Info --}}
            <div class="lg:col-span-7 space-y-8">
                <div class="space-y-6">
                    <h2 class="font-h3 text-2xl text-primary border-b border-outline-variant pb-4">Informasi Pengiriman</h2>

                    <div>
                        <label for="customer_name" class="block font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" id="customer_name" name="customer_name"
                            value="{{ old('customer_name', $user->name ?? '') }}"
                            required
                            class="w-full px-4 py-3 border border-outline-variant rounded-lg bg-surface text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md text-body-md"
                            placeholder="Masukkan nama lengkap">
                        @error('customer_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_email" class="block font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2">Email</label>
                        <input type="email" id="customer_email" name="customer_email"
                            value="{{ old('customer_email', $user->email ?? '') }}"
                            required
                            class="w-full px-4 py-3 border border-outline-variant rounded-lg bg-surface text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md text-body-md"
                            placeholder="email@contoh.com">
                        @error('customer_email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="shipping_address" class="block font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2">Alamat Pengiriman</label>
                        <textarea id="shipping_address" name="shipping_address" rows="4"
                            required
                            class="w-full px-4 py-3 border border-outline-variant rounded-lg bg-surface text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md text-body-md resize-none"
                            placeholder="Masukkan alamat pengiriman lengkap">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Order Items Preview --}}
                <div class="space-y-4">
                    <h2 class="font-h3 text-2xl text-primary border-b border-outline-variant pb-4">Ringkasan Pesanan</h2>
                    @foreach($cartItems as $item)
                    <div class="flex gap-4 py-3 border-b border-outline-variant/30">
                        <div class="w-16 h-20 overflow-hidden bg-surface-container rounded">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <p class="font-label-md text-label-md text-primary">{{ $item['name'] }}</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">
                                {{ $item['size'] ?? '-' }} / {{ $item['color'] ?? '-' }} &times; {{ $item['qty'] }}
                            </p>
                        </div>
                        <p class="font-body-md text-body-md text-primary whitespace-nowrap">
                            Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Summary --}}
            <aside class="lg:col-span-5 bg-stone-50 p-8 rounded-lg shadow-[0_20px_40px_-15px_rgba(61,43,31,0.06)] lg:sticky lg:top-32">
                <h2 class="font-h3 text-xl text-primary mb-6 border-b border-outline-variant pb-4">Ringkasan Pembayaran</h2>
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between">
                        <span class="font-label-caps text-label-caps text-on-surface-variant">SUBTOTAL</span>
                        <span class="font-body-lg text-body-lg text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-label-caps text-label-caps text-on-surface-variant">ONGKOS KIRIM</span>
                        <span class="font-body-lg text-body-lg text-primary">
                            @if($shippingCost > 0)
                                Rp {{ number_format($shippingCost, 0, ',', '.') }}
                            @else
                                GRATIS
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between pt-4 border-t border-outline-variant">
                        <span class="font-label-caps text-label-caps text-primary font-bold">TOTAL</span>
                        <span class="font-h3 text-2xl text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:opacity-90 active:scale-[0.98] transition-all flex justify-center items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">lock</span>
                    BAYAR SEKARANG
                </button>

                <p class="text-center text-xs text-on-surface-variant font-label-caps mt-4 leading-relaxed">
                    Anda akan diarahkan ke halaman pembayaran Midtrans.
                </p>
            </aside>
        </div>
    </form>
</main>
@endsection
