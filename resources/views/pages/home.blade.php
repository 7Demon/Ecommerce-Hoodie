@extends('layouts.app')

@section('title', 'HOODIEL')

@section('content')
<main>
    <!-- Hero Section -->
    <section class="relative flex min-h-[680px] w-full items-center overflow-hidden lg:min-h-screen">
        <div class="absolute inset-0 z-0">
            <img alt="Hero" class="w-full h-full object-cover" data-alt="A cinematic, high-resolution close-up of a premium, heavyweight chocolate brown cotton hoodie draped elegantly over a minimalist white pedestal. The lighting is soft and directional, casting subtle shadows that highlight the rich texture of the fabric and the precision of the stitching. The background is a clean, bright neutral cream tone, evoking a high-fashion editorial aesthetic. The overall mood is sophisticated, calm, and expensive." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAxj8VFK3YEPZUZDSsb0hgzyxz0ozUmgaTDVWMYidzEBHH3HNh389uoP9h_NWBSzxjXB76ONlX1z48lr2PvFuWEaFL_xC9wbfJd64Eu9h3yb9S5YelJe78Zv-4zup6tAFRKWO4Lk4zifjUvUvQr71FaO7ltkPNq35_AMddPBjuIx7fSG9HHEw8HFHgvXAYgovNgUkrkwE5EwWqlBosCxP8pjdqdF0t3LqdHOXp8wZYaJY1KTLXn_OQ1fvBa8ZZPVDqdpLUdZ6wqF6I"/>
            <div class="absolute inset-0 bg-black/35"></div>
        </div>
        <div class="relative z-10 mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-12">
            <div class="max-w-2xl">
                <h1 class="mb-6 font-h1 text-4xl leading-tight text-white sm:text-5xl lg:text-7xl">THE ART OF COMFORT</h1>
                <p class="font-body-lg text-body-lg text-slate-300 mb-12 max-w-lg">Experience the intersection of architectural structure and soft luxury. Our signature heavyweight hoodies are engineered for the modern aesthetician.</p>
                <a class="inline-flex min-h-11 items-center bg-primary-container px-8 py-4 font-label-caps text-label-caps text-on-primary shadow-xl transition-all duration-300 hover:opacity-90" href="{{ route('collections') }}">
                    Explore Collection
                </a>
            </div>
        </div>
    </section>
    <!-- Featured Products -->
    <section class="mx-auto max-w-7xl px-5 py-16 sm:px-6 sm:py-20 lg:px-12 lg:py-28">
        <div class="mb-12 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between lg:mb-20">
            <div>
                <span class="font-label-caps text-label-caps text-on-tertiary-container mb-4 block">CURATED SELECTION</span>
                <h2 class="font-h2 text-3xl text-primary sm:text-4xl lg:text-h2">Essential Silhouettes</h2>
            </div>
            <a class="font-label-caps text-label-caps border-b border-primary pb-1 text-primary" href="{{ route('collections') }}">View All</a>
        </div>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 lg:gap-gutter">
            @php
                $featured = \App\Models\Product::selectRaw('MIN(id) as id, name, MIN(price) as price, image, description')
                    ->groupBy('name', 'image', 'description')
                    ->latest('id')
                    ->limit(3)
                    ->get();
            @endphp
            @foreach($featured as $product)
                <a href="{{ route('details', ['name' => $product->name]) }}" class="group cursor-pointer block">
                    <div class="aspect-[3/4] mb-8 bg-surface-container-low overflow-hidden">
                        <img
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            src="{{ $product->image }}"
                        />
                    </div>
                    <div class="text-center">
                        <h3 class="font-h3 text-[1.25rem] mb-2 text-primary">{{ $product->name }}</h3>
                        <p class="font-body-md text-secondary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    <!-- Brand Story -->
    <section class="bg-primary-container px-5 py-16 sm:px-6 sm:py-20 lg:px-12 lg:py-28">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-12 lg:gap-20 items-center">
            <div class="md:w-1/2">
            <img alt="Brand Story" class="w-full h-[360px] sm:h-[480px] lg:h-[600px] object-cover rounded-lg shadow-2xl" loading="lazy" data-alt="A black and white high-fashion photography shot showing a designer's hands carefully tracing a pattern on a piece of heavy chocolate brown cotton fabric. The environment is a sun-drenched atelier with large industrial windows and minimalist wooden furniture. The focus is sharp on the texture of the fabric and the precision of the hands, conveying a sense of heritage, craftsmanship, and artisanal value in the apparel industry." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC7svPiCGely8M0jrsyv43r1sf-ZbAP7oGab-rbncjT_qctsHcdSL_cw6tlBmgCtBqbWbh_ltj-gblipoQ06EDdnP-7jkoGUljhaGu2ARhGAwQRf78VAiMwPEtmw7_RRp3tYmgWj60o3ZEyKprDhqJ_Vkn8WqQG-K9hrTZqzRyZbeVByUOxeQZjgr1WNZnJPm_vkr4fytNnnGK0AG0gWqrLCJmLpESF1e6Br8NAex51iP3LZXjj2MP-QLvjsQcLwRqgo-GqcyHOuM4"/>
            </div>
            <div class="md:w-1/2 text-on-primary">
                <span class="font-label-caps text-label-caps text-on-primary-container mb-6 block uppercase tracking-[0.2em]">Our Heritage</span>
                <h2 class="font-h2 text-3xl sm:text-4xl lg:text-h2 mb-10 leading-tight">Crafted for the Discerning Eye.</h2>
                <p class="font-body-lg text-body-lg text-on-primary-container mb-8 leading-relaxed">
                ESTRELLA was founded on the principle that the most personal garment in a wardrobe—the hoodie—deserved the same architectural rigor as a bespoke suit.</p>
                <p class="font-body-lg text-body-lg text-on-primary-container mb-12 leading-relaxed">
                 Each piece is constructed from 500GSM organic cotton, harvested sustainably and dyed using custom-developed chocolate and cream pigments. We believe in slow fashion, where every stitch is an intentional step toward longevity</p>
                <button class="border border-on-primary-container text-on-primary px-10 py-4 font-label-caps text-label-caps rounded-lg hover:bg-white/10 transition-colors">
                Learn More</button>
            </div>
        </div>
    </section>
    <!-- Collections Teaser -->
    <section class="py-16 px-5 sm:px-6 sm:py-20 lg:px-12 lg:py-28 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:gap-gutter">
            <div class="relative h-[360px] lg:h-[500px] group overflow-hidden cursor-pointer">
                <img alt="Collection" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" data-alt="A wide-angle lifestyle shot of a model wearing an oversized cream hoodie, standing in a vast, empty concrete architectural space. The lighting is dramatic, with a single beam of light illuminating the subject from above. The color story is monochromatic cream and grey, punctuated by the deep chocolate tones of the brand's identity. The image is clean, powerful, and emphasizes the garment's sculptural silhouette." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBGK7qqSM7vU6CnD8cQgQ3FjIwOMWxYTo9QpMU3tqiBYl4dWUFv9o-LQqgJmnl1ejY-Blq-_Ex2mLaSJ5q_Op_wykIEBmjZSr0tTyBe6uQ8RUXnspNfsbODn5rzGguGNlE3i8u7YFoC1cHFM2x0fcSS65zQLy7Imz14WRSzQFM7ujx6C_g_-5L6VnDxYWr9kkQeO-olmEdn0E987nRdFEzZrQGd-J0pjJdyD5cbecj20BF3-UCm4N8vP_5PdQ8fFDXsybY9mG6GrKI"/>
                <div class="absolute inset-0 bg-black/20 flex flex-col justify-center items-center text-white">
                    <h3 class="font-h2 text-3xl sm:text-4xl lg:text-h2 mb-4">Summer Knits</h3>
                    <p class="font-label-caps text-label-caps tracking-widest border-b border-white pb-1">Shop Now</p>
                </div>
            </div>
            <div class="relative h-[360px] lg:h-[500px] group overflow-hidden cursor-pointer">
                <img alt="Collection" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" data-alt="A close-up editorial shot of multiple chocolate brown hoodies hanging on a sleek brass rail in a minimalist boutique setting. The background is a soft, textured plaster wall in a warm tan color. The composition focuses on the repetition of forms and the luxurious consistency of the brand's color palette. The soft, ambient lighting highlights the premium quality of the heavy cotton fabric." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDyxwHfVmQeaJ-OfF4FHz_LMb56VFw3wjqzslR6_7qVBFu1QByVGBCILDb7ZaGF4AsJ_Z-Di_K7Ojt9zO4t3OPlOe0OjtH2jHfYSgm6OfxvxDPTJ0o8u-e7NOjJUAjTxgzjxp0xMRy3a4mAUjRxbB8OHHuQubmXYKUOQ7rdqNPbBFJTQmIy0PY6Rvf1EX7Q9f0z6XVKbNqwIUWpbtivClIvo84l-E4MXg4zt5BlYGWuRhrCc_rq6TRQ296yGCZLMB1fHdTW3HppYZc"/>
                <div class="absolute inset-0 bg-black/20 flex flex-col justify-center items-center text-white">
                    <h3 class="font-h2 text-3xl sm:text-4xl lg:text-h2 mb-4">Core Essentials</h3>
                    <p class="font-label-caps text-label-caps tracking-widest border-b border-white pb-1">Shop Now</p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
