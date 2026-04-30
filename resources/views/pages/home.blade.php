<!-- Menggunakan layout utama yang tadi kita buat -->
@extends('layouts.app')

<!-- Mengubah title halaman (opsional, karena di app.blade.php kita buat defaultnya) -->
@section('title', 'Home - Estrella Boutique')

<!-- Mengisi bagian @yield('content') -->
@section('content')
<main>
    <!-- Hero Section -->
    <section class="relative h-screen w-full flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img alt="Hero" class="w-full h-full object-cover" data-alt="A cinematic, high-resolution close-up of a premium, heavyweight chocolate brown cotton hoodie draped elegantly over a minimalist white pedestal. The lighting is soft and directional, casting subtle shadows that highlight the rich texture of the fabric and the precision of the stitching. The background is a clean, bright neutral cream tone, evoking a high-fashion editorial aesthetic. The overall mood is sophisticated, calm, and expensive." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAxj8VFK3YEPZUZDSsb0hgzyxz0ozUmgaTDVWMYidzEBHH3HNh389uoP9h_NWBSzxjXB76ONlX1z48lr2PvFuWEaFL_xC9wbfJd64Eu9h3yb9S5YelJe78Zv-4zup6tAFRKWO4Lk4zifjUvUvQr71FaO7ltkPNq35_AMddPBjuIx7fSG9HHEw8HFHgvXAYgovNgUkrkwE5EwWqlBosCxP8pjdqdF0t3LqdHOXp8wZYaJY1KTLXn_OQ1fvBa8ZZPVDqdpLUdZ6wqF6I"/>
            <div class="absolute inset-0 bg-black/5"></div>
        </div>
        <div class="relative z-10 px-12 max-w-7xl mx-auto w-full">
            <div class="max-w-2xl">
                <h1 class="font-h1 text-h1 text-white mb-8">THE ART OF COMFORT</h1>
                <p class="font-body-lg text-body-lg text-slate-300 mb-12 max-w-lg">Experience the intersection of architectural structure and soft luxury. Our signature heavyweight hoodies are engineered for the modern aesthetician.</p>
                <button class="bg-primary-container text-on-primary px-10 py-5 font-label-caps text-label-caps rounded-lg hover:opacity-90 transition-all duration-300 shadow-xl">
                Explore Collection</button>
            </div>
        </div>
    </section>
    <!-- Featured Products -->
    <section class="py-32 px-12 max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-20">
            <div>
                <span class="font-label-caps text-label-caps text-on-tertiary-container mb-4 block">CURATED SELECTION</span>
                <h2 class="font-h2 text-h2 text-primary">Essential Silhouettes</h2>
            </div>
            <a class="font-label-caps text-label-caps border-b border-primary pb-1 text-primary" href="#">View All</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            <!-- Product 1 -->
            <div class="group cursor-pointer">
                <div class="aspect-[3/4] mb-8 bg-surface-container-low overflow-hidden">
                    <img alt="Product" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A minimalist product shot of a deep chocolate brown oversized hoodie against a soft tan background. The garment is shown from a three-quarter angle to emphasize the architectural volume of the hood and the drop-shoulder seam. Natural light filters in from a side window, creating high-contrast highlight and shadow. The aesthetic is clean, modern, and aligned with high-end luxury fashion branding." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBBG4evhmmxxBlszSPKNStWJLwEnwag51SVcU51qAiPDi4cKEiO6llHul27yVMfJRg34tdlWYr_2IcHBFwFDi5pQXpBagOr0q0NSnJkFqy49UrMnOjs7QddJogOoh2qt8CVsv5Uz2hAnfb_BCWkTs6TPsUwcxOf_HBliZ6redfpB66PXcFAcQg5XdXnd0EKejm35vtx779I-_dtt6K-GogXRA8lB6ZZ_45n2vapPVAo8p1BH-YX5KfG0rocQMXicRjobPPUHoH9oAM"/>
                </div>
                <div class="text-center">
                    <h3 class="font-h3 text-[1.25rem] mb-2 text-primary">The Archival Hoodie</h3>
                    <p class="font-body-md text-secondary">$185.00</p>
                </div>
            </div>
            <!-- Product 2 -->
            <div class="group cursor-pointer">
                <div class="aspect-[3/4] mb-8 bg-surface-container-low overflow-hidden">
                    <img alt="Product" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A premium sand-colored neutral hoodie displayed on a ghost mannequin, creating a floating effect against a crisp white gallery background. The fabric has a visible, high-quality knit texture. The lighting is bright and even, highlighting the soft curves of the garment. The image composition is perfectly centered, reflecting an orderly and upscale boutique presentation style with a focus on tactile quality." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2WJNy16xh12R4OxAom9ybXcSzVJ4_Klbxn_PTLCHIl8vMC1O9cv6Ad8eRZMbDxTPexkaIgA0K4c9OkKvt8nEVgQK3axfzDeSImwlZ31bG10AWy1PbHDrC02dI8tRxn-_mVwaAsJIBrFSxCooYKy1kBskzpOZv3blAVuqEZKWPsVhQXkMMeg5VSNnZWr_YZinX8ny86ovZ_C1p2BkNIXhaOaI8aeg-uYy8SxDsvPZvwlvOokWTljD8VRQhzrvPMR1HAncupJOfjVc"/>
                </div>
                <div class="text-center">
                    <h3 class="font-h3 text-[1.25rem] mb-2 text-primary">Standard Fleece</h3>
                    <p class="font-body-md text-secondary">$145.00</p>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="group cursor-pointer">
                <div class="aspect-[3/4] mb-8 bg-surface-container-low overflow-hidden">
                    <img alt="Product" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" data-alt="A close-up artistic shot of a charcoal grey premium hoodie's texture and silver metal aglets. The hoodie is neatly folded on a dark oak wooden surface. The mood is moody and atmospheric, using low-key lighting to accentuate the premium nature of the materials. The color palette is dominated by deep greys, warm browns, and sharp highlights on metallic details, maintaining a cohesive luxury visual identity." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhe8_7oH441QHx7NLv-rN31953LJdIadBhE5ZwQCq8hBmTI48RJiBeFEcaF59KkhMleK4vDazeIEfBEq-ZM8xRQJACVCjgXKCHvigeh4F2Y6wLAo6Y1i0DsDm4bQbLe1X2eVcfQmCXNJKBdIyKA5tOMHmQ1y3BBwYUER8tN5WhksdaJloW6ALPcCkCrB6ySzZeQL6rQ9amgNeOvStstwo5Mes1ICzt3vgtqAl4BZTuWkHEibb-hIWsezkHIoAFzcPOycZMVbrY8Wg"/>
                </div>
                <div class="text-center">
                <   h3 class="font-h3 text-[1.25rem] mb-2 text-primary">Sculptural Wrap</>
                    <p class="font-body-md text-secondary">$210.00</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Brand Story -->
    <section class="bg-primary-container py-32 px-12">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-20 items-center">
            <div class="md:w-1/2">
            <img alt="Brand Story" class="w-full h-[600px] object-cover rounded-lg shadow-2xl" data-alt="A black and white high-fashion photography shot showing a designer's hands carefully tracing a pattern on a piece of heavy chocolate brown cotton fabric. The environment is a sun-drenched atelier with large industrial windows and minimalist wooden furniture. The focus is sharp on the texture of the fabric and the precision of the hands, conveying a sense of heritage, craftsmanship, and artisanal value in the apparel industry." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC7svPiCGely8M0jrsyv43r1sf-ZbAP7oGab-rbncjT_qctsHcdSL_cw6tlBmgCtBqbWbh_ltj-gblipoQ06EDdnP-7jkoGUljhaGu2ARhGAwQRf78VAiMwPEtmw7_RRp3tYmgWj60o3ZEyKprDhqJ_Vkn8WqQG-K9hrTZqzRyZbeVByUOxeQZjgr1WNZnJPm_vkr4fytNnnGK0AG0gWqrLCJmLpESF1e6Br8NAex51iP3LZXjj2MP-QLvjsQcLwRqgo-GqcyHOuM4"/>
            </div>
            <div class="md:w-1/2 text-on-primary">
                <span class="font-label-caps text-label-caps text-on-primary-container mb-6 block uppercase tracking-[0.2em]">Our Heritage</span>
                <h2 class="font-h2 text-h2 mb-10 leading-tight">Crafted for the Discerning Eye.</h2>
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
    <section class="py-32 px-12 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
            <div class="relative h-[500px] group overflow-hidden cursor-pointer">
                <img alt="Collection" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" data-alt="A wide-angle lifestyle shot of a model wearing an oversized cream hoodie, standing in a vast, empty concrete architectural space. The lighting is dramatic, with a single beam of light illuminating the subject from above. The color story is monochromatic cream and grey, punctuated by the deep chocolate tones of the brand's identity. The image is clean, powerful, and emphasizes the garment's sculptural silhouette." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBGK7qqSM7vU6CnD8cQgQ3FjIwOMWxYTo9QpMU3tqiBYl4dWUFv9o-LQqgJmnl1ejY-Blq-_Ex2mLaSJ5q_Op_wykIEBmjZSr0tTyBe6uQ8RUXnspNfsbODn5rzGguGNlE3i8u7YFoC1cHFM2x0fcSS65zQLy7Imz14WRSzQFM7ujx6C_g_-5L6VnDxYWr9kkQeO-olmEdn0E987nRdFEzZrQGd-J0pjJdyD5cbecj20BF3-UCm4N8vP_5PdQ8fFDXsybY9mG6GrKI"/>
                <div class="absolute inset-0 bg-black/20 flex flex-col justify-center items-center text-white">
                    <h3 class="font-h2 text-h2 mb-4">Summer Knits</h3>
                    <p class="font-label-caps text-label-caps tracking-widest border-b border-white pb-1">Shop Now</p>
                </div>
            </div>
            <div class="relative h-[500px] group overflow-hidden cursor-pointer">
                <img alt="Collection" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" data-alt="A close-up editorial shot of multiple chocolate brown hoodies hanging on a sleek brass rail in a minimalist boutique setting. The background is a soft, textured plaster wall in a warm tan color. The composition focuses on the repetition of forms and the luxurious consistency of the brand's color palette. The soft, ambient lighting highlights the premium quality of the heavy cotton fabric." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDyxwHfVmQeaJ-OfF4FHz_LMb56VFw3wjqzslR6_7qVBFu1QByVGBCILDb7ZaGF4AsJ_Z-Di_K7Ojt9zO4t3OPlOe0OjtH2jHfYSgm6OfxvxDPTJ0o8u-e7NOjJUAjTxgzjxp0xMRy3a4mAUjRxbB8OHHuQubmXYKUOQ7rdqNPbBFJTQmIy0PY6Rvf1EX7Q9f0z6XVKbNqwIUWpbtivClIvo84l-E4MXg4zt5BlYGWuRhrCc_rq6TRQ296yGCZLMB1fHdTW3HppYZc"/>
                <div class="absolute inset-0 bg-black/20 flex flex-col justify-center items-center text-white">
                    <h3 class="font-h2 text-h2 mb-4">Core Essentials</h3>
                    <p class="font-label-caps text-label-caps tracking-widest border-b border-white pb-1">Shop Now</p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection