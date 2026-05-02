<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('pages.home');
});
Route::get('/about', function(){
    return view('about');
});
Route::get('/collections', function(){
    return view('pages.collections');
})->name('collections');
