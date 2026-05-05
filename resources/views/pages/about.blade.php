@extends('layouts.app')
@section('title', 'About Us')
@section('content')
<main class="antialiased bg-stone-50">
    <!-- Hero Section -->
    <section class="relative min-h-[80vh] md:min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover" data-alt="Minimalist textile studio" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBvAnYYP4PLtw7pLtHZKlDWN1MKnMFz0j-Jq2ecThrsxoBtUH4hbaeVTm8557WDNBdH_tCtkKw2vXm-qt5d870A4ESCO76Aht4A8w7Z3Y-GCFSBO8Ow3IGOIg7oLUlMxEqQpE6tz6FAlGTYt7U-lHEuyUSiF3fv0AfvbuzFc8uI5mZRDme6sRrBjMEf36v_VZnFMFIh0xoWEKuPQbVm2ZfwCNJTdA6_ls70kQfAevhfvYfWNj0esOR0fyd7xKU6nbx2Xtdo3f-aji0"/>
            <div class="absolute inset-0 bg-stone-900/30 md:bg-stone-900/20 transition-all duration-500"></div>
        </div>
        <div class="relative z-10 text-center px-6 mt-16 md:mt-0">
            <span class="font-label-sm text-xs md:text-sm text-stone-200 md:text-stone-900 tracking-[0.3em] block mb-4 md:mb-6">ESTABLISHED 2024</span>
            <h1 class="font-serif text-4xl md:text-6xl lg:text-7xl text-white md:text-primary mb-6 md:mb-8 max-w-4xl mx-auto leading-tight">The Anatomy of Quiet Comfort</h1>
            <p class="font-sans text-lg md:text-xl text-stone-200 md:text-secondary max-w-2xl mx-auto font-light italic">Refining the dialogue between nature and the skin.</p>
        </div>
    </section>

    <!-- Our Philosophy -->
    <section class="max-w-screen-2xl mx-auto px-6 md:px-12 lg:px-24 py-20 md:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-5 text-center lg:text-left">
                <span class="font-label-sm text-xs tracking-[0.2em] text-stone-500 block mb-4">OUR PHILOSOPHY</span>
                <h2 class="font-serif text-3xl md:text-5xl text-primary mb-6 md:mb-8">Slow Fashion, Deep Roots</h2>
                <p class="font-sans text-base md:text-lg text-stone-600 mb-6 leading-relaxed">
                    At Terra & Thread, we believe that true luxury is not found in speed, but in the deliberate pause. Our philosophy is rooted in the "Slow Fashion" movement—a commitment to creating pieces that transcend seasonal trends and withstand the test of time.
                </p>
                <p class="font-sans text-base md:text-lg text-stone-600 leading-relaxed">
                    Every garment is a study in structural elegance and tactile intimacy. We reject the frenetic pace of the modern industry in favor of a focused, artisanal approach that honors both the maker and the wearer.
                </p>
            </div>
            <div class="lg:col-span-7 flex justify-center lg:justify-end mt-10 lg:mt-0">
                <div class="relative w-full aspect-[4/5] max-w-md md:max-w-lg shadow-2xl rounded-xl overflow-hidden">
                    <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-1000" data-alt="Macro editorial photograph" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAodmg2nMuX1vml1lAYK_tPs5o5ks_89IO6e-74ZrFTIUixlAiZrFdMnb0MG8GjMU63eJ-7ESwShxccqeiuiGTx6zeQVpB8j6rynAPaNeiOgynzWsHQTCrCbIVOVM2Kwn4V_zhAXtPUTlroxFbjcTR8fGXD61xdg32SIc2nyt3DixcfPlAgDMe4JVSxL5MuC7RmGzge-INqVS63EiBCuUnweDausG3qJq2a2Q0qAJySt20PwBqLw1fMD-ziFv4Ft3gZuy1vRgn-030"/>
                </div>
            </div>
        </div>
    </section>

    <!-- Sustainability Bento -->
    <section class="bg-stone-100 py-20 md:py-32 px-6 md:px-12 lg:px-24">
        <div class="max-w-screen-2xl mx-auto">
            <div class="text-center mb-16 md:mb-20">
                <span class="font-label-sm text-xs text-stone-500 tracking-[0.2em] block mb-4 uppercase">Sustainability</span>
                <h2 class="font-serif text-3xl md:text-5xl text-primary">Ethical Integrity by Design</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <!-- Card 1 -->
                <div class="bg-white p-8 md:p-12 flex flex-col justify-between shadow-sm hover:shadow-xl rounded-2xl border border-transparent hover:border-stone-300 transition-all duration-500 group">
                    <div>
                        <div class="mb-8 w-14 h-14 flex items-center justify-center bg-stone-100 rounded-full group-hover:bg-stone-900 group-hover:text-white transition-colors duration-500">
                            <span class="material-symbols-outlined text-stone-700 group-hover:text-white" data-icon="eco">eco</span>
                        </div>
                        <h3 class="font-serif text-xl md:text-2xl text-primary mb-4">GOTS Organic</h3>
                        <p class="font-sans text-stone-600 leading-relaxed">Our cotton is harvested from pesticide-free fields, ensuring the health of the soil and the purity of the fibers that touch your skin.</p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-8 md:p-12 flex flex-col justify-between shadow-sm hover:shadow-xl rounded-2xl border border-transparent hover:border-stone-300 transition-all duration-500 group">
                    <div>
                        <div class="mb-8 w-14 h-14 flex items-center justify-center bg-stone-100 rounded-full group-hover:bg-stone-900 group-hover:text-white transition-colors duration-500">
                            <span class="material-symbols-outlined text-stone-700 group-hover:text-white" data-icon="location_on">location_on</span>
                        </div>
                        <h3 class="font-serif text-xl md:text-2xl text-primary mb-4">Guimarães, Portugal</h3>
                        <p class="font-sans text-stone-600 leading-relaxed">Crafted in a family-owned atelier in the heart of Portugal’s textile heritage, where fair wages and artisanal mastery are the standard.</p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white p-8 md:p-12 flex flex-col justify-between shadow-sm hover:shadow-xl rounded-2xl border border-transparent hover:border-stone-300 transition-all duration-500 group">
                    <div>
                        <div class="mb-8 w-14 h-14 flex items-center justify-center bg-stone-100 rounded-full group-hover:bg-stone-900 group-hover:text-white transition-colors duration-500">
                            <span class="material-symbols-outlined text-stone-700 group-hover:text-white" data-icon="cyclone">cyclone</span>
                        </div>
                        <h3 class="font-serif text-xl md:text-2xl text-primary mb-4">Circular Lifecycle</h3>
                        <p class="font-sans text-stone-600 leading-relaxed">Every scrap is repurposed. Our packaging is 100% compostable, and our garments are designed for infinite longevity.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Meet the Makers -->
    <section class="max-w-screen-2xl mx-auto px-6 md:px-12 lg:px-24 py-20 md:py-32">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
            <div class="lg:w-1/2 order-2 lg:order-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                    <div class="sm:mt-16 rounded-xl overflow-hidden shadow-xl">
                        <img class="w-full aspect-[3/4] object-cover hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDRWapu4CJvw4XbIYFDr72MD0W400GAS6yriG4SaWVN4g15WLGd240K-dMp964_LV2Lp3e1tg65njnyZ4AC19XGMAQKu8tiWEPQ2PpjepTZZXFdeviCuZAiM33qocbfJr_MZ_rbeoyyzPDw7ut-dOduTHK2NSnVGTVPOlsSPjFXyf5uWm9OeC1fHBqqwHVGyAD5naFvIBGOxlEluasEJOjBU4IrdTz7GSJBoFf4Z2T2whlkiaXI-OxUwd07T0xaQXPptsHn6JYyUTg"/>
                    </div>
                    <div class="rounded-xl overflow-hidden shadow-xl hidden sm:block">
                        <img class="w-full aspect-[3/4] object-cover hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBUPPLxntnlWjOEEGsXcl-bHFOBA-EJGA7-D1A0LW55OWBoEyFQEUYQcx_BMi__Qv3nk8kOvfm5li1H_JRoBdsEoLJIC_kbdQIm3Kj7zIja-DL594b7YArM7IdYlGNov6oCv-4B29KmowAPnwOB95DOi8Rvc13aepDGXrKB87o5BXZ1xxmF25LIif3wN_sI9TaefhKZOQFqhxa6-UntOxJDXr2zN9rW1F4NZSeLv2YkAmM6HXvCu3a64obMIhHgOn-rAKP43Ag3rbE"/>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 flex flex-col justify-center order-1 lg:order-2 text-center lg:text-left">
                <span class="font-label-sm text-xs text-stone-500 tracking-[0.2em] block mb-4">CRAFTSMANSHIP SPOTLIGHT</span>
                <h2 class="font-serif text-3xl md:text-5xl text-primary mb-6 md:mb-8">Meet the Hands that Hold the Thread</h2>
                <p class="font-sans text-lg md:text-xl text-stone-700 mb-8 leading-relaxed italic border-l-4 border-stone-300 pl-4 mx-auto lg:mx-0 max-w-lg">
                    "There is a silent language in a well-made seam. It speaks of patience, of respect for the material, and of a human touch that no machine can replicate."
                </p>
                <p class="font-sans text-base md:text-lg text-stone-600 leading-relaxed mb-8 max-w-lg mx-auto lg:mx-0">
                    Our makers are the heart of Terra & Thread. Based in Northern Portugal, they bring generations of expertise to every hoodie, tee, and trouser. By maintaining close, personal relationships with our atelier, we ensure that every piece is crafted with the same care and intention that inspired our first sketch.
                </p>
                <div class="flex justify-center lg:justify-start gap-4">
                    <button class="bg-stone-900 text-white px-8 md:px-10 py-4 text-xs md:text-sm font-semibold tracking-widest rounded-lg hover:bg-stone-700 hover:shadow-lg transition-all duration-300">DISCOVER THE PROCESS</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Visual Interlude -->
    <section class="w-full h-[40vh] md:h-[60vh] overflow-hidden">
        <img class="w-full h-full object-cover" data-alt="Portuguese cotton field at dusk" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2e02BabeF2TjYo8Ie6yeyYdKIXYNuECo78L_X-sOciLokmI-t9xK7Fjp6n_deOZ79zSOW0NL0_8qD6SXKqFSPmNxaiwRj0NkfOajtMAyFQ-TuLfNlB6xwB2YLSo5zbGY4EFmPkCNomUZdIRaF5MP-flZoVOdQ7jqKwtYacR57Ga7GxBevXMIop39fNKluKWvXcSxwg6O5KA8Qn10JgT8Xh_RP082R31zxQqNiWYALgQDix4IkMTnxSY4NWg00-fdbA8Bya2Vny30"/>
    </section>

    <!-- CTA Section -->
    <section class="py-20 md:py-32 text-center px-6 md:px-12 bg-white">
        <div class="max-w-2xl mx-auto">
            <h2 class="font-serif text-3xl md:text-5xl text-primary mb-4 md:mb-6">Join the Journey</h2>
            <p class="font-sans text-base md:text-lg text-stone-600 mb-8 md:mb-10">Sign up to receive our seasonal lookbooks and stories of sustainable innovation.</p>
            <form class="flex flex-col md:flex-row gap-4 max-w-lg mx-auto">
                <input class="flex-1 bg-transparent border-b-2 border-stone-200 py-3 px-4 focus:border-stone-900 outline-none transition-colors font-sans text-stone-900 placeholder-stone-400" placeholder="Your Email Address" type="email"/>
                <button class="bg-stone-900 text-white px-8 py-3 text-sm font-semibold tracking-widest hover:bg-stone-700 transition-colors" type="submit">SUBSCRIBE</button>
            </form>
        </div>
    </section>
</main>