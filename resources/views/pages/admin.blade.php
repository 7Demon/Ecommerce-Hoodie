@extends('layouts.app')
@section('title', 'admin dashboard')
@section('content')
<main class="flex-1 flex flex-col min-w-0 overflow-hidden">
<!-- Header -->
    <header class="bg-surface px-5 py-5 sm:px-8 sm:py-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-surface-variant">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Manage Products</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">View, edit, and manage your inventory.</p>
        </div>
        @include('modal.add')
        <button onclick="openModal()" class="bg-primary text-on-primary px-8 py-3 rounded hover:bg-primary-container hover:text-on-primary-container transition-colors duration-300 flex items-center gap-2 shadow-[0_4px_14px_rgba(39,19,16,0.1)]">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span class="font-label-md text-label-md">Add New Product</span>
        </button>
    </header>
    <!-- Content Canvas -->
    <div class="flex-1 overflow-auto bg-background p-5 sm:p-8">
        <!-- Filters & Search Bar (Minimalist) -->
        <div class="mb-8 flex flex-col justify-between gap-4 lg:flex-row lg:items-center">
            <div class="relative w-full max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input class="w-full bg-surface-container-low border-b border-outline-variant px-10 py-3 font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:bg-surface transition-colors placeholder:text-on-surface-variant/50" placeholder="Search products..." type="text"/>
            </div>
            <div class="flex flex-wrap gap-4">
                <button class="px-4 py-2 border border-outline-variant rounded flex items-center gap-2 text-on-surface hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">filter_list</span>
                    <span class="font-label-md text-label-md">Filter</span>
                </button>
                <button class="px-4 py-2 border border-outline-variant rounded flex items-center gap-2 text-on-surface hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">sort</span>
                    <span class="font-label-md text-label-md">Sort</span>
                </button>
            </div>
        </div>
        <!-- Data Table (Glassmorphism/Card style) -->
        <div class="bg-surface rounded shadow-[0_20px_40px_rgba(62,39,35,0.03)] overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full min-w-225 text-left border-collapse">
                <thead>
                    <tr class="border-b border-surface-variant bg-surface-container-low/50">
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant w-16">Image</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Product Name</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Size</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Stock Level</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Reserved Stock</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Price</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-variant">
                <!-- Row 1 -->
                @forelse ($products as $product)
                    <tr class="hover:bg-surface-container-lowest transition-colors group ">
                        <td class="px-6 py-4 align-middle">
                            <img alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded bg-surface-variant" data-alt="Minimalist organic cotton hoodie in warm cream color, flat lay on light background" src="{{ $product->image }}"/>
                        </td>
                        <td class="px-6 py-4 align-middle">{{ $product->name }}</td>
                        <td class="px-6 py-4 align-middle">{{ $product->size }}</td>
                        <td class="px-6 py-4 align-middle">{{ $product->stock }}</td>
                        <td class="px-6 py-4 align-middle">{{ $product->reserved_stock }}</td>
                        <td class="px-6 py-4 align-middle">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 align-middle text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/20 rounded transition-colors" title="Delete">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-on-surface-variant">No products found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-surface-variant bg-surface-container-low/30 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <span class="font-label-md text-label-md text-on-surface-variant">Showing 1 to 4 of 24 entries</span>
                <div class="flex flex-wrap gap-1">
                    <button class="px-3 py-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors font-label-md text-label-md disabled:opacity-50" disabled="">Prev</button>
                    <button class="px-3 py-1 rounded bg-primary text-on-primary font-label-md text-label-md">1</button>
                    <button class="px-3 py-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors font-label-md text-label-md">2</button>
                    <button class="px-3 py-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors font-label-md text-label-md">3</button>
                        <span class="px-3 py-1 text-on-surface-variant">...</span>
                    <button class="px-3 py-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors font-label-md text-label-md">Next</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
