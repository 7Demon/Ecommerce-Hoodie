@extends('layouts.app')
@section('title', 'admin dashboard')
@section('content')
{{-- Full-height flex column: header fixed, content scrolls --}}
<main class="flex-1 flex flex-col h-full min-w-0 overflow-hidden">

    <!-- Header — fixed, never scrolls -->
    <header class="shrink-0 bg-surface px-5 py-5 sm:px-8 sm:py-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-surface-variant">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Manage Products</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">View, edit, and manage your inventory.</p>
        </div>
        @include('modal.add')
        <button onclick="openModal()" class="bg-primary text-on-primary px-8 py-3 rounded hover:bg-primary-container hover:text-on-primary-container transition-colors duration-300 flex items-center gap-2 shadow-[0_4px_14px_rgba(39,19,16,0.1)] shrink-0">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span class="font-label-md text-label-md">Add New Product</span>
        </button>
    </header>

    <!-- Scrollable Content Area -->
    <div class="flex-1 min-h-0 flex flex-col overflow-hidden bg-background">

        <!-- Controls bar — fixed above table -->
        <div class="shrink-0 px-5 sm:px-8 py-4 flex items-center justify-between gap-4 border-b border-surface-variant bg-background">

            {{-- Flash success message --}}
            @if (session('success'))
                <div class="px-4 py-2 bg-green-50 border border-green-200 text-green-800 rounded-lg font-body-sm text-body-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-green-600">check_circle</span>
                    {{ session('success') }}
                </div>
            @else
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    Showing <span class="font-semibold text-on-surface">{{ $products->count() }}</span> of {{ $products->total() }} products
                </p>
            @endif

            <form method="GET" action="{{ route('admin') }}" class="flex items-center gap-2 shrink-0">
                <label class="font-label-sm text-label-sm text-on-surface-variant">Sort by:</label>
                <select name="sort" onchange="this.form.submit()"
                    class="border border-outline-variant rounded px-3 py-2 font-body-sm text-body-sm text-on-surface bg-surface hover:bg-surface-container focus:outline-none focus:border-primary transition-colors cursor-pointer">
                    <option value="latest"    {{ request('sort','latest') === 'latest'    ? 'selected' : '' }}>Newest</option>
                    <option value="oldest"    {{ request('sort') === 'oldest'             ? 'selected' : '' }}>Oldest</option>
                    <option value="name_asc"  {{ request('sort') === 'name_asc'           ? 'selected' : '' }}>Name A–Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc'          ? 'selected' : '' }}>Name Z–A</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc'          ? 'selected' : '' }}>Price ↑</option>
                    <option value="price_desc"{{ request('sort') === 'price_desc'         ? 'selected' : '' }}>Price ↓</option>
                </select>
            </form>
        </div>

        <!-- Product Table — only this area scrolls -->
        <div class="flex-1 min-h-0 flex flex-col overflow-hidden px-5 sm:px-8 py-4">
            <div class="flex-1 min-h-0 bg-surface rounded shadow-[0_20px_40px_rgba(62,39,35,0.03)] overflow-hidden flex flex-col">

                {{-- Scrollable table wrapper --}}
                <div class="flex-1 min-h-0 overflow-auto">
                    <table class="w-full text-left border-collapse" style="min-width: 900px;">
                        <thead class="sticky top-0 z-10 bg-surface border-b border-surface-variant">
                            <tr class="bg-surface-container-low/80">
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant w-16">Image</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Product Name</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Color</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Size</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Stock</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Reserved</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Price</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-variant">
                        @forelse ($products as $product)
                            <tr class="hover:bg-surface-container-lowest transition-colors group">
                                <td class="px-6 py-4 align-middle">
                                    <img alt="{{ $product->name }}"
                                        class="w-12 h-12 object-cover rounded bg-surface-variant"
                                        src="{{ $product->image }}"/>
                                </td>
                                <td class="px-6 py-4 align-middle font-body-md text-body-md text-on-surface">{{ $product->name }}</td>
                                <td class="px-6 py-4 align-middle">
                                    @if($product->color)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-stone-100 text-stone-700">
                                            {{ $product->color }}
                                        </span>
                                    @else
                                        <span class="text-on-surface-variant/40 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 align-middle font-body-md text-body-md text-on-surface">{{ $product->size }}</td>
                                <td class="px-6 py-4 align-middle font-body-md text-body-md
                                    {{ $product->stock <= 5 ? 'text-amber-600 font-semibold' : 'text-on-surface' }}">
                                    {{ $product->stock }}
                                </td>
                                <td class="px-6 py-4 align-middle font-body-md text-body-md text-on-surface">{{ $product->reserved_stock }}</td>
                                <td class="px-6 py-4 align-middle font-body-md text-body-md text-on-surface">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Edit Button --}}
                                        <button
                                            onclick="openEditModal({{ json_encode([
                                                'id'             => $product->id,
                                                'name'           => $product->name,
                                                'description'    => $product->description,
                                                'size'           => $product->size,
                                                'color'          => $product->color,
                                                'price'          => $product->price,
                                                'stock'          => $product->stock,
                                                'reserved_stock' => $product->reserved_stock,
                                            ]) }})"
                                            class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors"
                                            title="Edit">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>

                                        {{-- Delete Form --}}
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            onsubmit="return confirm('Delete \'{{ addslashes($product->name) }}\'? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/20 rounded transition-colors"
                                                title="Delete">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[48px] block mb-2 opacity-30">inventory_2</span>
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination — always visible at bottom of table card --}}
                <div class="shrink-0 border-t border-surface-variant px-6 py-3">
                    {{ $products->appends(request()->query())->links('partials.pagination') }}
                </div>

            </div>
        </div>

    </div>
</main>
@endsection
