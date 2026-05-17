<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;


Route::get('/', function () {
    return view('pages.home');
})->name('home');
Route::get('/about', function(){
    return view('pages.about');
})->name('about');
Route::get('/collections', function(){
    return view('pages.collections');
})->name('collections');
Route::get('/shopping-cart', function(){
    return view('pages.shoppingCart');
})->name('shopping-cart');
Route::get('/details', function(){
    return view('pages.productDetail');
})->name('details');
    
Route::get('/admin', [ProductsController::class, 'index'])->name('admin');
Route::post('/admin/products/add', [ProductsController::class, 'store'])->name('admin.products.store');
Route::put('/admin/products/{products}', [ProductsController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{products}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');