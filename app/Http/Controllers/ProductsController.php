<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'latest');

        $query = Product::query();

        match ($sort) {
            'oldest'     => $query->oldest(),
            'name_asc'   => $query->orderBy('name', 'asc'),
            'name_desc'  => $query->orderBy('name', 'desc'),
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),  // 'latest'
        };

        $products = $query->paginate(10);
        return view('pages.admin', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the public collections/shop page.
     * Products with the same name are grouped — only one card per unique name.
     * Each grouped item carries an `images` array (all unique variant images)
     * for the hover slideshow on the card.
     */
    public function collections(Request $request)
    {
        $sort = $request->query('sort', 'latest');

        // Fetch all products, group by name in PHP so we can collect every unique image
        $grouped = Product::all()->groupBy('name')->map(function ($variants, $name) {
            $first        = $variants->sortBy('id')->first();
            $uniqueImages = $variants->pluck('image')->unique()->filter()->values()->toArray();

            return (object) [
                'name'        => $name,
                'price'       => $variants->min('price'),
                'image'       => $first->image,
                'images'      => $uniqueImages,
                'description' => $first->description,
                'stock'       => $variants->sum('stock'),
                'id'          => $first->id,
            ];
        });

        // Sorting
        $grouped = match ($sort) {
            'price_asc'  => $grouped->sortBy('price')->values(),
            'price_desc' => $grouped->sortByDesc('price')->values(),
            'name_asc'   => $grouped->sortBy('name')->values(),
            'name_desc'  => $grouped->sortByDesc('name')->values(),
            default      => $grouped->sortByDesc('id')->values(),
        };

        // Manual pagination
        $page    = max(1, (int) $request->input('page', 1));
        $perPage = 12;
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $grouped->slice(($page - 1) * $perPage, $perPage)->values(),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => route('collections')]
        );

        return view('pages.collections', compact('products', 'sort'));
    }

    /**
     * Display the public product detail page.
     * Groups variants by color, then by size within each color.
     */
    public function productDetail(Request $request)
    {
        $name = $request->query('name');

        // All rows for this product name, ordered by color then size
        $variants = Product::where('name', $name)
            ->orderBy('color')
            ->orderBy('size')
            ->get();

        if ($variants->isEmpty()) {
            abort(404);
        }

        // Build a color → [variants] map for the JS interactivity
        // colorVariants: { 'Deep Chocolate': [{id, size, price, stock, reserved_stock, image, color}], ... }
        $colorVariants = $variants->groupBy('color')->map(function ($items) {
            return $items->values();
        });

        // Representative product for name/description/price
        $product = $variants->first();

        // Unique colors list (ordered)
        $colors = $colorVariants->keys();

        return view('pages.productDetail', compact('product', 'variants', 'colorVariants', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['required', 'string'],
            'image'          => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'size'           => ['required', 'string', 'max:50'],
            'color'          => ['nullable', 'string', 'max:100'],
            'price'          => ['required', 'numeric', 'min:0'],
            'stock'          => ['required', 'integer', 'min:0'],
            'reserved_stock' => ['nullable', 'integer', 'min:0'],
        ]);

        $imageFile = $request->file('image');
        $imageName = uniqid('product_', true) . '.' . $imageFile->extension();
        $imageFile->move(public_path('images'), $imageName);

        unset($validated['image']);
        $validated['image'] = '/images/' . $imageName;
        $validated['reserved_stock'] = $validated['reserved_stock'] ?? 0;

        Product::create($validated);

        return redirect()->route('admin')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $products)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['required', 'string'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'size'           => ['required', 'string', 'max:50'],
            'color'          => ['nullable', 'string', 'max:100'],
            'price'          => ['required', 'numeric', 'min:0'],
            'stock'          => ['required', 'integer', 'min:0'],
            'reserved_stock' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            // Only delete the file if NO other product still references it
            $oldImagePath   = public_path(ltrim($products->image, '/'));
            $sharedByOthers = Product::where('image', $products->image)
                ->where('id', '!=', $products->id)
                ->exists();

            if (!$sharedByOthers && is_file($oldImagePath)) {
                unlink($oldImagePath);
            }

            $image     = $request->file('image');
            $imageName = uniqid('product_', true) . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = '/images/' . $imageName;
        } else {
            // Keep existing image
            unset($validated['image']);
        }

        $validated['reserved_stock'] = $validated['reserved_stock'] ?? 0;
        $products->update($validated);

        return redirect()->route('admin')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $products)
    {
        // Delete associated image file
        $imagePath = public_path(ltrim($products->image, '/'));
        if (is_file($imagePath)) {
            unlink($imagePath);
        }

        $products->delete();
        return redirect()->route('admin')->with('success', 'Product deleted successfully.');
    }
}
