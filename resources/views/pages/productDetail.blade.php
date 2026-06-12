@extends('layouts.app')
@section('title', $product->name . ' — HOODIEL')

@section('content')
<main class="w-full max-w-7xl mx-auto px-5 sm:px-6 lg:px-12 pt-24 sm:pt-28 lg:pt-32 pb-16 sm:pb-20 lg:pb-28">

    {{-- Breadcrumb --}}
    <nav class="mb-8 flex items-center gap-2 font-label-sm text-label-sm text-stone-400">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a href="{{ route('collections') }}" class="hover:text-primary transition-colors">Collections</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary">{{ $product->name }}</span>
    </nav>

    {{-- Pass PHP data to JS --}}
    <script>
        const colorVariantsData = @json($colorVariants);
        const firstColor = @json($colors->first());
    </script>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16">

        {{-- ===== Left: Product Image ===== --}}
        <div class="lg:col-span-7 flex flex-col gap-4">
            <div class="w-full aspect-[4/5] bg-surface-container-high relative overflow-hidden rounded-lg">
                <img
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover transition-opacity duration-300"
                    src="{{ $product->image }}"
                    id="mainProductImage"
                />
            </div>
            {{-- Thumbnail strip (unique images per variant) --}}
            @if($variants->count() > 1)
                <div class="flex gap-2 flex-wrap" id="thumbnailStrip">
                    @foreach($variants as $i => $variant)
                        <button
                            data-color="{{ $variant->color }}"
                            data-img="{{ $variant->image }}"
                            onclick="selectThumbnail(this)"
                            class="thumbnail-btn w-16 h-16 overflow-hidden rounded border-2 transition-colors
                                {{ $i === 0 ? 'border-primary' : 'border-transparent hover:border-stone-300' }}">
                            <img src="{{ $variant->image }}" alt="{{ $variant->size }}" class="w-full h-full object-cover"/>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ===== Right: Product Info ===== --}}
        <div class="lg:col-span-5">
            <div class="lg:sticky lg:top-32 flex flex-col gap-8">

                {{-- Header --}}
                <div class="flex flex-col gap-2 border-b border-outline-variant pb-8">
                    <h1 class="font-display-lg text-3xl sm:text-4xl lg:text-display-lg text-on-background leading-tight">
                        {{ $product->name }}
                    </h1>
                    <p id="priceDisplay" class="font-body-lg text-body-lg text-on-surface-variant mt-1">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    @if($product->description)
                        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mt-3">
                            {{ $product->description }}
                        </p>
                    @endif
                </div>

                {{-- ===== Color Selector ===== --}}
                @if($colors->isNotEmpty() && $colors->first() !== null)
                <div class="flex flex-col gap-4">
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                        Color: <span id="selectedColorLabel" class="text-primary font-semibold uppercase">{{ $colors->first() }}</span>
                    </span>
                    <div class="flex flex-wrap gap-3" id="colorSwatches">
                        @foreach($colors as $color)
                            @php
                                $colorVariantList = $colorVariants[$color];
                                $representativeImg = $colorVariantList->first()->image;
                                // Use image thumbnail as swatch
                            @endphp
                            <button
                                type="button"
                                data-color="{{ $color }}"
                                onclick="selectColor(this)"
                                title="{{ $color }}"
                                class="color-swatch-btn relative w-10 h-10 rounded-full overflow-hidden border-2 transition-all
                                    {{ $loop->first ? 'border-primary ring-2 ring-primary ring-offset-2' : 'border-stone-200 hover:border-stone-400' }}">
                                <img src="{{ $representativeImg }}" alt="{{ $color }}" class="w-full h-full object-cover"/>
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ===== Size Selector ===== --}}
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                            Size: <span id="selectedSizeLabel" class="text-primary font-semibold">{{ $variants->first()->size }}</span>
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-3" id="sizeButtonsContainer">
                        {{-- Rendered by JS on color select; pre-populated for first color --}}
                    </div>

                    {{-- Stock badge --}}
                    <p id="stockBadge" class="font-label-sm text-label-sm text-green-700">In stock</p>
                </div>

                {{-- Add to Cart Form --}}
                <form method="POST" action="{{ route('cart.add') }}" class="flex flex-col gap-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="qty" value="1">
                    <input type="hidden" name="size" id="selectedSizeInput" value="{{ $variants->first()->size }}">
                    <input type="hidden" name="color" id="selectedColorInput" value="{{ $colors->first() }}">
                    <button
                        type="submit"
                        id="addToCartBtn"
                        class="w-full py-4 px-8 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:opacity-90 active:scale-[0.98] transition-all flex justify-center items-center gap-2"
                    >
                        <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                        ADD TO CART
                    </button>
                    <p class="font-body-md text-body-md text-center text-on-surface-variant text-sm">
                        Free shipping and returns on all domestic orders.
                    </p>
                </form>

                {{-- Accordion --}}
                <div class="border-t border-outline-variant pt-6 flex flex-col divide-y divide-outline-variant/50">
                    <details class="py-4 group" open>
                        <summary class="flex justify-between items-center cursor-pointer list-none font-label-md text-label-md text-on-background uppercase tracking-wider">
                            The Details
                            <span class="material-symbols-outlined text-[20px] transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mt-4">
                            {{ $product->description ?? 'Crafted from premium materials, designed for lasting comfort and timeless style.' }}
                        </p>
                    </details>
                    <details class="py-4 group">
                        <summary class="flex justify-between items-center cursor-pointer list-none font-label-md text-label-md text-on-background uppercase tracking-wider">
                            Fabric & Care
                            <span class="material-symbols-outlined text-[20px] transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <ul class="font-body-md text-body-md text-on-surface-variant list-disc pl-5 space-y-2 mt-4">
                            <li>Premium heavyweight cotton blend</li>
                            <li>Machine wash cold with like colors</li>
                            <li>Lay flat to dry to preserve structure</li>
                            <li>Made responsibly in Portugal</li>
                        </ul>
                    </details>
                    <details class="py-4 group">
                        <summary class="flex justify-between items-center cursor-pointer list-none font-label-md text-label-md text-on-background uppercase tracking-wider">
                            Shipping & Returns
                            <span class="material-symbols-outlined text-[20px] transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="font-body-md text-body-md text-on-surface-variant space-y-2 mt-4">
                            <p>Free standard shipping on all domestic orders.</p>
                            <p>Returns accepted within 30 days of delivery.</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    // ─── Helpers ──────────────────────────────────────────────────────────────
    function formatRupiah(amount) {
        return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
    }

    function updateStockBadge(avail) {
        const badge = document.getElementById('stockBadge');
        const btn   = document.getElementById('addToCartBtn');
        if (avail <= 0) {
            badge.textContent = 'Out of stock';
            badge.className   = 'font-label-sm text-label-sm text-red-600';
            btn.disabled      = true;
        } else if (avail <= 5) {
            badge.textContent = `Only ${avail} left`;
            badge.className   = 'font-label-sm text-label-sm text-amber-600';
            btn.disabled      = false;
        } else {
            badge.textContent = 'In stock';
            badge.className   = 'font-label-sm text-label-sm text-green-700';
            btn.disabled      = false;
        }
    }

    // ─── Render size buttons for a given color ────────────────────────────────
    function renderSizeButtons(color) {
        const container = document.getElementById('sizeButtonsContainer');
        container.innerHTML = '';

        const variants = colorVariantsData[color] ?? [];
        if (variants.length === 0) return;

        variants.forEach((v, i) => {
            const avail = (v.stock || 0) - (v.reserved_stock || 0);
            const btn   = document.createElement('button');
            btn.type             = 'button';
            btn.dataset.size      = v.size;
            btn.dataset.price     = v.price;
            btn.dataset.stock     = v.stock;
            btn.dataset.reserved  = v.reserved_stock;
            btn.dataset.image     = v.image;
            btn.dataset.variantId = v.id;
            btn.onclick = function() { selectSize(this); };

            btn.className = [
                'size-btn relative min-w-[56px] px-4 py-3 border rounded-lg',
                'font-label-md text-label-md transition-all',
                i === 0
                    ? 'bg-primary border-primary text-on-primary shadow-sm'
                    : 'border-outline-variant text-on-surface hover:border-outline hover:bg-surface-container',
                avail <= 0 ? 'opacity-40 cursor-not-allowed line-through' : '',
            ].join(' ');

            btn.disabled    = avail <= 0;
            btn.textContent = v.size;
            container.appendChild(btn);
        });

        // Auto-select first available
        const firstAvailBtn = container.querySelector('.size-btn:not([disabled])');
        if (firstAvailBtn) {
            selectSize(firstAvailBtn, false); // false = don't update color label again
        }
    }

    // ─── Color swatch click ───────────────────────────────────────────────────
    function selectColor(btn) {
        // Update swatch active state
        document.querySelectorAll('.color-swatch-btn').forEach(b => {
            b.classList.remove('border-primary', 'ring-2', 'ring-primary', 'ring-offset-2');
            b.classList.add('border-stone-200');
        });
        btn.classList.add('border-primary', 'ring-2', 'ring-primary', 'ring-offset-2');
        btn.classList.remove('border-stone-200');

        const color = btn.dataset.color;
        document.getElementById('selectedColorLabel').textContent = color ? color.toUpperCase() : '';
        document.getElementById('selectedColorInput').value = color ?? '';

        // Update main image to first variant of this color
        const variants = colorVariantsData[color] ?? [];
        if (variants.length > 0 && variants[0].image) {
            document.getElementById('mainProductImage').src = variants[0].image;
        }

        // Re-render size buttons
        renderSizeButtons(color);
    }

    // ─── Size button click ─────────────────────────────────────────────────────
    function selectSize(btn) {
        document.querySelectorAll('#sizeButtonsContainer .size-btn').forEach(b => {
            b.classList.remove('bg-primary', 'border-primary', 'text-on-primary', 'shadow-sm');
            b.classList.add('border-outline-variant', 'text-on-surface', 'hover:border-outline', 'hover:bg-surface-container');
        });
        btn.classList.add('bg-primary', 'border-primary', 'text-on-primary', 'shadow-sm');
        btn.classList.remove('border-outline-variant', 'text-on-surface', 'hover:border-outline', 'hover:bg-surface-container');

        const size     = btn.dataset.size;
        const stock    = parseInt(btn.dataset.stock)    || 0;
        const reserved = parseInt(btn.dataset.reserved) || 0;
        const price    = parseFloat(btn.dataset.price)  || 0;
        const avail    = stock - reserved;

        document.getElementById('selectedSizeLabel').textContent = size;
        document.getElementById('selectedSizeInput').value = size;

        // Update hidden product_id to match the exact variant row
        if (btn.dataset.variantId) {
            document.querySelector('input[name="product_id"]').value = btn.dataset.variantId;
        }

        // Update main image if variant has its own image
        if (btn.dataset.image) {
            document.getElementById('mainProductImage').src = btn.dataset.image;
        }

        updateStockBadge(avail);
        document.getElementById('priceDisplay').textContent = formatRupiah(price);
    }

    function selectThumbnail(btn) {
        document.querySelectorAll('.thumbnail-btn').forEach(b => {
            b.classList.remove('border-primary');
            b.classList.add('border-transparent', 'hover:border-stone-300');
        });
        btn.classList.add('border-primary');
        btn.classList.remove('border-transparent');
        document.getElementById('mainProductImage').src = btn.dataset.img;

        // Also select matching color if data-color is set
        if (btn.dataset.color) {
            const matchSwatch = document.querySelector(`.color-swatch-btn[data-color="${btn.dataset.color}"]`);
            if (matchSwatch) selectColor(matchSwatch);
        }
    }

    // ─── Init on page load ────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        renderSizeButtons(firstColor);
    });
</script>
@endpush

@endsection