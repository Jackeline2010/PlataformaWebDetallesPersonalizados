<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = \App\Models\Category::where('activo', true)
                                    ->orderBy('orden')
                                    ->get();
    
    $products = \App\Models\Product::with('categories')
                                  ->where('activo', true)
                                  ->orderBy('orden')
                                  ->orderBy('created_at', 'desc')
                                  ->get();
    
    return view('shop.home', compact('categories', 'products'));
})->name('home');

Route::get('/about', function () {
    return view('shop.pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('shop.pages.contact');
})->name('contact');

Route::get('/terms', function () {
    return view('shop.pages.terms');
})->name('terms');

Route::get('/products', function () {
    $categories = \App\Models\Category::where('activo', true)
                                    ->orderBy('orden')
                                    ->get();
    
    $products = \App\Models\Product::with('categories')
                                  ->where('activo', true)
                                  ->orderBy('orden')
                                  ->orderBy('created_at', 'desc')
                                  ->get();
    
    return view('shop.products.products', compact('categories', 'products'));
})->name('products');

Route::get('/gallery', function () {
    $galleries = \App\Models\Gallery::activeOrdered()->get();
    $histories = \App\Models\History::latest()->take(10)->get();
    return view('shop.pages.gallery', compact('galleries', 'histories'));
})->name('gallery');

Route::get('/cart', function () {
    return view('shop.checkout.cart');
})->name('cart');

Route::get('/order', function () {
    return view('shop.checkout.order');
})->name('order');

Route::get('/profile', function () {
    return view('shop.pages.profile');
})->name('profile');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin');

Route::get('/admin/invoices', function () {
    return view('admin.sales.invoices');
})->name('admin.invoices');

Route::get('/admin/orders', function () {
    return view('admin.sales.orders');
})->name('admin.orders');

Route::get('/admin/shipments', function () {
    return view('admin.sales.shipments');
})->name('admin.shipments');

Route::get('/admin/transactions', function () {
    return view('admin.sales.transactions');
})->name('admin.transactions');

Route::get('/admin/products', function () {
    return view('admin.catalog.products');
})->name('admin.products');

Route::get('/admin/categories', function () {
    return view('admin.catalog.categories');
})->name('admin.categories');

Route::get('/admin/inventory', function () {
    return view('admin.catalog.inventory');
})->name('admin.inventory');

Route::get('/admin/customers', function () {
    return view('admin.customers.customers');
})->name('admin.customers');

Route::get('/admin/reviews', function () {
    return view('admin.customers.reviews');
})->name('admin.reviews');

Route::get('/admin/customersreport', function () {
    return view('admin.reporting.customers');
})->name('admin.customersreport');

Route::get('/admin/salesreport', function () {
    return view('admin.reporting.sales');
})->name('admin.salesreport');

Route::get('/admin/productsreport', function () {
    return view('admin.reporting.products');
})->name('admin.productsreport');

Route::get('/admin/parameterssettings', function () {
    return view('admin.settings.parameters');
})->name('admin.parameterssettings');

Route::get('/admin/rolesssettings', function () {
    return view('admin.settings.roles');
})->name('admin.rolesssettings');

Route::get('/admin/userssettings', function () {
    return view('admin.settings.users');
})->name('admin.userssettings');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');