<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::latest()->paginate(10);
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'size' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'reserved_stock' => ['nullable', 'integer', 'min:0'],
        ]);
        $imagePath = $request->file('image');
        $imageName = uniqid() . '.' . $imagePath->extension();
        $imagePath->move(public_path('images'), $imageName);

        unset($validate['image']);
        $validate['image'] ='/images/' . $imageName;
        $validate['reserved_stock'] = $validate['reserved_stock'] ?? 0;
        Product::create($validate);
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
        //
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'size' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'reserved_stock' => ['nullable', 'integer', 'min:0'],
        ]);
        if ($request->hasFile('image')) {
            $oldImagePath = public_path($products->image);
            if (is_file($oldImagePath)) {
                unlink($oldImagePath);
            }
            $image = $request->file('image');
            $imageName = uniqid('product_', true) . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);

            $validate['image_url'] = '/images/' . $imageName;
            }
        unset($validate['image']);
        $validate['reserved_stock'] = $validate['reserved_stock'] ?? 0;
        
        $products->update($validate);
        return redirect()->route('admin')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $products)
    {
        //
        $imagePath = public_path(ltrim($products->image_url, '/'));
        if (is_file($imagePath)) {
            unlink($imagePath);
        }
        $products->delete();
        return redirect()->route('admin')->with('success', 'Product deleted successfully');
    }
}
