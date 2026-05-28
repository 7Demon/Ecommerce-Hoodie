<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
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

Route::get('/shopping-cart', function () {
    return view('pages.shoppingCart');
})->name('shopping-cart');

// ─── Auth Routes (Breeze) ───────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ─── Authenticated User Routes ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Admin Routes (auth + role:admin) ──────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [ProductsController::class, 'index'])->name('admin');
    Route::get('/admin/orders', function () {
        return view('pages.orders');
    })->name('admin-orders');

    Route::post('/admin/products/add', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::put('/admin/products/{products}', [ProductsController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{products}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');
});
