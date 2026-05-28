@extends('layouts.app')

@section('title', 'Collections — Estrella Boutique')

@section('content')
<!-- Main Content Canvas -->
<main class="mx-auto min-h-screen w-full max-w-[1920px] px-5 pb-16 pt-24 sm:px-6 sm:pb-20 sm:pt-28 lg:px-12 lg:pt-32">
    <!-- Hero Header -->
    <header class="mb-10 sm:mb-14 lg:mb-20">
        <div class="flex flex-col justify-between gap-6 border-b border-stone-200 pb-8 md:flex-row md:items-end lg:gap-8 lg:pb-12">
            <div>
                <span class="font-label-caps text-label-caps text-on-secondary-container mb-4 block uppercase">Curated Apparel</span>
                <h1 class="font-h1 text-4xl leading-tight text-primary sm:text-5xl lg:text-h1">Collections</h1>
            </div>
            <p class="max-w-md font-body-lg text-body-lg text-secondary leading-relaxed">
                A discipline of form and fabric. Each piece is meticulously engineered to provide an investment in comfort and aesthetic longevity.
            </p>
        </div>
    </header>

    <div class="flex flex-col gap-10 md:flex-row lg:gap-16">
        <!-- Sidebar Filters / Sort -->
        <aside class="w-full shrink-0 md:w-56">
            {{-- Mobile: collapsible --}}
            <details class="border-b border-stone-200 pb-5 md:hidden">
                <summary class="flex cursor-pointer list-none items-center justify-between font-label-caps text-label-caps uppercase tracking-widest text-primary">
                    Sort
                    <span class="material-symbols-outlined text-[20px]">sort</span>
                </summary>
                <div class="mt-6 space-y-3">
                    @foreach([
                        'latest'     => 'Newest',
                        'name_asc'   => 'Name A–Z',
                        'name_desc'  => 'Name Z–A',
                        'price_asc'  => 'Price: Low to High',
                        'price_desc' => 'Price: High to Low',
                    ] as $value => $label)
                        <a href="{{ route('collections', ['sort' => $value]) }}"
                            class="flex min-h-10 items-center gap-2 font-body-md text-body-md transition-colors
                                {{ ($sort ?? 'latest') === $value ? 'text-primary font-semibold' : 'text-stone-500 hover:text-primary' }}">
                            @if(($sort ?? 'latest') === $value)
                                <span class="material-symbols-outlined text-[16px]">radio_button_checked</span>
                            @else
                                <span class="material-symbols-outlined text-[16px]">radio_button_unchecked</span>
                            @endif
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </details>

            {{-- Desktop: always visible --}}
            <div class="hidden md:block">
                <h3 class="font-label-caps text-label-caps text-primary uppercase mb-6 tracking-widest">Sort By</h3>
                <div class="space-y-3">
                    @foreach([
                        'latest'     => 'Newest',
                        'name_asc'   => 'Name A–Z',
                        'name_desc'  => 'Name Z–A',
                        'price_asc'  => 'Price: Low to High',
                        'price_desc' => 'Price: High to Low',
                    ] as $value => $label)
                        <a href="{{ route('collections', ['sort' => $value]) }}"
                            class="flex items-center gap-2 font-body-md text-body-md transition-colors
                                {{ ($sort ?? 'latest') === $value ? 'text-primary font-semibold' : 'text-stone-500 hover:text-primary' }}">
                            @if(($sort ?? 'latest') === $value)
                                <span class="material-symbols-outlined text-[16px]">radio_button_checked</span>
                            @else
                                <span class="material-symbols-outlined text-[16px]">radio_button_unchecked</span>
                            @endif
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="grow">
            @if($products->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <span class="material-symbols-outlined text-[64px] text-stone-300 mb-4">inventory_2</span>
                    <p class="font-body-lg text-body-lg text-stone-400">No products available yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-gutter xl:gap-y-16">
                    @foreach($products as $product)
                        <div class="group">
                            <a href="{{ route('details', ['name' => $product->name]) }}" class="block">
                                <div class="aspect-[3/4] overflow-hidden bg-white mb-6 relative">
                                    <img
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                        loading="lazy"
                                        src="{{ $product->image }}"
                                    />
                                    @if($product->stock <= 0)
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-primary-fixed text-primary px-3 py-1 font-label-caps text-[10px] tracking-widest uppercase">Sold Out</span>
                                        </div>
                                    @else
                                        <button
                                            aria-label="View {{ $product->name }}"
                                            class="absolute bottom-4 right-4 bg-primary text-white p-3 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                                            type="button"
                                            onclick="window.location='{{ route('details', ['name' => $product->name]) }}'">
                                            <span class="material-symbols-outlined">arrow_forward</span>
                                        </button>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <h3 class="font-h3 text-xl text-primary mb-1">{{ $product->name }}</h3>
                                    <p class="font-body-md text-secondary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-14 lg:mt-20">
                    {{ $products->appends(request()->query())->links('partials.pagination') }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
