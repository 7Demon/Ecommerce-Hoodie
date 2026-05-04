<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('pages.home');
});
Route::get('/about', function(){
    return view('about');
});
Route::get('/collections', function(){
    return view('pages.collections');
})->name('collections');
Route::get('/shopping-cart', function(){
    return view('pages.shoppingCart');
})->name('shopping-cart');
Route::get('/admin', function(){
    return view('pages.admin');
})->name('admin');