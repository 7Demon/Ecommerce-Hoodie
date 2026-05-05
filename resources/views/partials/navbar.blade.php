<nav class="fixed top-0 z-50 w-full border-b border-stone-100 bg-white/90 backdrop-blur-md shadow-[0_40px_40px_-15px_rgba(61,43,31,0.04)]">
    <div class="mx-auto flex h-16 max-w-[1920px] items-center justify-between px-5 md:h-20 md:px-12">
        <a class="font-serif text-xl font-light tracking-[0.14em] text-stone-900 md:text-2xl md:tracking-[0.2em]" href="{{ route('home') }}">HOODIEL</a>
        <div class="hidden gap-12 font-serif text-sm uppercase tracking-widest md:flex">
            <a class="{{ request()->routeIs('home') ? 'border-b border-stone-900 text-stone-900' : 'text-stone-500 hover:text-stone-900' }} pb-1 transition-colors duration-300" href="{{ route('home') }}">Shop</a>
            <a class="{{ request()->routeIs('collections') ? 'border-b border-stone-900 text-stone-900' : 'text-stone-500 hover:text-stone-900' }} pb-1 transition-colors duration-300" href="{{ route('collections') }}">Collections</a>
            <a class="{{ request()->routeIs('about') ? 'border-b border-stone-900 text-stone-900' : 'text-stone-500 hover:text-stone-900' }} pb-1 transition-colors duration-300" href="{{ route('about') }}">About</a>
        </div>
        <div class="flex items-center gap-2 text-stone-900 md:gap-5">
            <a aria-label="Shopping cart" class="flex min-h-11 min-w-11 items-center justify-center transition-opacity duration-300 hover:opacity-80" href="{{ route('shopping-cart') }}">
                <span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span>
            </a>
            <button aria-label="Account" class="hidden min-h-11 min-w-11 items-center justify-center transition-opacity duration-300 hover:opacity-80 md:flex" type="button">
                <span class="material-symbols-outlined" data-icon="person">person</span>
            </button>
            <button aria-expanded="false" aria-label="Open menu" class="flex min-h-11 min-w-11 items-center justify-center md:hidden" data-mobile-menu-toggle type="button">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>
    <div class="hidden border-t border-stone-100 bg-white px-5 py-5 md:hidden" data-mobile-menu>
        <div class="flex flex-col gap-4 font-serif text-sm uppercase tracking-widest">
            <a class="text-stone-900" href="{{ route('home') }}">Shop</a>
            <a class="text-stone-900" href="{{ route('collections') }}">Collections</a>
            <a class="text-stone-900" href="{{ route('about') }}">About</a>
        </div>
    </div>
</nav>
