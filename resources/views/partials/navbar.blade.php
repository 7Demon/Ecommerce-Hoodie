<nav class="fixed top-0 w-full z-50 bg-white/90 dark:bg-stone-950/90 backdrop-blur-md border-b border-stone-100 dark:border-stone-900 shadow-[0_40px_40px_-15px_rgba(61,43,31,0.04)]">
    <div class="flex justify-between items-center h-20 px-12 max-w-[1920px] mx-auto">
        <div class="text-2xl font-serif font-light tracking-[0.2em] text-stone-900 dark:text-stone-100">ESTRELLA</div>
        <div class="hidden md:flex gap-12 font-serif text-sm tracking-widest uppercase">
            <a class="text-stone-900 dark:white border-b border-stone-900 dark:border-white pb-1 transition-opacity duration-500 hover:opacity-80" href="#">Shop</a>
            <a class="text-stone-500 dark:text-stone-400 hover:text-stone-900 dark:hover:text-stone-100 transition-colors duration-300" href="{{ route('collections') }}">Collections</a>
            <a class="text-stone-500 dark:text-stone-400 hover:text-stone-900 dark:hover:text-stone-100 transition-colors duration-300" href="#">About</a>
            <a class="text-stone-500 dark:text-stone-400 hover:text-stone-900 dark:hover:text-stone-100 transition-colors duration-300" href="#">Contact</a>
        </div>
        <div class="flex items-center gap-6 text-stone-900 dark:text-stone-100">
            <button class="hover:opacity-80 transition-opacity duration-500">
                <span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span>
            </button>
            <button class="hover:opacity-80 transition-opacity duration-500">
                <span class="material-symbols-outlined" data-icon="person">person</span>
            </button>
        </div>
    </div>
</nav>