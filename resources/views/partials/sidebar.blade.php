<aside class="hidden w-64 shrink-0 flex-col border-r border-surface-variant bg-surface-container-low md:flex h-full">
    <div class="p-6 shrink-0">
        <h1 class="font-display-lg text-4xl text-primary tracking-[0.2em]">HOODIES</h1>
        <p class="font-label-sm text-label-sm text-on-surface-variant mt-2">ADMINISTRATION</p>
    </div>
    <nav class="flex-1 min-h-0 overflow-y-auto px-4 py-6 space-y-2">
        {{-- <a class="flex items-center gap-3 px-4 py-3 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors duration-200" href="#">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">dashboard</span>
            <span class="font-label-md text-label-md">Dashboard</span>
        </a> --}}
        <a class="flex items-center gap-3 px-4 py-3 rounded {{ request()->routeIs('admin') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-colors duration-200" href="{{ route('admin') }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('admin') ? 1 : 0 }};">inventory_2</span>
            <span class="font-label-md text-label-md">Products</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded {{ request()->routeIs('admin-orders') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-colors duration-200" href="{{ route('admin-orders') }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('admin-orders') ? 1 : 0 }};">receipt_long</span>
            <span class="font-label-md text-label-md">Orders</span>
        </a>
    </nav>
    <div class="p-4 shrink-0 border-t border-surface-variant">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors duration-200">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">logout</span>
                <span class="font-label-md text-label-md">Sign Out</span>
            </button>
        </form>
    </div>
</aside>


