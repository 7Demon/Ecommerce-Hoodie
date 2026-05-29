@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<main class="pt-40 pb-32 px-12 max-w-[1440px] mx-auto">
    <header class="mb-20">
        <h1 class="font-h1 text-h1 text-primary">Your Selection</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mt-4">Curating excellence for your wardrobe.</p>
    </header>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
        <!-- Shopping Cart Items List -->
        <div class="lg:col-span-8 space-y-12">
            @if(session('success'))
                <div class="bg-green-50 text-green-800 p-4 rounded-sm border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($cartItems as $id => $item)
            <div class="flex flex-col md:flex-row gap-8 pb-12 border-b border-outline-variant">
                <div class="w-full md:w-48 aspect-[3/4] overflow-hidden bg-surface-container">
                    <img alt="{{ $item['name'] }}" class="w-full h-full object-cover" src="{{ $item['image'] }}"/>
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-h3 text-h3 text-primary mb-2">{{ $item['name'] }}</h3>
                            <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">
                                {{ $item['color'] ?? 'N/A' }}
                            </p>
                        </div>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="cart_id" value="{{ $id }}">
                            <button type="submit" class="text-on-surface-variant hover:text-error transition-colors" title="Remove item">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </form>
                    </div>
                    <div class="mt-8 flex flex-wrap items-center justify-between gap-6">
                        <div class="flex items-center space-x-8">
                            <div>
                                <span class="font-label-caps text-label-caps text-on-surface-variant block mb-2">SIZE</span>
                                <span class="font-body-md text-body-md border border-outline-variant px-4 py-1">{{ $item['size'] ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="font-label-caps text-label-caps text-on-surface-variant block mb-2">QUANTITY</span>
                                <div class="flex items-center border border-outline-variant">
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="cart_id" value="{{ $id }}">
                                        <input type="hidden" name="qty" value="{{ $item['qty'] - 1 }}">
                                        <button type="submit" class="px-3 py-1 hover:bg-surface-container-low transition-colors" {{ $item['qty'] <= 1 ? 'disabled' : '' }}>-</button>
                                    </form>
                                    <span class="px-4 py-1 font-body-md text-body-md">{{ $item['qty'] }}</span>
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="cart_id" value="{{ $id }}">
                                        <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                                        <button type="submit" class="px-3 py-1 hover:bg-surface-container-low transition-colors">+</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-label-caps text-label-caps text-on-surface-variant block mb-1">PRICE</span>
                            <span class="font-h3 text-h3 text-primary">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="py-12 text-center text-stone-500 font-serif">
                    Your cart is currently empty.
                </div>
            @endforelse

            <div class="pt-4">
                <a class="font-label-caps text-label-caps text-primary hover:opacity-70 transition-opacity flex items-center space-x-2" href="{{ route('collections') }}">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    <span>CONTINUE SHOPPING</span>
                </a>
            </div>
        </div>

        <!-- Summary Section -->
        <aside class="lg:col-span-4 bg-stone-50 p-10 shadow-[0_40px_40px_-15px_rgba(61,43,31,0.04)]">
            <h2 class="font-h3 text-h3 text-primary mb-8 border-b border-outline-variant pb-4">Order Summary</h2>
            <div class="space-y-6 mb-12">
                <div class="flex justify-between items-center">
                    <span class="font-label-caps text-label-caps text-on-surface-variant">SUBTOTAL</span>
                    <span class="font-body-lg text-body-lg text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-label-caps text-label-caps text-on-surface-variant">SHIPPING</span>
                    <span class="font-body-lg text-body-lg text-primary">FREE</span>
                </div>
                <div class="pt-6 border-t border-outline-variant flex justify-between items-center">
                    <span class="font-label-caps text-label-caps text-primary font-bold">TOTAL</span>
                    <span class="font-h2 text-h2 text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="space-y-4">
                <button class="w-full py-6 bg-primary-container text-on-primary-container font-label-caps text-label-caps tracking-widest hover:opacity-90 transition-opacity duration-300 {{ count($cartItems) === 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ count($cartItems) === 0 ? 'disabled' : '' }}>
                PROCEED TO CHECKOUT</button>
                <p class="text-center text-xs text-on-surface-variant font-label-caps mt-6 leading-relaxed">
                TAXES AND CUSTOMS DUTIES ARE CALCULATED AT CHECKOUT BASED ON YOUR SHIPPING DESTINATION.</p>
            </div>
            <div class="mt-12 space-y-6 pt-12 border-t border-outline-variant">
                <div class="flex items-center space-x-4">
                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="verified">verified</span>
                    <span class="font-label-caps text-[10px] text-on-surface-variant">SECURE CHECKOUT GUARANTEED</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="local_shipping">local_shipping</span>
                    <span class="font-label-caps text-[10px] text-on-surface-variant">COMPLIMENTARY ECO-PACKAGING</span>
                </div>
            </div>
        </aside>
    </div>
</main>