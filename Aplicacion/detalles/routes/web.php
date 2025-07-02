<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/shop/home');
})->name('home');

Route::get('/admin', function () {
    return view('/admin/dashboard');
});

Route::get('/login', function () {
    return view('/shop/customer/login');
})->name('login');

Route::get('/forgot', function () {
    return view('/shop/customer/forgot');
})->name('forgot');

Route::get('/register', function () {
    return view('/shop/customer/register');
})->name('register');


Route::get('/about', function () {
    return view('/shop/pages/about');
})->name('about');

Route::get('/contact', function () {
    return view('/shop/pages/contact');
})->name('contact');

Route::get('/terms', function () {
    return view('/shop/pages/terms');
})->name('terms');

Route::get('/products', function () {
    return view('/shop/products/products');
})->name('products');

Route::get('/cart', function () {
    return view('/shop/checkout/cart');
})->name('cart');