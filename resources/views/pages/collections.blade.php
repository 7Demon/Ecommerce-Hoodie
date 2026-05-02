@extends('layouts.app')

@section('title', 'Collections')

@section('content')
<!-- Main Content Canvas -->
<main class="pt-32 pb-20 px-12 max-w-[1920px] mx-auto min-h-screen">
    <!-- Hero Header -->
    <header class="mb-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 border-b border-stone-200 pb-12">
            <div>
                <span class="font-label-caps text-label-caps text-on-secondary-container mb-4 block uppercase">Curated Apparel</span>
                <h1 class="font-h1 text-h1 text-primary">Collections</h1>
            </div>
            <p class="max-w-md font-body-lg text-body-lg text-secondary leading-relaxed">
            A discipline of form and fabric. Each piece is meticulously engineered to provide an investment in comfort and aesthetic longevity.</p>
        </div>
    </header>
    <div class="flex flex-col md:flex-row gap-16">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0 space-y-12">
            <!-- Sort By -->
            <section>
                <h3 class="font-label-caps text-label-caps text-primary uppercase mb-6 tracking-widest">Sort By</h3>
                <div class="space-y-4">
                    <label class="flex items-center group cursor-pointer">
                        <input checked="" class="w-4 h-4 border-outline-variant text-primary focus:ring-primary-container rounded-none" name="sort" type="radio"/>
                        <span class="ml-3 font-body-md text-stone-600 group-hover:text-primary transition-colors">Newest</span>
                    </label>
                    <label class="flex items-center group cursor-pointer">
                        <input class="w-4 h-4 border-outline-variant text-primary focus:ring-primary-container rounded-none" name="sort" type="radio"/>
                        <span class="ml-3 font-body-md text-stone-600 group-hover:text-primary transition-colors">Price: Low to High</span>
                    </label>
                    <label class="flex items-center group cursor-pointer">
                        <input class="w-4 h-4 border-outline-variant text-primary focus:ring-primary-container rounded-none" name="sort" type="radio"/>
                        <span class="ml-3 font-body-md text-stone-600 group-hover:text-primary transition-colors">Price: High to Low</span>
                    </label>
                </div>
            </section>
            <!-- Color Filter -->
            <section>
                <h3 class="font-label-caps text-label-caps text-primary uppercase mb-6 tracking-widest">Color</h3>
                <div class="grid grid-cols-4 gap-4">
                    <button class="w-8 h-8 rounded-full bg-stone-900 border border-stone-200 ring-offset-2 ring-1 ring-transparent hover:ring-stone-400 transition-all"></button>
                    <button class="w-8 h-8 rounded-full bg-[#3d2b1f] border border-stone-200 ring-offset-2 ring-1 ring-transparent hover:ring-stone-400 transition-all"></button>
                    <button class="w-8 h-8 rounded-full bg-[#d2c4bc] border border-stone-200 ring-offset-2 ring-1 ring-transparent hover:ring-stone-400 transition-all"></button>
                    <button class="w-8 h-8 rounded-full bg-stone-100 border border-stone-200 ring-offset-2 ring-1 ring-transparent hover:ring-stone-400 transition-all"></button>
                </div>
            </section>
            <!-- Category -->
            <section>
                <h3 class="font-label-caps text-label-caps text-primary uppercase mb-6 tracking-widest">Essentials</h3>
                <ul class="space-y-3">
                    <li><a class="text-body-md text-stone-500 hover:text-primary transition-colors underline underline-offset-4 decoration-stone-200" href="#">Heavyweight Hoodies</a></li>
                    <li><a class="text-body-md text-stone-500 hover:text-primary transition-colors" href="#">Quarter-Zip Knits</a></li>
                    <li><a class="text-body-md text-stone-500 hover:text-primary transition-colors" href="#">Core Fleece</a></li>
                </ul>
            </section>
        </aside>
        <!-- Product Grid -->
        <div class="flex-grow">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-gutter gap-y-16">
                <!-- Product Card 1 -->
                <div class="group">
                    <div class="aspect-[3/4] overflow-hidden bg-white mb-6 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" data-alt="A premium chocolate brown heavyweight cotton hoodie presented against a minimalist off-white background with soft, natural lighting. The fabric texture is visible, suggesting high-quality dense weave and luxurious weight. The design is simple, featuring clean lines and a structured silhouette typical of high-end boutique fashion. Soft ambient shadows ground the garment in a serene, studio environment." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAaphg0_o20YwZZP-lXpRMuHz91F87YO5r4Ty41ghJj385x_UCNX-zPxKml-nmFRRSyv8ua11J7gZbyzTsH5gY8Xpe8_NNWLiuHD0mCQEVV3aTlnx5tONv0Zx2ZdtzDlwCrFF7BJjRVLttdq4MNSWB4Cm__5fJEoZr0NgmC93O8vHbUHkUowAvkJLAhx_uMQe4qTFQpnwi58akkx65B7KvA8CUEkcrrFMmRZiBVClZYgmO84iAaAUtJyLgtWpVG7KbX46HrB45dPOI"/>
                        <button class="absolute bottom-4 right-4 bg-primary text-white p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="material-symbols-outlined">add</span></button>
                    </div>
                    <div class="text-center">
                        <h3 class="font-h3 text-xl text-primary mb-1">Estate Hoodie</h3>
                        <p class="font-body-md text-secondary">$185.00</p>
                    </div>
                </div>
                <!-- Product Card 2 -->
                <div class="group">
                    <div class="aspect-[3/4] overflow-hidden bg-white mb-6 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" data-alt="An oversized stone-colored minimalist hoodie hanging in a bright, modern gallery-like setting. The lighting is diffused and high-key, creating a clean light-mode aesthetic that highlights the subtle tonal differences in the fabric. The garment features dropped shoulders and wide sleeves, embodying a relaxed yet sophisticated editorial style. No logos are visible, emphasizing the purity of form and material." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBCJcZETpp3Sg6NdCpUfsYsJ2nPjOi1qvjvjoBGp4NUEQDbam2k9pPb5V_irOOka7H9ng-yBbxphrGRxFNZh8WaX4Wp_pYJ6eGkCxmtBC8Q-h23jgJl10cbkbZ0bHT2P3XgWyoQU1yH8G24pPaTcp2Ry-127HQauv7TANoqKfu0VJREFnLpl8SmdtNArO3ArvnQZ5WSbkgA2SqsWU5pSlSA2YBV4rCvLA63xldRsnGq2VOySbbQCu-1urxpGsTCYUDa9wa6XBATmtw"/>
                        <button class="absolute bottom-4 right-4 bg-primary text-white p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="material-symbols-outlined">add</span></button>
                    </div>
                    <div class="text-center">
                        <h3 class="font-h3 text-xl text-primary mb-1">Structure Fleece</h3>
                        <p class="font-body-md text-secondary">$160.00</p>
                    </div>
                </div>
                <!-- Product Card 3 -->
                <div class="group">
                    <div class="aspect-[3/4] overflow-hidden bg-white mb-6 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" data-alt="A folded cream-colored knit hoodie resting on a warm wooden surface in a sun-drenched minimalist studio. The lighting creates gentle contrast and long, soft shadows, reflecting a boutique, quiet luxury atmosphere. The color palette is dominated by soft tans and pristine whites, creating a sense of calm and exclusivity. The weave of the luxury knit is the focal point, suggesting warmth and premium craftsmanship." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCD7-C1URDUgw9erpY1ogxQuk5xgvuXwwPYo2CGulX3Yw3_eLie7XgNMjoIum8CtSITgN_Egc17CSPCz9ehIAeCDNZkjC7gBOSxUx0vuqJX4LNRg1JZltB6O209fL1eLEdLgS8FZswtlOlTpp1DXPWNYaIPwtWnySAN04RIwkRLZ9n5kBbpIYoA6JyB67cBsR4uAbUdjjCmnr4mCeP4Gj6r0CkS8GFlOsWZnLv8DXHTlu4C-a6rmcd9yGeooZC4XcOeJ2bSDORQARY"/>
                        <div class="absolute top-4 left-4">
                            <span class="bg-primary-fixed text-primary px-3 py-1 font-label-caps text-[10px] tracking-widest uppercase">Sold Out</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="font-h3 text-xl text-primary mb-1">Atelier Knit</h3>
                        <p class="font-body-md text-secondary">$210.00</p>
                    </div>
                </div>
                <!-- Product Card 4 -->
                <div class="group">
                    <div class="aspect-[3/4] overflow-hidden bg-white mb-6 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" data-alt="A deep charcoal black hooded sweatshirt displayed with an artistic, asymmetric drape in a minimalist space. Bright studio lighting catches the architectural edges of the hood and cuffs, creating a high-contrast but elegant visual. The scene is clean, void of clutter, and uses a monochromatic palette to convey prestige and modern sophistication. Every fold of the garment is intentional, mirroring a fashion showroom display." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCvhi-ncL6xE3694IrkxuVZuN-N1tX7enitTLsQWUWe_mdl34BFUaZkm26dfaivVkf8pJgj3QborUaJg0lLxRQwOjUv7ogA8k-LHHuzIITYlkdCmvUTD7yAuKAdSCLpt31HuHtfXkmD85d5cO545_0YkRH8kZ4Dued-JQtAlNfKg2sO-mS9u2kI6Zkm6EGrfcpBA2qoKgtjsgV0ZZgt_yiQa12XU_yeeYawwkiolVyq7eBV05LH-3TmTM2FY3hCvlhE3_PjC9rLVZc"/>
                        <button class="absolute bottom-4 right-4 bg-primary text-white p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="material-symbols-outlined">add</span></button>
                    </div>
                    <div class="text-center">
                        <h3 class="font-h3 text-xl text-primary mb-1">Nocturne Pullover</h3>
                        <p class="font-body-md text-secondary">$175.00</p>
                    </div>
                </div>
                <!-- Product Card 5 -->
                <div class="group">
                    <div class="aspect-[3/4] overflow-hidden bg-white mb-6 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" data-alt="A soft sage green hoodie photographed in a bright, ethereal light. The setting is a minimalist interior with white textured walls and a simple stone plinth. The lighting is soft and flattering, emphasizing the garment's fluid drape and premium organic cotton texture. The overall aesthetic is clean, modern, and aligned with a single-brand luxury boutique focused on investment pieces." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCLjmDKG2DBSSPRZpp4Qibs3Gsz9DBCW75Q3-bIgGcxHwffXxS-VXsEK6VxwaCUR7Vn6aRG0JiPXgKOG1uheYinprEkj1bITZ5qYs-NbJZ2vPpDL6iclNXPM1FCxYZI5lIyTrfEwlyE83LF_8wSZhcdWcjZXPibVZI_2kIXiAEJB4FEPAF5gqr4bpAepw84GkaL-9HDQi49eKHlfkB0d9aIikyecEidr6pgCYTnDqpdZ9WB6upOId3XznVT1FFRsubX4Y0vhnKx8C0"/>
                        <button class="absolute bottom-4 right-4 bg-primary text-white p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="material-symbols-outlined">add</span></button>
                    </div>
                    <div class="text-center">
                        <h3 class="font-h3 text-xl text-primary mb-1">Canvas Hoodie</h3>
                        <p class="font-body-md text-secondary">$155.00</p>
                    </div>
                </div>
                <!-- Product Card 6 -->
                <div class="group">
                    <div class="aspect-[3/4] overflow-hidden bg-white mb-6 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" data-alt="An elegant camel-colored zip-up hoodie featuring polished metal hardware, shown in a high-key lighting environment. The warm brown tones of the fabric are balanced by the pristine white background, creating an editorial feel. The focus is on the tactile quality and the refined finishing details like the ribbed hem and subtle stitching. The mood is quiet, confident, and sophisticated." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB_eKicc97irzIzW8EdrUpyrbdCXNCQeRXhshBQMmRteMlmqzLRHpVvexWXuhDPErT4-i3XIedNXT4M4RrJg06b9963ay4eWdrw1Yp4jvqnQmUjSUpcCegwF5zI7Y5yWRIS-wuOMX21d1QUWzEo8TDbW0yQIKR87uRD1m1Jcpt4s4Pdx0hNQUGan_GzqWaW5lzKvJLI4SnOQjckK5RfaXD_W-eRWa15Qdx79lmatJf6vNOWqyi-OhqUhazoycVm9jn8uUUHFY8cx2g"/>
                        <button class="absolute bottom-4 right-4 bg-primary text-white p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="material-symbols-outlined">add</span></button>
                    </div>
                    <div class="text-center">
                        <h3 class="font-h3 text-xl text-primary mb-1">Signature Zip</h3>
                        <p class="font-body-md text-secondary">$195.00</p>
                    </div>
                </div>
            </div>
                <!-- Pagination / Load More -->
            <div class="mt-20 flex justify-center">
                <button class="px-12 py-4 bg-white border border-primary text-primary font-label-caps text-label-caps hover:bg-primary hover:text-white transition-all duration-300">
                 View All</button>
            </div>
        </div>
    </div>
</main>