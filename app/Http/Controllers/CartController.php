<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();
        
        return view('pages.shoppingCart', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $this->cartService->add(
            $request->product_id,
            $request->qty,
            $request->size,
            $request->color
        );

        return redirect()->route('shopping-cart')->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|string',
            'qty' => 'required|integer|min:0',
        ]);

        $this->cartService->update($request->cart_id, $request->qty);

        return redirect()->route('shopping-cart')->with('success', 'Cart updated successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|string',
        ]);

        $this->cartService->remove($request->cart_id);

        return redirect()->route('shopping-cart')->with('success', 'Item removed from cart.');
    }
}
