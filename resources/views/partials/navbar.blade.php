<nav class="fixed top-0 z-50 w-full border-b border-stone-100 bg-white/90 backdrop-blur-md shadow-[0_40px_40px_-15px_rgba(61,43,31,0.04)]">
    <div class="mx-auto flex h-16 max-w-[1920px] items-center justify-between px-5 md:h-20 md:px-12">
        <a class="font-serif text-xl font-light tracking-[0.14em] text-stone-900 md:text-2xl md:tracking-[0.2em]" href="{{ route('home') }}">HOODIEL</a>
        <div class="hidden gap-12 font-serif text-sm uppercase tracking-widest md:flex">
            <a class="{{ request()->routeIs('home') ? 'border-b border-stone-900 text-stone-900' : 'text-stone-500 hover:text-stone-900' }} pb-1 transition-colors duration-300" href="{{ route('home') }}">Shop</a>
            <a class="{{ request()->routeIs('collections') ? 'border-b border-stone-900 text-stone-900' : 'text-stone-500 hover:text-stone-900' }} pb-1 transition-colors duration-300" href="{{ route('collections') }}">Collections</a>
            <a class="{{ request()->routeIs('about') ? 'border-b border-stone-900 text-stone-900' : 'text-stone-500 hover:text-stone-900' }} pb-1 transition-colors duration-300" href="{{ route('about') }}">About</a>
        </div>
        <div class="flex items-center gap-2 text-stone-900 md:gap-5">
            @php $cartCount = app(\App\Services\CartService::class)->count(); @endphp
            <a aria-label="Shopping cart" class="relative flex min-h-11 min-w-11 items-center justify-center transition-opacity duration-300 hover:opacity-80" href="{{ route('shopping-cart') }}">
                <span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span>
                @if($cartCount > 0)
                    <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-primary text-[10px] font-bold text-on-primary">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            {{-- Profile Icon --}}
            @guest
                {{-- Guest: hover → dropdown, click → login --}}
                <div class="relative hidden md:flex" x-data="{ open: false }"
                     @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ route('login') }}"
                       aria-label="Account"
                       class="flex min-h-11 min-w-11 items-center justify-center transition-opacity duration-300 hover:opacity-80">
                        <span class="material-symbols-outlined" data-icon="person">person</span>
                    </a>

                    {{-- Hover Dropdown --}}
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute right-0 top-full w-44 origin-top-right rounded-sm border border-stone-100 bg-white py-1 shadow-lg"
                         style="display: none;">
                        <a href="{{ route('login') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-stone-600 transition-colors hover:bg-stone-50 hover:text-stone-900">
                            <span class="material-symbols-outlined text-base">login</span>
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-stone-600 transition-colors hover:bg-stone-50 hover:text-stone-900">
                            <span class="material-symbols-outlined text-base">person_add</span>
                            Create Account
                        </a>
                    </div>
                </div>
            @else
                {{-- Auth: hover → dropdown --}}
                <div class="relative hidden md:flex" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button aria-label="Account"
                            class="flex min-h-11 min-w-11 items-center justify-center transition-opacity duration-300 hover:opacity-80"
                            type="button">
                        <span class="material-symbols-outlined" data-icon="person" :style="open ? 'font-variation-settings: \'FILL\' 1' : ''">person</span>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute right-0 top-full mt-2 w-52 origin-top-right rounded-sm border border-stone-100 bg-white py-1 shadow-lg"
                         style="display: none;">
                        {{-- Nama pengguna --}}
                        <div class="border-b border-stone-100 px-4 py-3">
                            <p class="font-serif text-xs uppercase tracking-widest text-stone-400">Signed in as</p>
                            <p class="mt-0.5 truncate text-sm font-medium text-stone-900">{{ Auth::user()->name }}</p>
                        </div>

                        {{-- Admin Dashboard (khusus admin) --}}
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin') }}"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-stone-600 transition-colors hover:bg-stone-50 hover:text-stone-900">
                                <span class="material-symbols-outlined text-base">dashboard</span>
                                Admin Dashboard
                            </a>
                        @endif

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex w-full items-center gap-2.5 px-4 py-2.5 text-sm text-stone-600 transition-colors hover:bg-stone-50 hover:text-stone-900">
                                <span class="material-symbols-outlined text-base">logout</span>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @endguest

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
            <hr class="border-stone-100">
            @guest
                <a class="text-stone-500 hover:text-stone-900" href="{{ route('login') }}">Sign In</a>
                <a class="text-stone-500 hover:text-stone-900" href="{{ route('register') }}">Create Account</a>
            @else
                @if(Auth::user()->isAdmin())
                    <a class="text-stone-500 hover:text-stone-900" href="{{ route('admin') }}">Admin Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-left font-serif text-sm uppercase tracking-widest text-stone-500 hover:text-stone-900">Sign Out</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
