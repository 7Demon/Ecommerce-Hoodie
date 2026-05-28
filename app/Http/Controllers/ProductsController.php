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
     */
    public function collections(Request $request)
    {
        $sort = $request->query('sort', 'latest');

        // Pick one representative row per unique product name
        $query = Product::query()
            ->selectRaw('MIN(id) as id, name, MIN(price) as price, image, MIN(stock) as stock, description')
            ->groupBy('name', 'image', 'description');

        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            'name_desc'  => $query->orderBy('name', 'desc'),
            default      => $query->orderBy('id', 'desc'),
        };

        $products = $query->paginate(12);
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
