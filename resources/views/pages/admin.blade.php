@extends('layouts.app')
@section('title', 'admin dashboard')
@section('content')
<main class="flex-1 flex flex-col min-w-0 overflow-hidden">
<!-- Header -->
    <header class="bg-surface px-8 py-6 flex items-center justify-between border-b border-surface-variant">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Manage Products</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">View, edit, and manage your inventory.</p>
        </div>
        <button class="bg-primary text-on-primary px-8 py-3 rounded hover:bg-primary-container hover:text-on-primary-container transition-colors duration-300 flex items-center gap-2 shadow-[0_4px_14px_rgba(39,19,16,0.1)]">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span class="font-label-md text-label-md">Add New Product</span>
        </button>
    </header>
    <!-- Content Canvas -->
    <div class="flex-1 overflow-auto p-8 bg-background">
        <!-- Filters & Search Bar (Minimalist) -->
        <div class="flex justify-between items-center mb-8 gap-4">
            <div class="relative w-full max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input class="w-full bg-surface-container-low border-b border-outline-variant px-10 py-3 font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:bg-surface transition-colors placeholder:text-on-surface-variant/50" placeholder="Search products..." type="text"/>
            </div>
            <div class="flex gap-4">
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
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-surface-variant bg-surface-container-low/50">
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant w-16">Image</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Product Name</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Category</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Stock Level</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Price</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-variant">
                <!-- Row 1 -->
                    <tr class="hover:bg-surface-container-lowest transition-colors group">
                        <td class="px-6 py-4">
                            <img alt="Minimalist organic cotton hoodie in warm cream color, flat lay on light background" class="w-12 h-12 object-cover rounded bg-surface-variant" data-alt="Minimalist organic cotton hoodie in warm cream color, flat lay on light background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCWErob8xzPoznEFwpskhjQKAc6gpw70Bmj1Xe8zgLqj2qRdchZGhHYPVOZg0fxnat3rIolxGthARZ-r77s6ZWNtM9vKPOvWUi4Xz1n3co4EYcPv5FerCqcgGS005LHekY3GsPLMSTd8v_tGh7QcLGbBRIZaXyp_hv3kDalpepGzp7Jo0Q3F5olYzmn_L1bp2XEvRwFnTIZBAMkuxLn9AqVuALY2rBWTsgCd2THCU1IK9EBB8DBL1cDceuIV_u0yG4FIQGscjNxSS0"/>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-headline-sm text-[16px] text-on-surface">The Essential Hoodie</div>
                            <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">SKU: HD-001-CR</div>
                        </td>
                        <td class="px-6 py-4 font-body-md text-body-md text-on-surface">Outerwear</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-secondary-container text-on-secondary-container font-label-md text-label-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            124 in stock</span>
                        </td>
                        <td class="px-6 py-4 font-body-md text-body-md text-on-surface">$185.00</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/20 rounded transition-colors" title="Delete">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-surface-variant bg-surface-container-low/30 flex items-center justify-between">
                <span class="font-label-md text-label-md text-on-surface-variant">Showing 1 to 4 of 24 entries</span>
                <div class="flex gap-1">
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