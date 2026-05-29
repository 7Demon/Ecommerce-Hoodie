<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ─────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Collections & Product Detail — dynamic, driven by ProductsController
Route::get('/collections', [ProductsController::class, 'collections'])->name('collections');
Route::get('/details', [ProductsController::class, 'productDetail'])->name('details');

// Shopping Cart Routes
Route::get('/shopping-cart', [CartController::class, 'index'])->name('shopping-cart');
Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'destroy'])->name('cart.remove');

// Checkout Routes (accessible by guest and authenticated users)
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

// Order Success & Tracking (public)
Route::get('/orders/success/{orderNumber}', [OrderTrackingController::class, 'success'])->name('orders.success');
Route::get('/orders/track', [OrderTrackingController::class, 'showTrackForm'])->name('orders.track');
Route::post('/orders/track', [OrderTrackingController::class, 'track'])->name('orders.track.submit');

// Payment Webhook (no CSRF, called by Midtrans server)
Route::post('/payments/webhook', [PaymentWebhookController::class, 'handle'])
    ->name('payments.webhook');

// ─── Auth Routes (Breeze) ───────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ─── Authenticated User Routes ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // My Orders (customer)
    Route::get('/my-orders', [MyOrderController::class, 'index'])->name('my-orders');
    Route::get('/my-orders/{orderNumber}', [MyOrderController::class, 'show'])->name('my-orders.show');
});

// ─── Admin Routes (auth + role:admin) ──────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [ProductsController::class, 'index'])->name('admin');

    // Admin Products
    Route::post('/admin/products/add', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::put('/admin/products/{products}', [ProductsController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{products}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');

    // Admin Orders
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin-orders');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin-orders.show');
    Route::patch('/admin/orders/{order}/shipping', [AdminOrderController::class, 'updateShipping'])->name('admin-orders.shipping');
    Route::patch('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin-orders.status');
});
