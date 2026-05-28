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
            <!-- Item 1 -->
            <div class="flex flex-col md:flex-row gap-8 pb-12 border-b border-outline-variant">
                <div class="w-full md:w-48 aspect-[3/4] overflow-hidden bg-surface-container">
                    <img alt="Luxury Hoodie" class="w-full h-full object-cover" data-alt="A high-end heavyweight hoodie in deep obsidian black, draped elegantly over a minimalist marble plinth. The lighting is dramatic and moody, casting soft shadows that highlight the premium cotton texture. The aesthetic is clean, editorial, and sophisticated, consistent with a luxury fashion boutique's visual language." src="https://lh3.googleusercontent.com/aida-public/AB6AXuD_LZ6LuTY7ioj9O_4cUkEzeTL7wRDnNQrWgNuWyEk9bEmPsUmweMPJguJttwFAVYlI-yGBu6rgSQiXgxTxkhffrtut-X2fUVxV_5rrtQi3UhlrQ9_WuHac3O0DDsOdlqRNgyYWRFwdvT5zgE5hEHHjjDkWiIx6rooGk25x9vJLZ44VXwiotdBtG2MCNfhOTZib1InxX_qVxn3AUU5WKR1KsbPsK4TOc_XAgRDyoWBpLhXi2cowpvljeXIjILpWXf4gsuOTZOZQcq0"/>
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-h3 text-h3 text-primary mb-2">Signature Heavyweight Hoodie</h3>
                            <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Midnight Obsidian</p>
                        </div>
                        <button class="text-on-surface-variant hover:text-error transition-colors">
                        <span class="material-symbols-outlined" data-icon="close">close</span></button>
                    </div>
                    <div class="mt-8 flex flex-wrap items-center justify-between gap-6">
                        <div class="flex items-center space-x-8">
                        <div>
                            <span class="font-label-caps text-label-caps text-on-surface-variant block mb-2">SIZE</span>
                            <span class="font-body-md text-body-md border border-outline-variant px-4 py-1">L</span>
                        </div>
                        <div>
                            <span class="font-label-caps text-label-caps text-on-surface-variant block mb-2">QUANTITY</span>
                            <div class="flex items-center border border-outline-variant">
                                <button class="px-3 py-1 hover:bg-surface-container-low transition-colors">-</button>
                                <span class="px-4 py-1 font-body-md text-body-md">1</span>
                                <button class="px-3 py-1 hover:bg-surface-container-low transition-colors">+</button>
                            </div>
                        </div>
                        </div>
                        <div class="text-right">
                            <span class="font-label-caps text-label-caps text-on-surface-variant block mb-1">PRICE</span>
                            <span class="font-h3 text-h3 text-primary">$185.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="flex flex-col md:flex-row gap-8 pb-12 border-b border-outline-variant">
                <div class="w-full md:w-48 aspect-[3/4] overflow-hidden bg-surface-container">
                    <img alt="Premium Hoodie" class="w-full h-full object-cover" data-alt="A premium oversized hoodie in a soft, architectural sand tone, captured in a bright and airy studio setting. The fabric quality is visible in the structured drape and reinforced seams. Subtle ambient shadows emphasize its minimalist design, fitting perfectly within a high-fashion boutique's serene and exclusive atmosphere." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBg_kzZ_K6oVZHXsuMrufIB2mtWhcuCWMwrRLvYh7tzluM5fHmU3Z4bq6opoNrzpeUcLxI5g4xUJmbE4kTy5sD8PtvC9N7Vvr3Pn2CR_bx7ajCi7pPbEVea9Euohz_74mB8C7N-xgYIDEafrW5p_HEgMp61_-Zq93vl5L7k4Lrit7fv_YAU4KIYEzjJoDzp7IFFf6zSAgapXsRFuhcaBEU5q8nKdB-Z0QSaDlRd6q1nRzL7lMo1ivESIx_JnTmzGchOakyMPcQUw0I"/>
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-h3 text-h3 text-primary mb-2">Architectural Boxy Hoodie</h3>
                            <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Ethereal Sand</p>
                        </div>
                        <button class="text-on-surface-variant hover:text-error transition-colors">
                        <span class="material-symbols-outlined" data-icon="close">close</span></button>
                    </div>
                    <div class="mt-8 flex flex-wrap items-center justify-between gap-6">
                        <div class="flex items-center space-x-8">
                            <div>
                                <span class="font-label-caps text-label-caps text-on-surface-variant block mb-2">SIZE</span>
                                <span class="font-body-md text-body-md border border-outline-variant px-4 py-1">M</span>
                            </div>
                            <div>
                                <span class="font-label-caps text-label-caps text-on-surface-variant block mb-2">QUANTITY</span>
                                <div class="flex items-center border border-outline-variant">
                                    <button class="px-3 py-1 hover:bg-surface-container-low transition-colors">-</button>
                                    <span class="px-4 py-1 font-body-md text-body-md">1</span>
                                    <button class="px-3 py-1 hover:bg-surface-container-low transition-colors">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-label-caps text-label-caps text-on-surface-variant block mb-1">PRICE</span>
                            <span class="font-h3 text-h3 text-primary">$210.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-4">
                <a class="font-label-caps text-label-caps text-primary hover:opacity-70 transition-opacity flex items-center space-x-2" href="#">
                    <span class="material-symbols-outlined text-sm" data-icon="arrow_back">arrow_back</span>
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
                    <span class="font-body-lg text-body-lg text-primary">$395.00</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-label-caps text-label-caps text-on-surface-variant">SHIPPING</span>
                    <span class="font-body-lg text-body-lg text-primary">$15.00</span>
                </div>
                <div class="pt-6 border-t border-outline-variant flex justify-between items-center">
                    <span class="font-label-caps text-label-caps text-primary font-bold">TOTAL</span>
                    <span class="font-h2 text-h2 text-primary">$410.00</span>
                </div>
            </div>
            <div class="space-y-4">
                <button class="w-full py-6 bg-primary-container text-on-primary-container font-label-caps text-label-caps tracking-widest hover:opacity-90 transition-opacity duration-300">
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